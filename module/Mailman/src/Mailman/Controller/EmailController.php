<?php

namespace Mailman\Controller;

use Zend\View\Model\ViewModel;
use Base\Model\Session;

class EmailController extends AbstractController
{
    protected $entity = 'Mailman\Entity\Email';
    protected $filters = array('id', 'title', 'subject');
    
    public function viewAction()
    {
        $request = $this->getEvent()->getRouteMatch();
        $id = $request->getParam('id');
        
        $emailModel = $this->getServiceLocator()->get('email_model');
        $variableModel = $this->getServiceLocator()->get('variable_model');
        
        $view = new ViewModel();
        $view->setVariables(array(
            'object' => $emailModel->load($id),
            'variables' => $variableModel->listAsJson()
        ));
        
        return $view;
    }
    
    public function sendTestAction()
    {
        $request = $this->getEvent()->getRouteMatch();
        $id = $request->getParam('id');
        $serviceLocator = $this->getServiceLocator();
        
        $testContactId = $serviceLocator->get('helper')->getConfig('test_contact_id');
        $contact = $serviceLocator->get('contact_model')->load($testContactId);
        $template = $serviceLocator->get('email_model')->load($id);
        
        try {
            $serviceLocator->get('action_model')->sendMail($contact, $template);
            Session::success("A test email was sent to <i>{$contact->email}</i>");
        } catch (\Exception $e) {
            Session::error("Failed to send test email: {$e->getMessage()}");
        }
        
        $this->redirect()->toRoute('email/wildcard', array('action' => 'view', 'id' => $id));
    }
}
