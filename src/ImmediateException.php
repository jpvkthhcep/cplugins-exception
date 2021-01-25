<?php

namespace Cplugins\Exception;

use Exception;
use Throwable;

/**
 * 一级异常 
 * “马上解决”，表示问题必须马上解决，否则系统根本无法达到预定的需求。
 * 系统空间不足
 * 连接超时
 * 内存泄漏
 * cookie, token 过期
 */
class ImmediateException extends Exception
{
    public function __construct($message = "", $code = 0, ?Throwable $previous = null, $e = null)
    {
        parent::__construct($message, $code, $previous);
        // 报警
        ExceptionAlert::alert($e == null ? $this : $e);
    }
}
