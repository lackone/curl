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

### 3、使用get和post方法
<code>
    //get请求
    $data = Curl::get('http://www.baidu.com');
    //post请求
    $data = Curl::post('http://127.0.0.1/test', ['name' => 'test']);
    //上传文件
    $data = Curl::post('http://127.0.0.1/test', ['file' => '@./README.md']);
</code>
