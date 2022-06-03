<?php
namespace mdbfree3;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * MDB Free v3 AssetBundle
 */
class MdbFree3Asset extends AssetBundle
{
    public $sourcePath = '@vendor/mdbfree3';
    public $css = [
        'css/mdb.min.css',
        'css/style.css',
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
    ];
    public $js = [
        'js/mdb.min.js'
    ];
    public $depends = [
        //'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];


    public function init()
    {
        parent::init();
    }
}
