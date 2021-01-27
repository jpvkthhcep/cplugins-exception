<?php

namespace Cplugins\Exception;

use Cplugins\Log\LogHelper;
use Exception;

/**
 * 异常报警处理
 */
class ExceptionAlert 
{
    /**
     * 调用消息中心报警-通过钉钉推送
     */
    public static function alert($exception)
    {
        try {
            
            // 换行符
            $line = "\r\n";
            // 获取项目信息
            $projectInfo = base_path();
            // 异常级别
            $alertLevel = self::getAlertLevel($exception);
            // 获取异常类的调用者信息
            $caller = self::getCallerInfo($exception);
            // 获取异常信息
            $exceptionInfo = self::getException($exception);
            // 微服务
            $address = "项目名称：".$projectInfo;
            // 调用方法
            $exception = "调用方法：". $caller[0]." ".$caller[1] .$line;
            // $address = $caller[0]." ".$caller[1];
            $exception .= "错误信息：". $exceptionInfo[1].$line;
            $exception .= "堆栈信息：".$exceptionInfo[2];
            $result = self::curl_post(ExceptionConfig::dingUrl, ["level"=>$alertLevel, "address"=>$address, "exception"=>$exception]);
            return $result;
        } catch (Exception $e) {
            var_dump($e->getMessage(), "错误消息");
            // $log = new LogHelper();
            // $log->error($e->getMessage());
        }
        
    }

    /* 
   * url:访问路径 
   * array:要传递的数组 
   * */
  public static function curl_post($url,$array){ 
  
        $curl = curl_init(); 
        //设置提交的url 
        curl_setopt($curl, CURLOPT_URL, $url); 
        //设置头文件的信息作为数据流输出 
        curl_setopt($curl, CURLOPT_HEADER, 0); 
        //设置获取的信息以文件流的形式返回，而不是直接输出。 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
        //设置post方式提交 
        curl_setopt($curl, CURLOPT_POST, 1); 
        //设置post数据 
        $post_data = $array; 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); 
        //执行命令 
        $data = curl_exec($curl); 
        //关闭URL请求 
        curl_close($curl); 
    //获得数据并返回 
        return $data; 
  } 

    /**
     * 获取异常信息
     */
    private static function getException($exception) 
    {
        $code = $exception->getCode();
        $message = $exception->getMessage();
        $trace = $exception->getTraceAsString();
        return [$code, $message, $trace];
    }

    /**
     * 获取调用者信息
     */
    private static function getCallerInfo($exception)
    {
        $index = 0;
        $trace = $exception->getTrace();
        $class = isset($trace[$index]["class"]) ? $trace[$index]["class"] : null;
        $function = isset($trace[$index]["function"]) ? $trace[$index]["function"] : null;
        return [$class, $function];
    }

    /**
     * 获取警报等级
     */
    private static function getAlertLevel($exception)
    {
        $title = "二级警报";
        if ($exception instanceof ImmediateException) {
            $title = "一级警报";
        }

        if ($exception instanceof UrgentException) {
            $title = "二级警报";
        }

        if ($exception instanceof HighException) {
            $title = "三级警报";
        }

        return $title;
    }
}
