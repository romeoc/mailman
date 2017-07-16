<?php

return array(
    'session' => array(
        'remember_me_seconds' => 525600,
        'cookie_lifetime'     => 525600,
        'gc_maxlifetime'      => 525600, 
        'use_cookies'         => true,
        'cookie_httponly'     => true,
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Log\Logger' => function($sm){
                $logger = new Zend\Log\Logger;
                $writer = new Zend\Log\Writer\Stream('./errors.log');
                $logger->addWriter($writer);  
                return $logger;
            },
        ),
    ),
);
