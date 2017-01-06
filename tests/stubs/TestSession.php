<?php

namespace sergeymakinen\yii\tests\stubs;

use yii\web\Session;

class TestSession extends Session
{
    /**
     * @inheritDoc
     */
    public function getIsActive()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return 'session_id';
    }
}
