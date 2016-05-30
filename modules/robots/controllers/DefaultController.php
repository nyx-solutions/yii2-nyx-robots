<?php

    namespace nox\modules\robots\controllers;

    use nox\modules\robots\Module;
    use nox\mvc\web\Controller;
    use yii\web\Response;

    /**
     * Class DefaultController
     *
     * @package nox\modules\robots\controllers
     */
    class DefaultController extends Controller
    {
        /**
         * @return string
         *
         * @throws \yii\base\InvalidConfigException
         */
        public function actionIndex()
        {
            /** @var Module $robots */
            $robots = $this->module;

            \Yii::$app->response->format = Response::FORMAT_RAW;

            $headers = \Yii::$app->response->headers;

            $headers->add('Content-Type', 'text/plain');

            return $this->render('index', $robots->getRobotsData());
        }
    }
