<?php

/**
 * Message logging class
 * 
 * Module: Base
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */

namespace Base\Model;

class Logger
{
    const FILE = 'data/base.log';
    
    public static function log($message)
    {
        file_put_contents(self::FILE, $message . PHP_EOL, FILE_APPEND);
    }
}
