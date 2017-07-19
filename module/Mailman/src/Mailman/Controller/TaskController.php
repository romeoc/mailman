<?php

namespace Mailman\Controller;

use Zend\View\Model\ViewModel;
use Base\Widget\EntityGrid;

class TaskController extends AbstractController
{
    protected $entity = 'Mailman\Entity\Task';
    protected $filters = array('id', 'name', 'type', 'status', 'scheduledAt');
    
    public function listAction()
    {
        $request = $this->getEvent()->getRouteMatch();
        
        $data = array_merge($request->getParams(), $this->params()->fromPost());
        $data['filter'] = $this->filters;
        $data['valueMaps'] = array(
            'status' => \Mailman\Entity\Task::$mapStatuses,
            'type' => \Mailman\Entity\Task::$mapTypes
        );

        $grid = new EntityGrid($this->getServiceLocator(), $this->entity, $data);
        return $grid->toHtml();
    }
    
    public function viewAction()
    {
        $request = $this->getEvent()->getRouteMatch();
        $id = $request->getParam('id');
        $model = $this->getServiceLocator()->get('task_model');
        $task = $model->load($id);
        
        $view = new ViewModel();
        $view->setVariables(array(
            'object' => $task, 
            'emails' => $this->getServiceLocator()->get('email_model')->all(),
            'lists' => $this->getServiceLocator()->get('register_model')->all(),
            'stats' => $model->getStats($task)
        ));
        
        return $view;
    }
    
    public function processAction()
    {
        $this->getServiceLocator()->get('task_model')->runCron();
        exit();
    }
}
