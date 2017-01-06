<?php

namespace sergeymakinen\yii\tests\stubs;

class Class2 extends Class1
{
    private $_private2 = 'private2';

    protected $_protected = 'protected2';

    private function _private2()
    {
        return 'private2';
    }

    protected function _protected()
    {
        return 'protected2';
    }
}
