<?php

    namespace nox\modules\robots;

    use nox\helpers\StringHelper;
    use yii\base\InvalidConfigException;

    /**
     * Class Module
     *
     * @package nox\modules\robots
     */
    class Module extends \yii\base\Module
    {
        /**
         * @var string
         */
        public $controllerNamespace = 'nox\modules\robots\controllers';

        /**
         * @var string
         */
        public $viewPath = '@nox-robots-webroot/views';

        /**
         * @var string
         */
        public $layout = false;

        /**
         * @var string
         */
        public $defaultRoute = 'robots/index';

        /**
         * @var array
         */
        public $settings = [];

        /**
         * @var array
         */
        protected $defaultSettings = [
            'disallowAllRobots' => false,
            'allowAllRobots'    => false,
            'useSitemap'        => true,
            'sitemapFile'       => 'sitemap.xml',
            'robots'            => [],
            'allowRules'        => [],
            'disallowRules'     => []
        ];

        /**
         * @var bool
         */
        protected $allowAllRobots = false;

        /**
         * @var bool
         */
        protected $disallowAllRobots = false;

        /**
         * @var bool
         */
        protected $useSitemap = true;

        /**
         * @var string
         */
        protected $sitemapFile = 'sitemap.xml';

        /**
         * @var array
         */
        protected $allowRules = [];

        /**
         * @var array
         */
        protected $disallowRules = [];

        /**
         * @var array
         */
        protected $robots = [
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
         */
        public function init()
        {
            parent::init();

            \Yii::setAlias('@nox-robots-webroot', __DIR__);

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
                if (is_array($this->settings['robots']) && count($this->settings['robots']) > 0) {
                    foreach ($this->settings['robots'] as $robot) {
                        $this->addRobot($robot);
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
            $id = StringHelper::asSlug($robot);

            if (!isset($this->robots[$id])) {
                $this->robots[$id] = $robot;
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
            $robotId = StringHelper::asSlug($robot);

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
            $robotId = StringHelper::asSlug($robot);

            if ($this->robotExists($robot)) {
                if (!isset($this->disallowRules[$robotId]) || !is_array($this->disallowRules[$robotId])) {
                    $this->disallowRules[$robotId] = [];
                }

                $this->disallowRules[$robotId][] = (string)$path;

                return true;
            }

            return false;
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
            $robotId = StringHelper::asSlug($robot);

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
