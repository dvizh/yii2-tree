<?php

namespace dvizh\tree\assets;

use yii\web\AssetBundle;

class WidgetAsset extends AssetBundle {

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $js = [
        'js/scripts.js',
    ];
    public $css = [
        'css/styles.css',
    ];

    public function init() {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }

}
