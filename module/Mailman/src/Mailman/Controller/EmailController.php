<?php

namespace Mailman\Controller;

use Zend\View\Model\ViewModel;

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
}
