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
        if ($data['scheduledAt'] && !is_object($data['scheduledAt'])) {
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
    
    /**
     * Send the emails
     * @param Task $task
     */
    public function processTask($task)
    {
        $actionModel = $this->getServiceLocator()->get('action_model');
        $actionModel->process($task);
        
        $data = array('id' => $task->id, 'status' => \Mailman\Entity\Task::STATUS_FINISHED);
        $this->update($data);
    }
    
    /**
     * Get progress information
     * @param Task $task
     * @return array
     */
    public function getStats($task)
    {
        $stats = array();
        switch ($task->type) {
            case (\Mailman\Entity\Task::TYPE_IMPORT):
                $data = json_decode($task->encodedData, true);
                $list = array('successful', 'duplicate', 'failed');
                
                foreach ($list as $stat) {
                    if (array_key_exists($stat, $data)) {
                        $stats[$stat] = $data[$stat];
                    }
                }

                break;
            case (\Mailman\Entity\Task::TYPE_MAILER):
                $list = array(
                    'ready' => \Mailman\Entity\Action::STATUS_READY,
                    'delivered' => \Mailman\Entity\Action::STATUS_DELIVERED,
                    'failed' => \Mailman\Entity\Action::STATUS_FAILED,
                    'opened' => \Mailman\Entity\Action::STATUS_OPENED
                );
                
                $model = $this->getServiceLocator()->get('action_model');
                foreach ($list as $key => $status) {
                    $stats[$key] = $model->getStatistic($task, $status);
                }
                
                break;
        }
        
        return $stats;
    }
}
