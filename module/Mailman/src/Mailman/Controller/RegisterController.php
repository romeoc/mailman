<?php

namespace Mailman\Controller;

use Zend\View\Model\ViewModel;

class RegisterController extends AbstractController
{
    protected $entity = 'Mailman\Entity\Register';
    protected $filters = array('id', 'name', 'createdAt');
    
    public function viewAction()
    {
        $request = $this->getEvent()->getRouteMatch();
        $id = $request->getParam('id');
        
        $model = $this->getServiceLocator()->get('register_model');
        $object = $model->load($id);
        $contacts = $model->getContacts($object);

        $view = new ViewModel();
        $view->setVariables(array(
            'object' => $object, 
            'contacts' => $contacts
        ));
        
        return $view;
    }
}
