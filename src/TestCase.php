<?php
/**
 * Yii 2 tests stuff
 *
 * @see       https://github.com/sergeymakinen/yii2-tests
 * @copyright Copyright (c) 2016-2017 Sergey Makinen (https://makinen.ru)
 * @license   https://github.com/sergeymakinen/yii2-tests/blob/master/LICENSE MIT License
 */

namespace sergeymakinen\yii\tests;

use yii\helpers\ArrayHelper;

abstract class TestCase extends \SergeyMakinen\Tests\TestCase
{
    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyApplication();
    }

    /**
     * Creates a Yii 2 console application.
     * @param array $config
     * @param string $class
     */
    protected function createConsoleApplication(array $config = [], $class = 'yii\console\Application')
    {
        new $class(ArrayHelper::merge([
            'id' => 'console-test',
            'basePath' => \Yii::getAlias('@tests'),
            'vendorPath' => \Yii::getAlias('@tests/../vendor'),
        ], $config));
    }

    /**
     * Creates a Yii 2 web application.
     * @param array $config
     * @param string $class
     */
    protected function createWebApplication(array $config = [], $class = 'yii\web\Application')
    {
        new $class(ArrayHelper::merge([
            'id' => 'web-test',
            'basePath' => \Yii::getAlias('@tests'),
            'vendorPath' => \Yii::getAlias('@tests/../vendor'),
            'components' => [
                'request' => [
                    'enableCookieValidation' => false,
                    'scriptFile' => \Yii::getAlias('@tests/index.php'),
                    'scriptUrl' => '/index.php',
                ],
            ],
        ], $config));
    }

    /**
     * Destroys an active Yii 2 application.
     */
    protected function destroyApplication()
    {
        if (\Yii::$app === null) {
            return;
        }

        if (\Yii::$app->has('session', true)) {
            \Yii::$app->session->close();
        }
        \Yii::$app = null;
    }
}
