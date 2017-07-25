<?php

namespace Mailman\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\AbstractEntity;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="mailman_register")
 */
class Register extends AbstractEntity
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /** @ORM\Column(length=64, nullable=false) */
    protected $name;
    
    /** @ORM\Column(type="datetime", name="created_at", nullable=true) */
    protected $createdAt;
    
    /** @ORM\Column(type="text", length=134217728, nullable=true) */
    protected $contacts;
    
    /** @ORM\Column(type="text", length=134217728, nullable=true) */
    protected $unsubscribed;
    
    public function beforeCreate()
    {
        if (is_null($this->get('createdAt'))) {
            $this->set('createdAt', new \DateTime());
        }
        
        return $this;
    }
}