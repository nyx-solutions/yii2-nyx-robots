<?php

    namespace nyx\modules\robots;

    use nyx\helpers\StringHelper;
    use Yii;
    use yii\base\InvalidConfigException;

    /**
     * Class Module
     *
     * @package nyx\modules\robots
     */
    class Module extends \yii\base\Module
    {
        /**
         * @var array
         */
        public array $settings = [];

        /**
         * @var array
         */
        protected array $defaultSettings = [
            'disallowAllRobots' => false,
            'allowAllRobots'    => false,
            'useSitemap'        => true,
            'sitemapFile'       => '/sitemap.xml',
            'robots'            => [],
            'allowRules'        => [],
            'disallowRules'     => []
        ];

        /**
         * @var bool
         */
        protected bool $allowAllRobots = false;

        /**
         * @var bool
         */
        protected bool $disallowAllRobots = false;

        /**
         * @var bool
         */
        protected bool $useSitemap = true;

        /**
         * @var string
         */
        protected string $sitemapFile = 'sitemap.xml';

        /**
         * @var array
         */
        protected array $allowRules = [];

        /**
         * @var array
         */
        protected array $disallowRules = [];

        /**
         * @var array
         */
        protected array $robots = [
            'all'                  => '*',
            'googlebot'            => 'Googlebot',
            'googlebot-mobile'     => 'Googlebot-Mobile',
            'googlebot-image'      => 'Googlebot-Image',
            'mediapartners-google' => 'Mediapartners-Google',
            'adsbot-google'        => 'Adsbot-Google',
            'slurp'                => 'Slurp',
            'msnbot'               => 'msnbot',
            'msnbot-media'         => 'msnbot-media',
            'teoma'                => 'Teoma'
        ];

        #region Initialization

        /**
         * @inheritdoc
         *
         * @throws InvalidConfigException
         */
        public function init()
        {
            $this->controllerNamespace = 'nyx\modules\robots\controllers';
            $this->viewPath            = '@nyx-solutions/robots/views';
            $this->layout              = false;
            $this->defaultRoute        = 'default/index';

            parent::init();

            Yii::setAlias('@nyx-solutions/robots', __DIR__);

            $this->verifyComponentRequirements();
        }

        /**
         * @return bool
         *
         * @throws InvalidConfigException
         */
        protected function verifyComponentRequirements()
        {
            if (!is_array($this->settings)) {
                throw new InvalidConfigException('');
            }

            if (!isset($this->settings['disallowAllRobots'])) {
                $this->disallowAllRobots = $this->defaultSettings['disallowAllRobots'];
            } else {
                $this->disallowAllRobots = (bool)$this->settings['disallowAllRobots'];
            }

            if (!isset($this->settings['allowAllRobots'])) {
                $this->allowAllRobots = $this->defaultSettings['allowAllRobots'];
            } else {
                $this->allowAllRobots = (bool)$this->settings['allowAllRobots'];
            }

            if ($this->settings['allowAllRobots']) {
                $this->disallowAllRobots = false;
            }

            if (!isset($this->settings['useSitemap'])) {
                $this->useSitemap = $this->defaultSettings['useSitemap'];
            } else {
                $this->useSitemap = (bool)$this->settings['useSitemap'];
            }

            if (!isset($this->settings['sitemapFile'])) {
                $this->sitemapFile = $this->defaultSettings['sitemapFile'];
            } else {
                $this->sitemapFile = (string)$this->settings['sitemapFile'];
            }

            if (is_array($this->settings['robots']) && count($this->settings['robots']) > 0) {
                foreach ($this->settings['robots'] as $robot) {
                    $this->addRobot($robot);
                }
            }

            if (!$this->allowAllRobots && !$this->disallowAllRobots) {
                if (is_array($this->settings['allowRules']) && count($this->settings['allowRules']) > 0) {
                    foreach ($this->settings['allowRules'] as $robot => $rules) {
                        $robotId = $this->getRobotId($robot);

                        if (!isset($this->allowRules[$robotId]) || !is_array($this->allowRules[$robotId])) {
                            $this->allowRules[$robotId] = [];
                        }

                        if (is_array($rules) && count($rules) > 0) {
                            foreach ($rules as $rule) {
                                $this->allowRules[$robotId][] = $rule;
                            }
                        }
                    }
                }

                if (is_array($this->settings['disallowRules']) && count($this->settings['disallowRules']) > 0) {
                    foreach ($this->settings['disallowRules'] as $robot => $rules) {
                        $robotId = $this->getRobotId($robot);

                        if (!isset($this->disallowRules[$robotId]) || !is_array($this->disallowRules[$robotId])) {
                            $this->disallowRules[$robotId] = [];
                        }

                        if (is_array($rules) && count($rules) > 0) {
                            foreach ($rules as $rule) {
                                $this->disallowRules[$robotId][] = $rule;
                            }
                        }
                    }
                }
            }

            return false;
        }
        #endregion

        #region Getters and Setters
        /**
         * @return array
         */
        public function getRobots()
        {
            return $this->robots;
        }

        /**
         * @param string $robot
         *
         * @return static
         */
        public function addRobot($robot)
        {
            $robotId = $this->getRobotId($robot);

            if (!isset($this->robots[$robotId])) {
                $this->robots[$robotId] = $robot;
            }

            return $this;
        }

        /**
         * @return array
         */
        public function getAllowRules()
        {
            return $this->allowRules;
        }

        /**
         * @param string $path
         * @param string $robot
         *
         * @return bool
         */
        public function addAllowRule($path, $robot)
        {
            $robotId = $this->getRobotId($robot);

            if ($this->robotExists($robot)) {
                if (!isset($this->allowRules[$robotId]) || !is_array($this->allowRules[$robotId])) {
                    $this->allowRules[$robotId] = [];
                }

                $this->allowRules[$robotId][] = (string)$path;

                return true;
            }

            return false;
        }

        /**
         * @return array
         */
        public function getDisallowRules()
        {
            return $this->disallowRules;
        }

        /**
         * @param string $path
         * @param string $robot
         *
         * @return bool
         */
        public function addDisallowRule($path, $robot)
        {
            $robotId = $this->getRobotId($robot);

            if ($this->robotExists($robot)) {
                if (!isset($this->disallowRules[$robotId]) || !is_array($this->disallowRules[$robotId])) {
                    $this->disallowRules[$robotId] = [];
                }

                $this->disallowRules[$robotId][] = (string)$path;

                return true;
            }

            return false;
        }

        /**
         * @param string $robot
         *
         * @return string
         */
        public function getRobotId($robot)
        {
            if ($robot == '*') {
                $robot = 'all';
            }

            return StringHelper::asSlug($robot);
        }

        /**
         * @param string $robotId
         *
         * @return string
         */
        public function getRobotName($robotId)
        {
            if ($robotId == '*') {
                $robotId = 'all';
            }

            if (isset($this->robots[$robotId])) {
                return $this->robots[$robotId];
            }

            return $this->robots['all'];
        }

        /**
         * @return array
         */
        public function getRobotsData()
        {
            return [
                'disallowAllRobots' => $this->disallowAllRobots,
                'allowAllRobots'    => $this->allowAllRobots,
                'useSitemap'        => $this->useSitemap,
                'sitemapFile'       => $this->sitemapFile,
                'allowRules'        => $this->allowRules,
                'disallowRules'     => $this->disallowRules,
                'robotsModule'      => $this
            ];
        }
        #endregion

        #region Verifications
        /**
         * @param string $robot
         * @param bool   $create
         *
         * @return bool
         */
        public function robotExists($robot, $create = true)
        {
            $robotId = $this->getRobotId($robot);

            if (!isset($this->robots[$robotId])) {
                if ((bool)$create) {
                    $this->addRobot($robot);

                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
        #endregion
    }
