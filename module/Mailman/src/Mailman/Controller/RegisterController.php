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
        $unsubscribed = $model->getUnsubscribed($object);

        $view = new ViewModel();
        $view->setVariables(array(
            'object' => $object, 
            'contacts' => $contacts,
            'unsubscribed' => $unsubscribed
        ));
        
        return $view;
    }
    
    public function unsubscribeAction()
    {
        $request = $this->getEvent()->getRouteMatch();
        $hash64 = $request->getParam('hash');
        $hash = base64_decode($hash64);
        
        $this->getServiceLocator()->get('register_model')->unsubscribe($hash);
        $afterUnsubscribeUrl = $this->getServiceLocator()->get('helper')->getConfig('after_unsubscribe_url');
        return $this->redirect()->toUrl($afterUnsubscribeUrl);
    }
}
