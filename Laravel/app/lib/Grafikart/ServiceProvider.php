<?php
namespace Grafikart;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

    public function register(){
        $this->app->bindShared('bootform', function($app){
            return new BootForm($app['form'], $app['request'], $app['session']);
        });
    }


}