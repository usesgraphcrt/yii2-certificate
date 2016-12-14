<?php
namespace usesgraphcrt\certificate;

use yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if(!$app->has('certificate')) {
            $app->set('certificate', ['class' => 'usesgraphcrt\certificate\Certificate']);
        }
    }
}