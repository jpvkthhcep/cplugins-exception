# cplugins-exception
异常警报

## 安装
项目根目录执行:
```
composer require cplugins/exception v1.0.3
```

## 配置
vendor/cplugins/exception/src/ExceptionAlert.php 文件 37行

配置异常推送的url

## 使用 
```
throw new UrgentException("很好", "57657");
```

## 输出
```
二级警报
项目名称： /workspace/php-project/i-admin-manage-pc-interface
调用方法： app\http\controllers\product\templatecontroller testlog
错误信息： 参数传入错误
堆栈信息： xxxx
```

## 优化
vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php文件 report方法修改如下
```
在方法最后追加以下代码
new UrgentException($e->getMessage(), $e->getCode(), null, $e);
```


