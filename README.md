##简介

基于 [高德开放平台](https://lbs.amap.com/api/webservice/guide/api/weatherinfo) 的 PHP 天气信息组件。

## 安装

```shell
$ composer require itan/weather:dev-master
```

## 使用
```php
use Itan\Weather\Weather;

$key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$weather = new Weather($key);
```

####获取实时天气
```php
$response = $weather->getWeather('杭州');
```
####示例
```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "广东",
            "city": "深圳市",
            "adcode": "440300",
            "weather": "中雨",
            "temperature": "27",
            "winddirection": "西南",
            "windpower": "5",
            "humidity": "94",
            "reporttime": "2018-08-21 16:00:00"
        }
    ]
}
```

####获取近期天气预报
```php
$response = $weather->getWeather('杭州', 'all');
```

####获取 XML 格式返回值
第三个参数为返回值类型，可选 json 与 xml，默认 json：
```php
$response = $weather->getWeather('杭州', 'all', 'xml');
```

## 参考
[高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo)

## License

MIT