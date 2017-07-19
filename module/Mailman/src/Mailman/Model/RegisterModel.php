<?php

namespace Mailman\Model;

use Base\Model\AbstractModel;

class RegisterModel extends AbstractModel
{
    public function __construct() 
    {
        $this->init('Mailman\Entity\Register');
    }
    
    /**
     * Load contacts for register
     * 
     * @param Mailman\Entity\Register $register
     * @return array
     */
    public function getContacts($register)
    {
        return $this->listContacts($register->contacts);
    }
    
    /**
     * Load details for unsubscribed contacts on this list
     * 
     * @param Mailman\Entity\Register $register
     * @return array
     */
    public function getUnsubscribed($register)
    {
        return $this->listContacts($register->unsubscribed);
    }
    
    /**
     * Load details for a list of contacts
     * @param array $contacts
     * @return array
     */
    public function listContacts($contacts)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e.id, e.email, e.firstname, e.lastname')
            ->from('Mailman\Entity\Contact', 'e')
            ->where('e.id IN (:contacts)')
            ->setParameter('contacts', explode(',', $contacts))
            ->getQuery()
            ->getArrayResult();
    }
    
    public function unsubscribe($hash)
    {
        $data = $this->getServiceLocator()->get('helper')->decrypt(urldecode($hash));
        list($listId, $contactId) = explode('-', $data);
        
        if (is_numeric($listId) && is_numeric($contactId)) {
            $register = $this->load($listId);
            
            $unsubscribeList = ($register->unsubscribed) ? explode(',', $register->unsubscribed) : array();
            $unsubscribeList[] = $contactId;
            
            $register->unsubscribed = implode(',', array_unique($unsubscribeList));
            $this->getEntityManager()->flush();
        }
    }
}
