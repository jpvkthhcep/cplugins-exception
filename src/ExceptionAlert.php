<?php

namespace Cplugins\Exception;

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
        // 获取项目信息
        $projectInfo = base_path();
        // 异常级别
        $alertLevel = self::getAlertLevel($exception);
        // 获取异常类的调用者信息
        $caller = self::getCallerInfo($exception);
        // 获取异常信息
        $exceptionInfo = self::getException($exception);
        
        var_dump($projectInfo, "======project info========");
        var_dump($alertLevel, "======alert level========");
        var_dump($caller, "======caller info========");
        var_dump($exceptionInfo, "======exception info========");
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
        $title = "";
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
