一个小的PHP框架，用于了解框架的运行过程
###项目目录结构
![](http://ww2.sinaimg.cn/large/8ef7c851gw1eqn2818i76j20kq0glmyn.jpg)

###入口文件 index.php
```php
<?php
    error_reporting(0);
    define('XSPHP','./xsphp');//定义入口文件
    define('APP','index');//定义项目的应用名称
    require XSPHP.'/xsphp.php';
?>
```
###URL访问方式
http://localhost/index.php/控制器名/方法名
