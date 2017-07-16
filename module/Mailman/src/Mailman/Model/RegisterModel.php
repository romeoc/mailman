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
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e.id, e.email, e.firstname, e.lastname')
            ->from('Mailman\Entity\Contact', 'e')
            ->where('e.id IN (:contacts)')
            ->setParameter('contacts', explode(',', $register->contacts))
            ->getQuery()
            ->getArrayResult();
    }
}
