<?php

namespace Mailman\Model;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

use Base\Model\AbstractModel;
use Base\Model\Logger;

class ActionModel extends AbstractModel
{
    protected $helper;
    
    public function __construct() 
    {
        $this->init('Mailman\Entity\Action');
    }
    
    /**
     * Schedule and send the emails
     * @param TaskModel $task
     */
    public function process($task)
    {
        $data = json_decode($task->encodedData);
        $list = $this->getServiceLocator()->get('register_model')->load($data->list);
        $template = $this->getServiceLocator()->get('email_model')->load($data->template);
        $variables = $this->getServiceLocator()->get('variable_model')->all();
        
        $contactIds = array_diff(explode(',', $list->contacts), explode(',', $list->unsubscribed));
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        
        $model = $this->getServiceLocator()->get('contact_model');
        foreach ($contactIds as $contactId) {
            $contact = $model->load($contactId);
            
            $action = array(
                'status' => \Mailman\Entity\Action::STATUS_READY,
                'task' => $task,
                'contact' => $contact
            );
            
            try {
                $this->sendMail($contact, $template, $variables, $list->id, $task->id);
                $action['status'] = \Mailman\Entity\Action::STATUS_DELIVERED;
                $action['receivedAt'] = new \DateTime();
            } catch (\Exception $e) {
                $action['status'] = \Mailman\Entity\Action::STATUS_FAILED;
                Logger::log("Error sending email - contact {$contactId} - task {$task->id} - {$e->getMessage()}");
            }
            
            $this->create($action);
        }
    }
    
    /**
     * Send an email
     * @param Contact $contact
     * @param Email $template
     * @param array(Variable) $variables
     * @param int $listId
     * @param int $actionId
     */
    public function sendMail($contact, $template, $variables = null, $listId = null, $taskId = null)
    {
        if (!$variables) {
            $variables = $this->getServiceLocator()->get('variable_model')->all();
        }
        
        $content = $template->content;
        foreach ($variables as $variable) {
            $content = str_replace($variable->target, $variable->value, $content);
        }
        
        $globalVariables = $this->getGlobalVairables($contact, $listId);
        foreach ($globalVariables as $key => $value) {
            $content = str_replace($key, $value, $content);
        }
        
        if ($taskId) {
            $content = $this->addTrackingPixel($content, $taskId, $contact->id);
        }
        
        $senderName = $this->getHelper()->getConfig('store_name');
        $senderEmail = $this->getHelper()->getConfig('store_email');
        
        $html = new MimePart($content);
        $html->type = "text/html";
        $body = new MimeMessage();
        $body->setParts(array($html));
        var_dump($html); die;
        $mail = new Message();
        $mail->setBody($body);
        $mail->setFrom($senderEmail, $senderName);
        $mail->addTo($contact->email);
        $mail->setSubject($template->subject);
        
        $transport = new Sendmail();
        $transport->send($mail);
    }
    
    /**
     * Variables present in all emails
     * 
     * @param Contact $contact
     * @param int $listId
     * @return array
     */
    public function getGlobalVairables($contact, $listId)
    {
        $hash = urlencode($this->getHelper()->encrypt($listId . '-' . $contact->id));
        $url = $this->getHelper()->getConfig('domain') . "unsubscribe/{$hash}";
        
        return array(
            '[[unsubscribe_url]]' => $url,
            '[[email]]'     => $contact->email,
            '[[firstname]]' => ucfirst(strtolower($contact->firstname)),
            '[[lastname]]'  => ucfirst(strtolower($contact->lastname)),
            '[[name]]'      => ucfirst(strtolower($contact->firstname)) . ' ' . ucfirst(strtolower($contact->lastname))
        );
    }

    /**
     * Get config helper
     * @return Base\Helper\Config
     */
    public function getHelper()
    {
        if (!$this->helper) {
            $this->helper = $this->getServiceLocator()->get('helper');
        }
        
        return $this->helper;
    }
    
    public function getStatistic($task, $status)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('COUNT(e)')
            ->from($this->entity, 'e')
            ->where('e.status = :status')
            ->andWhere('e.task = :task')
            ->setParameters(array('status' => $status, 'task' => $task))
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    /**
     * Add pixel tracking
     * 
     * @param string $content
     * @param int $taskId
     * @param int $contactId
     * @return type
     */
    public function addTrackingPixel($content, $taskId, $contactId)
    {
        $url = $this->getHelper()->getConfig('domain')
            . "open/" 
            . urlencode($this->getHelper()->encrypt("{$taskId}-{$contactId}"));
        
        $pixel = "<img src='{$url}' />";
        return str_replace('<body>', "<body>{$pixel}", $content);
    }
    
    public function markAsRead($hash)
    {
        $data = $this->getServiceLocator()->get('helper')->decrypt(urldecode($hash));
        list($taskId, $contactId) = explode('-', $data);
        
        if (is_numeric($taskId) && is_numeric($contactId)) {
            $action = $this->getEntityManager()
                ->getRepository($this->entity)
                ->findOneBy(array('contact' => $contactId, 'task' => $taskId));
            
            $action->set('status', \Mailman\Entity\Action::STATUS_OPENED);
            $this->getEntityManager()->flush();
        }
    }
}
