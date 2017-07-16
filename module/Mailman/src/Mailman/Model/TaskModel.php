<?php

namespace Mailman\Model;

use Base\Model\AbstractModel;

class TaskModel extends AbstractModel
{
    public function __construct() 
    {
        $this->init('Mailman\Entity\Task');
    }
    
    public function save($data)
    {
        if ($data['scheduledAt']) {
            $data['scheduledAt'] = date_create_from_format('Y-m-d H:i:s', $data['scheduledAt']);
        }
        
        return parent::save($data);
    }
    
    public function getNextScheduledTask()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->from($this->entity, 'e')
            ->where('e.status = :status')
            ->andWhere('UNIX_TIMESTAMP(e.scheduledAt) <= :now')
            ->setParameter('status', \Mailman\Entity\Task::STATUS_SCHEDULED)
            ->setParameter('now', time())
            ->orderBy('e.scheduledAt', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    public function runCron()
    {
        $task = $this->getNextScheduledTask();
        if ($task) {
            $task->set('status', \Mailman\Entity\Task::STATUS_PROCESSING);
            $this->getEntityManager()->flush();
            
            switch ($task->type) {
                case(\Mailman\Entity\Task::TYPE_MAILER):
                    $this->processTask($task);
                    break;
                case(\Mailman\Entity\Task::TYPE_IMPORT):
                    $this->getServiceLocator()->get('contact_model')->importCsv($task);
                    break;
            }
        }
    }
    
    public function processTask($task)
    {
        echo 'Processing Task';
    }
}
