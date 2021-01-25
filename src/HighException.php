<?php

namespace Cplugins\Exception;

use Exception;
use Throwable;

/**
 * 三级异常
 * “高度重视”，表示有时间就要马上解决，否则系统偏离需求较大或预定功能不能正常实现
 * 推送消息超过一定次数未成功
 * 程序报错超过一次次数
 */
class HighException extends Exception
{
    public function __construct($message = "", $code = 0, ?Throwable $previous = null, $e = null)
    {
        parent::__construct($message, $code, $previous);
        // 报警
        ExceptionAlert::alert($e == null ? $this : $e);
    }
}
