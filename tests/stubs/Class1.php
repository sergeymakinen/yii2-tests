<?php

namespace sergeymakinen\yii\tests\stubs;

use yii\base\Object;

class Class1 extends Object
{
    private $_private1 = 'private1';

    protected $_protected = 'protected1';

    private function _private1()
    {
        return 'private1';
    }

    protected function _protected()
    {
        return 'protected1';
    }
}
