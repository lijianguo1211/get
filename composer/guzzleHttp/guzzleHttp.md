### php的客户端包

* composer 安装 `composer require guzzlehttp/guzzle`

[composer搜索地址](https://packagist.org/packages/guzzlehttp/guzzle)

[中文文档地址](https://guzzle-cn.readthedocs.io/zh_CN/latest/overview.html)

* 使用时首先根据自己当前目录引入自动加载文件,然后引入这个客户端类 ``use GuzzleHttp\Client``

```php
<?php
require './vendor/autoload.php';

use GuzzleHttp\Client;
```
* 最重要的一步，我们要实例化这个客户端类 ``new Client()``

> 实例化这个客户端类的时候，有一点需要注意，如下：

```php
    public function __construct(array $config = [])
    {
        if (!isset($config['handler'])) {
            $config['handler'] = HandlerStack::create();
        } elseif (!is_callable($config['handler'])) {
            throw new \InvalidArgumentException('handler must be a callable');
        }

        // Convert the base_uri to a UriInterface
        if (isset($config['base_uri'])) {
            $config['base_uri'] = Psr7\uri_for($config['base_uri']);
        }

        $this->configureDefaults($config);
    }
```

这个在实例化的时候，可以看到这个配置的数组中呢，有最基本的两项：

1. ``[handle => '']``

这个一般我们是不需要单独设置的，除非有特殊特殊的要求，才需要自己来构造一些请求头，在这里，如果你设置了，那么它默认的
方法都会失效，也就是，它会按照你构造的来运行，这个时候，如果不是特别熟悉，就有可能会出错，所以官方建议不要动它

2. ``[base_uri => '']``

这一个就没有什么要求了，因为它就是一个uri,就是我们请求的相对uri,当然这里可以不填写，当然，对于大量相同的请求的uri.
那么这里是可以填写的，比如我的所有请求的uri的格式都是以 ``http://www.baidu.com``开头的，这里就可以写

##### 普通的get请求
##### 普通的post请求
##### 普通的put请求
##### 普通的delete请求
##### 普通的patch请求
##### 普通的head请求
##### 普通的options请求

##### 异步请求
##### 并发请求
##### 上传文件
