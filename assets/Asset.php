<?php
namespace usesgraphcrt\certificate\assets;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public $js = [
        'js/certificate.js',
    ];

    public $css = [
        'css/styles.css',
    ];

    public function init()
    {
        $this->sourcePath = dirname(__DIR__).'/web';
        parent::init();
    }
}