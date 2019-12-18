### HTTP学习了解（三）

* HTTP首部字段 HTTP首部字段是构成HTTP报文的要素之一。无论是请求还是响应都会使用首部字段，它起到传递额外重要信息的作用，使用首部字段是为了提
供浏览器和服务器提供报文主体大小，所使用的语言，认证信息等内容

* HTTP首部字段结构 ``首部字段名: 字段值``

* HTTP首部字段类型

1. 通用首部字段 ``General Header Feilds`` 请求报文和响应报文都会使用的报文

```http request
Cache-Control:控制缓存行为;

Connection:逐跳首部，连接的管理;

Date: 创建报文的时间;

Pragma: 报文指令;

Trailer: 报文末端的首部一览;

Transfer-Encoding: 指定报文主体的传输编码方式;

Upgrade: 升级为其它协议;

Via: 代理服务器的相关信息;

Warning: 错误通知;

```

2. 请求首部字段 ``Request Header Feilds`` 客户端向服务端发送请求使用的报文

```http request
Accept: 用户代理可处理的媒体类型;

Accept-Charset: 优先的字符集;

Accept-Encoding: 优先的内容编码

Accept-Language: 优先的语言

Authorization: web认证信息

Expect: 期待服务器的特定行为

From: 用户的电子邮箱地址

Host: 请求资源所在的服务器

If-Match: 比较实体标记

If-Modified-Since: 比较资源的更新时间

If-None-Match: 比较实体标记(与If-Match相反)

If-Range: 资源未更新时发送实体的byte请求

Max-Forwards: 最大传输逐跳数

Proxy-Authenticate: 代理服务器要求客户端的认证信息

Range: 实体的字节范围请求

Referer: 对请求中URI的原始获取方

TE: 传输编码的优先级

User-Agent: HTTP客户端程序的信息

```

3. 响应首部字段 ``Response Header Feilds`` 服务端向客户端返回报文信息所使用的报文

```http request
Accept-Ranges: 是否接受字节范围请求

Age: 推算资源创建经过的时间

Etag: 资源的匹配信息

Location: 令客户端重定向至指定的URI

Proxy-Authenticate: 代理服务器对客户端的认证信息

Retry-After: 对再次发送请求的的时机要求

Server: HTTP服务器的安装信息

Vary: 代理服务器缓存的管理信息

WWW-Authenticate: 服务器对客户端的认证信息

```

4. 实体首部字段 ``Entity Header Fields`` 针对请求报文和响应报文的实体部分使用的首部

```http request
Allow: 资源可支持的HTTP方法

Content-Encoding: 实体主体适用的编码方式

Content-Language: 实体主体的自然语言

Content-Length: 实体主体的大小

Content-Location: 替代对应资源的URI

Content-MD5: 实体主体的报文摘要

Content-Range: 实体主体的位置范围

Content-Type: 实体主体的媒体类型

Expires: 实体主体过期的日期时间

Last-Modified: 资源的最后修改日期

```

* End-to-end 首部和 Hop-by-hop首部

1. 端到端首部

分在此类别中的首部会转发给请求 / 响应对应的最终接受目标，且必须保存在由缓存生成的响应，另外规定它必须被转发

2. 逐跳首部

分在此类中的首部只对单次转发有效。会因通过缓存或代理不在转发

```http request
Connection:

Keep-Alive: 指定长连接

Proxy-Authenticate: 代理服务器对客户端的认证信息

Proxy-Authorization: 

Trailer: 报文末端的首部一览;

TE: 传输编码的优先级

Transfer-Encoding: 指定报文主体的传输编码方式;

Upgrade: 升级为其它协议;

```


* 通用首部字段

1. Cache-Control  可以控制缓存行为

```http request
#缓存请求指令

no-cache: 强制向源服务器再次验证

no-store: 不缓存请求或响应的任何内容

max-age=[秒]: 响应的最大age值

max-stale=[秒]: 接受已过期的响应

max-fresh=[秒]: 期望在指定的时间内的响应任有效

no-transform: 代理不可更改媒体的类型

only-if-cached: 从缓存获取资源

cache-extension: 新指令标记

```

```http request
# 缓存响应的指令

public: 可向任意方提供响应缓存

private: 向特定用户返回响应

no-cache: 缓存前必须先确定其有效性

no-store: 不缓存请求响应的任何内容

no-transform: 代理不可更改媒体的类型

mast-revalidate: 可缓存但必须向源服务器进行确认

s-maxage=[秒]: 公共缓存服务器响应的最大Age值

```





































