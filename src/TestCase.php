<?php
/**
 * Common Yii 2 extension tests stuff.
 *
 * @see       https://github.com/sergeymakinen/yii2-tests
 * @copyright Copyright (c) 2016 Sergey Makinen (https://makinen.ru)
 * @license   https://github.com/sergeymakinen/yii2-tests/blob/master/LICENSE The MIT License
 */

namespace sergeymakinen\tests;

use yii\helpers\ArrayHelper;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyApplication();
    }

    /**
     * Creates a Yii 2 console application.
     *
     * @param array $config
     * @param string $class
     */
    protected function createConsoleApplication(array $config = [], $class = 'yii\console\Application')
    {
        new $class(ArrayHelper::merge([
            'id' => 'console-test',
            'basePath' => __DIR__,
            'vendorPath' => __DIR__ . '/../vendor',
        ], $config));
    }

    /**
     * Creates a Yii 2 web application.
     *
     * @param array $config
     * @param string $class
     */
    protected function createWebApplication(array $config = [], $class = 'yii\web\Application')
    {
        new $class(ArrayHelper::merge([
            'id' => 'web-test',
            'basePath' => __DIR__,
            'vendorPath' => __DIR__ . '/../vendor',
            'components' => [
                'request' => [
                    'enableCookieValidation' => false,
                    'scriptFile' => __DIR__ . '/index.php',
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
        if (!isset(\Yii::$app)) {
            return;
        }

        if (\Yii::$app->has('session', true)) {
            \Yii::$app->session->close();
        }
        \Yii::$app = null;
    }

    /**
     * Returns the reflected property.
     *
     * @param object|string $object
     * @param string $name
     *
     * @return \ReflectionProperty
     */
    protected function getProperty($object, $name)
    {
        $class = new \ReflectionClass($object);
        while (!$class->hasProperty($name)) {
            $class = $class->getParentClass();
        }
        return $class->getProperty($name);
    }

    /**
     * Returns the reflected method.
     *
     * @param object|string $object
     * @param string $name
     *
     * @return \ReflectionMethod
     */
    protected function getMethod($object, $name)
    {
        $class = new \ReflectionClass($object);
        while (!$class->hasMethod($name)) {
            $class = $class->getParentClass();
        }
        return $class->getMethod($name);
    }

    /**
     * Returns the private/protected property by its name.
     *
     * @param object|string $object
     * @param string $name
     *
     * @return mixed
     */
    protected function getInaccessibleProperty($object, $name)
    {
        $property = $this->getProperty($object, $name);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    /**
     * Sets the private/protected property value by its name.
     *
     * @param object|string $object
     * @param string $name
     * @param mixed $value
     */
    protected function setInaccessibleProperty($object, $name, $value)
    {
        $property = $this->getProperty($object, $name);
        $property->setAccessible(true);
        $property->setValue($value);
    }

    /**
     * Invokes the private/protected method by its name and returns its result.
     *
     * @param object|string $object
     * @param string $name
     * @param array $args
     *
     * @return mixed
     */
    protected function invokeInaccessibleMethod($object, $name, array $args = [])
    {
        $method = $this->getMethod($object, $name);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }
}
