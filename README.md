# curl
使用composer创建一个curl组件，用于简单的get和post请求。


## 如何使用

### 1、引入
<code>
    composer require lackone/curl
</code>

### 2、使用命名空间
<code>
    use Lackone\Curl;
</code>

### 3、get请求
<code>
    $data = Curl::get('http://www.baidu.com');
</code>

### 4、post请求
<code>
    $data = Curl::post('http://127.0.0.1/test', ['name' => 'test']);
</code>

### 5、上传文件
<code>
    $data = Curl::post('http://127.0.0.1/test', ['file' => '@./README.md']);
</code>
