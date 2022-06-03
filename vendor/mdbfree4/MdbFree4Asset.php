<?php
namespace mdbfree4;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * MDB Free AssetBundle
 * @since 0.1
 */
class MdbFree4Asset extends AssetBundle
{
    public $sourcePath = '@vendor/mdbfree4';
    public $css = [
        'css/mdb.min.css',
    ];
    public $js = [
        'js/tether.min.js'
        'js/mdb.min.js'
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];


    public function init()
    {
        parent::init();
    }
}
