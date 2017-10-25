<?php
namespace dvizh\tree;

class Module extends \yii\base\Module
{
    public $adminRoles = ['superadmin', 'admin', 'administrator'];

    public function init()
    {
        parent::init();
    }
}
