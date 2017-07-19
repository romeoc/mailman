<?php

namespace Mailman\Helper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Crypt\BlockCipher;

class Base implements ServiceLocatorAwareInterface
{
    protected $config = array();
    protected $service;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->service;
    }
    
    public function getConfig($config)
    {
        if (!$this->config) {
            $this->config = $this->getServiceLocator()->get('config');
        }
        
        $value = false;
        
        if (array_key_exists($config, $this->config)) {
            $value = $this->config[$config];
        }
        
        return $value;
    }
    
    public function encrypt($data)
    {
        $encyptionKey = $this->getConfig('encryption_key');
        $cipher = BlockCipher::factory('mcrypt', array('algo' => 'aes'));
        $cipher->setKey($encyptionKey);
        
        return $cipher->encrypt($data);
    }
    
    public function decrypt($data)
    {
        $encyptionKey = $this->getConfig('encryption_key');
        $cipher = BlockCipher::factory('mcrypt', array('algo' => 'aes'));
        $cipher->setKey($encyptionKey);
        
        return $cipher->decrypt($data);
    }
}
