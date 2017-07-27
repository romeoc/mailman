<?php

namespace Mailman\Controller;

use Base\Model\Session;

class ContactController extends AbstractController
{
    protected $entity = 'Mailman\Entity\Contact';
    protected $filters = array('id', 'source', 'email', 'firstname', 'lastname', 'city', 'region', 'country', 'createdAt');
    
    public function importAction()
    {
        $now = time();
        $contactModel = $this->getServiceLocator()->get('contact_model');
        $contactModel->uploadFile('filename', 'data/uploads/', $now . '.csv');
        
        $taskModel = $this->getServiceLocator()->get('task_model');
        $date = new \DateTime();
        $date->setTimestamp($now);
        
        $taskModel->save(array(
            'name' => "Contacts Import {$now}",
            'encodedData' => $now . '.csv',
            'type' => \Mailman\Entity\Task::TYPE_IMPORT,
            'status' => \Mailman\Entity\Task::STATUS_SCHEDULED,
            'scheduledAt' => $date
        ));

        Session::success('An import was scheduled and will start soon.');
        return $this->redirect()->toRoute($this->getEntityName());
    }
}
