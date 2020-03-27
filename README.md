# Royalcms Live Component

## 安装

> 通过composer，这是推荐的方式，可以使用composer.json 声明依赖，或者运行下面的命令。

```
$ composer require royalcms/live
```

## 使用方法

#### 1 使用composer形式
```php
use Royalcms\Component\Live\Paas\Room;
use Royalcms\Component\Live\Paas\Document;

$config = [
	'app_id' => 'xxxx', // 控制台中获取
	'secret_key' => 'xxx', // 控制台中获取
	'show_request_url' => false, // 是否显示构造请求连接&参数 json console (请勿在生产环境打开)
	'show_request_data' => false, // 是否显示接口返回数据 json console (请勿在生产环境打开)
];

// 实例化直播对象
$roomObj = new Room($config);

// 创建房间
$resultCreate = $roomObj->create();

// 获取房间列表
$resultList = $roomObj->lists();

// 实例化文档对象
$roomObj = new Document($config);

// 文档参数填写
$params = [
	// 文档要写绝对路径
    'document' => __DIR__. "/test.pptx"
];

// 创建文档
$resultCreate = $roomObj->create($params);

```

#### 2 直接引入使用
```php
// 创建房间
$resultCreate = RC_Live::room()->create($params);

var_dump($resultCreate);
```

## 常见问题

- 使用原生PHP异常处理错误，请使用catch(Exception $e) 进行捕获

## 代码许可

The MIT License (MIT).

[packagist]: http://packagist.org
[install-packagist]: https://packagist.org/packages/royalcms/live
