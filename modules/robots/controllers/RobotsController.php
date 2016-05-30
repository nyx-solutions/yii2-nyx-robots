<?php

    namespace nox\modules\robots\controllers;

    use nox\modules\robots\Module;
    use nox\mvc\web\Controller;

    /**
     * Class RobotsController
     *
     * @package nox\modules\robots\controllers
     */
    class RobotsController extends Controller
    {
        /**
         * @return string
         *
         * @throws \yii\base\InvalidConfigException
         */
        public function actionIndex()
        {
            /** @var Module $robotsGenerator */
            $robotsGenerator = $this->module;

            return '';
        }
    }
