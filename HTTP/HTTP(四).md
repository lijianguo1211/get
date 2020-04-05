### HTTP学习了解四

* 首部字段解读

-------------------------

* 表示是否能缓存的指令

**[public]指令：** 当表明使用public指令的时候，表示其它用户也可以利用缓存

**[private]指令：** private指令表示响应只以特定的用户作为对象

**[no-cache]指令：** 为了防止从缓存中返回过期的资源，表示客户端不会接收缓存过的响应，服务器中包含[no-cache]指令，那么缓存服务器不能对资源
进行缓存，源服务器以后也将不再对缓存服务器请求中提出的资源有效进行确认，且禁止其对响应资源进行缓存操作。

**[no-store]指令：** 控制可执行缓存的对象的指令。当使用no-store指令时，暗示请求或响应中包含机密信息，该指令规定缓存不能在本地存储请求或响
应的任一部分。

**[s-maxage]指令：** s-maxage指令只适用于供多位用户使用的公共缓存服务器。

**[max-age]指令：** max-age数值代表资源保存为缓存的最长时间。当值为 0，代表缓存服务器通常需要将请求转发给源服务器。

**[min-fresh]指令：** 此指令要求缓存服务器返回至少还未过指定时间的缓存资源。

**[max-stale]指令：** 可指示缓存资源，即使过期也照常接受。

**[only-if-cached]指令：** 使用only-if-cached指令表示客户端仅在缓存服务器本地缓存目标资源情况下才会要求其返回。
该指令要求缓存服务器不重新加载响应，也不会再次确认资源有效性。

**[must-revalidate]指令：** 代理服务器会向源服务器再次验证即将返回的响应缓存目前是否仍然有效。
使用must-revalidate指令会忽略请求的max-stale指令。

**[proxy-revalidate]指令：** 该指令要求所有的缓存服务器在接收到客户端带有该指令的请求返回响应之前，必须再次验证缓存的有效性。

**[no-transform]指令：** 使用no-transform指令规定无论是在请求还时响应中，缓存都不能改变实体主体的媒体类型，这样做可防止缓存或代理压缩图
片等类似操作。

* `Connection` 控制不再转发给代理的首部字段，管理持久连接

* `Date` 首部字段表明创建HTTP报文的日期和时间

* `Transfer-Encoding` 规定了传输报文主体时采用的编码方式

* `Upgrade` 用于检测HTTP协议及其它协议是否可使用更高的版本通信，其参数值可以用来指定一个完全不同的通信协议。使用首部字段`Upgrade`时，还需
要额外指定`Connection:Upgrade`

* `Via` 为了追踪客户端与服务器之间的请求或响应报文的传输路径。

----------------------------------------------

#### 请求首部字段

* `Accept` 该首部字段可通知服务器，用户代理能够处理的媒体类型以及媒体类型的相对优先级。

1. 文本文件 `text/html,text/plain,text/css,application/xhtml+xml,application/xml`

2. 图片文件 `image/jpeg,image/gif,image/png`

3. 视频文件 `video/mpeg,video/quicktime`

4. 二进制文件 `application/octet-stream,application/zip`

5. 给显示媒体文件增加权重（优先级），使用 `q=0-1`,默认的权重是`q=1`

* `Accept-Charset` 用来通知服务器用户代理支持的字符集及字符集的相对优先顺序

* `Accept-Encoding` 告知服务器用户代理的内容编码及内容编码的优先级顺序（可一次性指定多种内容编码）

* `gzip` 由文件压缩程序gzip生成的编码格式

* `compress` 由UNIX文件压缩程序compress生成的编码格式

* `default` 组合使用`zlib`格式及由default压缩算法生成的编码格式

* `identity` 不执行压缩或不会变化的默认编码格式

* `Accept-Language` 告知服务器用户代理能够处理的自然语言集

* `Authorization` 告知服务器用户代理的认证信息

* `Expect` 告知服务器期望出现的某种特定行为

* `From` 告知服务器使用用户代理的用户电子邮箱

* `Host` 告知服务器，请求的资源所处的互联网主机名和端口号

* `If-Match` 条件请求，服务器接收到附带条件的请求后，只有判定条件为真时，才会执行清华

* `If-Modified-Since` 附带的条件请求，告知服务器字段值早于资源的更新时间，则希望能处理该请求

* `Proxy-Authorization` 接收到从代理服务器发送来的认证质询时，客户端会发送包含首部字段 `Proxy-Authorization`的请求，以告知服务器认证
所需要的信息

* `Range` 对于只获取部分资源的范围请求，包含首部字段 `Range` 即可告知服务器资源的指定范围

* `Referer` 告知服务器请求的原始资源的`URI`

* `TE` 告知服务器客户端能够处理响应的传输编码方式以及相对优先级

* `User-agent` 用于传达浏览器的种类


#### 响应首部字段

* `Accept-Ranges` 当不能处理范围请求时，服务器会 `Accept-Ranges:none`,可以处理时是具体的`byte`

* `Age` 告知客户端，服务端在多久前创建了响应，字段值为秒

* `ETag` 告知客户端的实体标识，它是一种可将资源以字符串形式做唯一性标识的方式，服务器会为每一份资源分配对应的`ETag`值

* `Location` 可以将响应接收方式导至某个与请求`URI`位置不同的资源

* `Proxy-authenticate` 把由代理服务器所要求的认证信息发送给客户端

* `Server` 告知客户端当前服务器上安装的HTTP服务器的应用程序信息

* `WWW-Authenticate` 用于HTTP访问认证，它会告知客户端适用于访问请求URI所指定的认证方案


#### 实体首部字段

* `Allow` 告知客户端能够支持`Request-URI`指定资源的所有HTTP方法

* `Content-Encoding` 告知客户端服务器对实体的主体部分选用的内容编码方式

* `Content-Language` 告知客户端，实体主体使用的自然语言

* `Content-Length` 标识了实体主体部分的大小（byte）

* `Content-Location` 表示了报文主体返回资源对应的URI

* `Content-MD5` 客户端会对接收到的报文主体执行相同的MD5算法，然后与首部字段`Content-MD5`的字段值比较

* `Content-Range` 针对范围请求，返回响应时使用的首部字段，告知客户端作为响应返回的实体的那个部分符合范围请求

* `Content-Type` 说明了实体主体内对象的媒体类型

* `Expires` 告知客户端资源失效的日期

* `Last-Modified` 指明资源最终修改的时间

#### 为`cookie`服务的首部字段

* `set-cookie`

1. `name=value` 赋予cookie的名称和值

2. `expires=Data` cookie 的有效期（不指定，默认是关闭浏览器，失效）

3. `path=/` 将服务器上的文件目录作为cookie适用对象

4. `domain=域名` 作为cookie适用对象的域名

5. `secure` 仅在https安全通信是才会发送cookie

6. `HttpOnly` 加以限制，使cookie不能被JavaScript脚本访问

* `cookie` 首部字段cookie会告知服务器，当客户端想获得HTTP状态管理支持时，就在请求中包含从服务器接收到的cookie

