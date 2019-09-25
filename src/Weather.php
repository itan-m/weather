<?php
/**
 * Created by PhpStorm.
 * User: a_he
 * Date: 2019/9/25
 * Time: 15:37
 */

namespace Itan\Weather;

use GuzzleHttp\Client;
use Itan\Weather\Exceptions\HttpException;
use Itan\Weather\Exceptions\InvalidArgumentException;

class Weather
{
    protected $key;
    protected $guzzleOptions = [];

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * @param string $city 输入城市的adcode，adcode信息可参考 https://lbs.amap.com/api/webservice/download
     * @param string $type 可选值：base/all base:返回实况天气 all:返回预报天气
     * @param string $format 可选值：JSON,XML
     * @return mixed|string
     * @throws HttpException
     * @throws InvalidArgumentException
     * @author a_he
     */
    public function getWeather($city, string $type = 'base', string $format = 'JSON')
    {
        if (!in_array(strtolower($format), ['xml', 'json'])) {
            throw new InvalidArgumentException('Invalid response format: ' . $format);
        }

        if (!in_array(strtolower($type), ['base', 'all'])) {
            throw new InvalidArgumentException('Invalid type value(base/all): ' . $type);
        }

        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        //封装 query 参数，并对空值进行过滤。
        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'extensions' => $type,
            'output' => $format
        ]);
        try {
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();

            return 'json' === strtolower($format) ? json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
