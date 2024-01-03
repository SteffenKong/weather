<?php
namespace Steffenkong\Weather;

use GuzzleHttp\Client;
use Steffenkong\Weather\Exceptions\InvalidArgumentException;
use Steffenkong\Weather\Exceptions\HttpException;

class Weather {

    protected $key;

    protected $guzzleOptions = [];

    public function __construct(string $key) {
        $this->key = $key;
    }

    public function getHttpClient() {
        return new Client($this->guzzleOptions);
    }

    public function setHttpClientOptions(array $options) {
        $this->guzzleOptions = $options;
    }

    /**
     * $city - 城市名 / 高德地址位置 adcode，比如：“深圳” 或者（adcode：440300）
     * $type - 返回内容类型：base: 返回实况天气 / all: 返回预报天气
     * $format - 输出的数据格式，默认为 json 格式，当 output 设置为 “xml” 时，输出的为 XML 格式的数据
     * 根据城市 获取天气
     */
    public function getWeather($city, string $type = 'base', string $format = 'json') {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        if (!in_array(strtolower($format), ['json', 'xml'])) {
            // format参数传入异常的处理
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        if (!in_array(strtolower($type), ['base', 'all'])) {
            // type参数传入异常的处理
            throw new InvalidArgumentException('Invalid type value(base/all): '.$type);
        }

        // 构造查询参数
        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'output' => $format,
            'extensions' =>  $type
        ]);
        try {
            $response = $this->getHttpClient()->request('get', $url, [
                'query' => $query,
                'verify' => false
            ])->getBody()->getContents();
        } catch (\Exception $e) {
            // 客户端 请求失败的异常处理
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }


        return 'json' === $format ? \json_decode($response, true) : $response;
    }
}