<?php
namespace Steffenkong\Weather;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {

    // 延迟注册，它不会在框架启动就注册，而是当你调用到它的时候才会注册
    protected $defer = true;

    public function register() {
        var_dump(123);
        $this->app->singleton(Weather::class, function () {
            return new Weather(config('services.weather.key'));
        });
        $this->app->alias(Weather::class, 'weather');
    }

    public function provides() {
        return [
            Weather::class,
            'weather'
        ];
    }
}