<?php

namespace sergeymakinen\yii\tests;

use sergeymakinen\yii\tests\stubs\TestSession;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;

class TestCaseTest extends TestCase
{
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
}
