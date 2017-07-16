<?php

namespace Mailman\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Base\Widget\EntityGrid;

class AbstractController extends AbstractActionController
{
    protected $entity;
    protected $filters;
    
    public function listAction()
    {
        $request = $this->getEvent()->getRouteMatch();
        
        $data = array_merge($request->getParams(), $this->params()->fromPost());
        $data['filter'] = $this->filters;

        $grid = new EntityGrid($this->getServiceLocator(), $this->entity, $data);
        return $grid->toHtml();
    }
    
    public function ajaxAction()
    {
        $data = $this->params()->fromPost();
        $data['filter'] = $this->filters;

        $grid = new EntityGrid($this->getServiceLocator(), $this->entity, $data);
        return new JsonModel(array('data' => $grid->asJson()));
    }
    
    public function viewAction()
    {
        $request = $this->getEvent()->getRouteMatch();
        $id = $request->getParam('id');
        
        $model = $this->getServiceLocator()->get($this->getEntityName() . '_model');
        $object = $model->load($id);

        $view = new ViewModel();
        $view->setVariables(array('object' => $object));
        
        return $view;
    }
    
    public function saveAction()
    {
        $post = $this->request->getPost();
        
        $model = $this->getServiceLocator()->get($this->getEntityName() . '_model');
        $result = $model->save($post);

        return $this->redirect()->toRoute($this->getEntityName() .'/wildcard', array('action' => 'view', 'id' => $result->id));
    }
    
    public function deleteAction()
    {
        $request = $this->getEvent()->getRouteMatch();
        $id = $request->getParam('id');
        
        $model = $this->getServiceLocator()->get($this->getEntityName() . '_model');
        $model->delete($id);
        
        return $this->redirect()->toRoute($this->getEntityName());
    }
    
    protected function getEntityName()
    {
        return strtolower(str_replace('Mailman\\Entity\\', '', $this->entity));
    }
}
