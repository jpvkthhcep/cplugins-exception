<?php

namespace Cplugins\Exception;

use Exception;
use Throwable;

/**
 * 二次异常
 * “急需解决”，表示问题的修复很紧要，很急迫，关系到系统的主要功能模块能否正常。
 * 功能提交失败
 */
class UrgentException extends Exception
{
    public function __construct($message = "", $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        // 报警
        ExceptionAlert::alert($this);
    }
}
