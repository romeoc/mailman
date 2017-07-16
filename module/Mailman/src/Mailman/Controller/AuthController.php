<?php

namespace Mailman\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Mailman\Model\Login\Form as LoginForm;
use Mailman\Model\Login\User as User;

class AuthController extends AbstractActionController
{
    public function loginAction()
    {
        $this->getServiceLocator()
            ->get('ViewHelperManager')
            ->get('HeadTitle')
            ->append('MailMan')
            ->append('Login');
            
        $view = new ViewModel(array(
            'form' => new LoginForm()
        ));
        
        $view->setTerminal(true);
        return $view;
    }
    
    public function authenticateAction()
    {
        $data = $this->getRequest()->getPost();
        
        $userModel = new User();
        $userModel->setServiceLocator($this->getServiceLocator());
        $authenticationResult = $userModel->authenticate($data['username'], hash('sha512', $data['password']));
        
        if ($authenticationResult) {
            $this->redirect()->toRoute('home');
        }

        $view = new ViewModel(array(
            'error' => 'Your authentication credentials are not valid',
            'form' => new LoginForm(),
        ));

        $view->setTemplate('mailman/auth/login');
        $view->setTerminal(true);
        
        return $view;
    }
    
    public function logoutAction()
    {
        $auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
        $auth->clearIdentity();
        
        $this->redirect()->toRoute('auth');
    }
}
