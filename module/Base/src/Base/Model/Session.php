<?php

/**
 * Global Messages Session Model
 * 
 * Module: Base
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */

namespace Base\Model;

use Zend\Session\Container;

class Session
{
    protected static $_session;
    
    /**
     * Message classes
     * @var array
     */
    public static $classes = array(
        'success'   => 'success',
        'warning'   => 'warning',
        'error'     => 'danger'
    );
    
    // Get global messages session
    public static function getSession() 
    {
        if (!self::$_session) {
            self::$_session = new Container('global_messages');
        }
        
        return self::$_session;
    }
    
    public static function getGlobalMessages()
    {
        $session = self::getSession();
        return $session->messages;
    }
    
    protected static function addMessage($message, $type)
    {
        $session = self::getSession();
        $messages = $session->messages;
        $class = self::$classes[$type];
        
        $messages[] = array('type' => $type, 'message' => $message, 'class' => $class);
        $session->messages = $messages;
    }
    
    public static function success($message)
    {
        self::addMessage($message, 'success');
    }
    
    public static function warning($message)
    {
        self::addMessage($message, 'warning');
    }
    
    public static function error($message)
    {
        self::addMessage($message, 'error');
    }
    
    public static function clear()
    {
        $session = self::getSession();
        $session->offsetUnset('messages');
    }
}
