<?php

namespace Mailman\Model\Login;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class User implements ServiceLocatorAwareInterface
{
    protected $service;
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->service;
    }
    
    public function authenticate($username, $password)
    {
        $auth = $this->service->get('doctrine.authenticationservice.orm_default');
        $auth->getAdapter()->setIdentityValue($username);
        $auth->getAdapter()->setCredentialValue($password);

        return $auth->authenticate()->isValid();
    }
}
