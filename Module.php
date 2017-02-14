<?php

namespace usesgraphcrt\certificate;


class Module extends \yii\base\Module
{

    public $targetModelList = null;
    public $clientModel = null;
    public $adminRoles = ['admin', 'superadmin'];

    public function init()
    {
        parent::init();

    }
}
