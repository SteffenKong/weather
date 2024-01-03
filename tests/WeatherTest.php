<?php
namespace Steffenkong\Weather\Tests;

use PHPUnit\Framework\TestCase;
use Steffenkong\Weather\Exceptions\InvalidArgumentException;
use Steffenkong\Weather\Weather;

class WeatherTest extends TestCase {

    public function testGetWeather() {
        $w = new Weather('2b7c0285a348e44c215417e8169c23f1');
        // 断言会抛出此异常类
        $this->expectException(InvalidArgumentException::class);

        $w->getWeather('深圳', 'foo');

        $this->fail('Failed to assert getWeather throw exception with invalid argument.');
    }
}