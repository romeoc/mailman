<?php

namespace Mailman;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();
        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'checkIfAuthenticated'));
        $config = $e->getApplication()
            ->getServiceManager()
            ->get('config');

        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config['session']);
        
        $sessionManager = new SessionManager($sessionConfig);
        Container::setDefaultManager($sessionManager);
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach('render', array($this, 'setLayoutTitle'));
        
        $sm = $application->getServiceManager();
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('Zend\Mvc\Application', 'dispatch.error', function($e) use ($sm) {
            if ($e->getParam('exception')) {
                $sm->get('Zend\Log\Logger')->crit($e->getParam('exception'));
            }
        });
        
    }
    
    /**
     * @param  \Zend\Mvc\MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function setLayoutTitle($e)
    {
        $viewHelperManager = $e->getApplication()->getServiceManager()->get('viewHelperManager');
        $headTitle = $viewHelperManager->get('headTitle');

        $headTitle->setSeparator(' – ');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function checkIfAuthenticated(MvcEvent $e)
    {
        $match = $e->getRouteMatch();
        if (false === strpos($match->getMatchedRouteName(), 'auth')) {
            $sm = $e->getParam('application')->getServiceManager();
            $auth = $sm->get('doctrine.authenticationservice.orm_default');
            if (!$auth->hasIdentity()) {
                $target = $e->getTarget();
                $target->plugin('redirect')->toRoute('auth');
            }
        }
    }
    
    public function getServiceConfig()
    { 
        return array(
            'factories' => array(
                'contact_model' => function(ServiceLocatorInterface $sm) {
                    $model = new \Mailman\Model\ContactModel();
                    $model->setServiceLocator($sm);
                    return $model;
                },
                'register_model' => function(ServiceLocatorInterface $sm) {
                    $model = new \Mailman\Model\RegisterModel();
                    $model->setServiceLocator($sm);
                    return $model;
                },
                'task_model' => function(ServiceLocatorInterface $sm) {
                    $model = new \Mailman\Model\TaskModel();
                    $model->setServiceLocator($sm);
                    return $model;
                },
                'email_model' => function(ServiceLocatorInterface $sm) {
                    $model = new \Mailman\Model\EmailModel();
                    $model->setServiceLocator($sm);
                    return $model;
                },
                'variable_model' => function(ServiceLocatorInterface $sm) {
                    $model = new \Mailman\Model\VariableModel();
                    $model->setServiceLocator($sm);
                    return $model;
                },
                'action_model' => function(ServiceLocatorInterface $sm) {
                    $model = new \Mailman\Model\ActionModel();
                    $model->setServiceLocator($sm);
                    return $model;
                },
                'helper' => function(ServiceLocatorInterface $sm) {
                    $helper = new \Mailman\Helper\Base();
                    $helper->setServiceLocator($sm);
                    return $helper;
                }
            ),
        );
    }
}
