<?php

namespace sergeymakinen\yii\tests;

use sergeymakinen\yii\tests\stubs\Class1;
use sergeymakinen\yii\tests\stubs\Class2;
use sergeymakinen\yii\tests\stubs\TestSession;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;

class TestCaseTest extends TestCase
{
    /**
     * @var array
     */
    protected $isParentMethodOverride = [];

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::tearDown()
     */
    public function testTearDown()
    {
        $this->assertNull(\Yii::$app);
        $this->createConsoleApplication();
        $this->assertInstanceOf(ConsoleApplication::className(), \Yii::$app);
        $this->tearDown();
        $this->assertNull(\Yii::$app);
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::isParentMethod()
     */
    public function testIsParentMethod()
    {
        $this->assertTrue($this->isParentMethod('getExpectedException'));
        $this->assertFalse($this->isParentMethod(__FUNCTION__));
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::createMock()
     */
    public function testCreateMock()
    {
        $expected = $this
            ->getMockBuilder(Class1::className())
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning();
        if (method_exists($expected, 'disallowMockingUnknownTypes')) {
            $expected->disallowMockingUnknownTypes();
        }
        $expected = $expected->getMock();
        $this->executeOverriddenAndParentMethod('createMock', function () use ($expected) {
            $this->assertEquals($expected, $this->createMock(Class1::className()));
        });
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::expectException()
     */
    public function testExpectExceptionOverridden()
    {
        $this->isParentMethodOverride = ['expectException' => false];
        $this->expectException('\Exception');
        throw new \Exception();
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::expectException()
     */
    public function testExpectExceptionOverriddenError()
    {
        $this->isParentMethodOverride = ['expectException' => false];
        $exception = null;
        try {
            $this->expectException([]);
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\PHPUnit_Framework_Exception', $exception);
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::expectException()
     */
    public function testExpectExceptionParent()
    {
        if (!parent::isParentMethod('expectException')) {
            $this->markTestIncomplete('`PHPUnit_Framework_TestCase::expectException` does not exist.');
            return;
        }

        $this->isParentMethodOverride = ['expectException' => true];
        $this->expectException('\Exception');
        throw new \Exception();
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::expectExceptionCode()
     */
    public function testExpectExceptionCodeOverridden()
    {
        $this->isParentMethodOverride = [
            'expectException' => false,
            'expectExceptionCode' => false,
        ];
        $this->expectException('\Exception');
        $this->expectExceptionCode(41);
        throw new \Exception('', 41);
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::expectExceptionCode()
     */
    public function testExpectExceptionCodeOverriddenError()
    {
        $this->isParentMethodOverride = ['expectExceptionCode' => false];
        $exception = null;
        try {
            $this->expectExceptionCode([]);
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\PHPUnit_Framework_Exception', $exception);
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::expectExceptionCode()
     */
    public function testExpectExceptionCodeParent()
    {
        if (!parent::isParentMethod('expectExceptionCode')) {
            $this->markTestIncomplete('`PHPUnit_Framework_TestCase::expectExceptionCode` does not exist.');
            return;
        }

        $this->isParentMethodOverride = ['expectExceptionCode' => true];
        $this->expectException('\Exception');
        $this->expectExceptionCode(41);
        throw new \Exception('', 41);
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::createConsoleApplication()
     */
    public function testCreateConsoleApplication()
    {
        $this->assertNull(\Yii::$app);
        $this->createConsoleApplication();
        $this->assertInstanceOf(ConsoleApplication::className(), \Yii::$app);
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::createWebApplication()
     */
    public function testCreateWebApplication()
    {
        $this->assertNull(\Yii::$app);
        $this->createWebApplication();
        $this->assertInstanceOf(WebApplication::className(), \Yii::$app);
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::destroyApplication()
     */
    public function testDestroyApplication()
    {
        $this->assertNull(\Yii::$app);

        $this->createConsoleApplication();
        $this->assertInstanceOf(ConsoleApplication::className(), \Yii::$app);
        $this->destroyApplication();
        $this->assertNull(\Yii::$app);

        $this->createWebApplication([
            'components' => [
                'session' => [
                    'class' => TestSession::className(),
                ],
            ],
        ]);
        $this->assertInstanceOf(WebApplication::className(), \Yii::$app);
        $this->assertSame('session_id', \Yii::$app->session->id);
        $this->destroyApplication();
        $this->assertNull(\Yii::$app);
    }

    /**
     * @covers \sergeymakinen\yii\tests\TestCase::getProperty()
     * @covers \sergeymakinen\yii\tests\TestCase::getInaccessibleProperty()
     * @covers \sergeymakinen\yii\tests\TestCase::setInaccessibleProperty()
     * @covers \sergeymakinen\yii\tests\TestCase::invokeInaccessibleMethod()
     */
    public function testGetSetInvoke()
    {
        $instance = new Class2();
        $this->assertSame('private1', $this->getInaccessibleProperty($instance, '_private1'));
        $this->assertSame('private2', $this->getInaccessibleProperty($instance, '_private2'));
        $this->assertSame('protected2', $this->getInaccessibleProperty($instance, '_protected'));
        $this->setInaccessibleProperty($instance, '_private1', '_private1');
        $this->setInaccessibleProperty($instance, '_private2', '_private2');
        $this->setInaccessibleProperty($instance, '_protected', '_protected2');
        $this->assertSame('_private1', $this->getInaccessibleProperty($instance, '_private1'));
        $this->assertSame('_private2', $this->getInaccessibleProperty($instance, '_private2'));
        $this->assertSame('_protected2', $this->getInaccessibleProperty($instance, '_protected'));
        $this->assertSame('private1', $this->invokeInaccessibleMethod($instance, '_private1'));
        $this->assertSame('private2', $this->invokeInaccessibleMethod($instance, '_private2'));
        $this->assertSame('protected2', $this->invokeInaccessibleMethod($instance, '_protected'));
    }

    protected function executeOverriddenAndParentMethod($name, \Closure $closure)
    {
        $this->isParentMethodOverride = [$name => false];
        call_user_func($closure);
        $this->isParentMethodOverride = [];

        if (!parent::isParentMethod($name)) {
            $this->markTestIncomplete('`PHPUnit_Framework_TestCase::' . $name . '` does not exist.');
            return;
        }

        $this->isParentMethodOverride = [$name => true];
        call_user_func($closure);
        $this->isParentMethodOverride = [];
    }

    /**
     * @inheritDoc
     */
    protected function isParentMethod($name)
    {
        if (!isset($this->isParentMethodOverride[$name])) {
            return parent::isParentMethod($name);
        } else {
            $value = $this->isParentMethodOverride[$name];
            unset($this->isParentMethodOverride[$name]);
            return $value;
        }
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->isParentMethodOverride = [];
    }
}
