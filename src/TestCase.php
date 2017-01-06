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

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $_expectedException;

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->_expectedException = null;
        $this->destroyApplication();
    }

    /**
     * Returns whether the class' parent method exists.
     * @param string $name
     * @return bool
     * @since 2.0
     */
    protected function isParentMethod($name)
    {
        return is_callable('parent::' . $name);
    }

    /**
     * Returns a test double for the specified class.
     * @param string $originalClassName
     * @return \PHPUnit_Framework_MockObject_MockObject
     * @since 1.1
     */
    protected function createMock($originalClassName)
    {
        if ($this->isParentMethod(__FUNCTION__)) {
            return parent::createMock($originalClassName);
        }

        return $this
            ->getMockBuilder($originalClassName)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->getMock();
    }

    /**
     * Sets an exception expected.
     * @param string $exception
     * @throws \PHPUnit_Framework_Exception
     * @since 2.0
     */
    public function expectException($exception)
    {
        if ($this->isParentMethod(__FUNCTION__)) {
            parent::expectException($exception);
            return;
        }

        if (!is_string($exception)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        $this->_expectedException = $exception;
        $this->setExpectedException($this->_expectedException);
    }

    /**
     * Sets an exception code expected.
     * @param int|string $code
     * @throws \PHPUnit_Framework_Exception
     * @since 2.0
     */
    public function expectExceptionCode($code)
    {
        if ($this->isParentMethod(__FUNCTION__)) {
            parent::expectExceptionCode($code);
            return;
        }

        if (!is_int($code) && !is_string($code)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(1, 'integer or string');
        }

        $this->setExpectedException($this->_expectedException, '', $code);
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

    /**
     * Returns the reflected property.
     * @param object|string $object
     * @param string $name
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
     * Returns the private/protected property by its name.
     * @param object|string $object
     * @param string $name
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
     * @param object|string $object
     * @param string $name
     * @param mixed $value
     */
    protected function setInaccessibleProperty($object, $name, $value)
    {
        $property = $this->getProperty($object, $name);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * Invokes the private/protected method by its name and returns its result.
     * @param object|string $object
     * @param string $name
     * @param array $args
     * @return mixed
     */
    protected function invokeInaccessibleMethod($object, $name, array $args = [])
    {
        $method = new \ReflectionMethod($object, $name);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }
}
