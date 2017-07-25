<?php

namespace Mailman\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\AbstractEntity;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="mailman_contact")
 */
class Contact extends AbstractEntity
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /** @ORM\Column(length=128, unique=true, nullable=false) */
    protected $email;
    
    /** @ORM\Column(length=128, nullable=true) */
    protected $firstname;
    
    /** @ORM\Column(length=128, nullable=true) */
    protected $lastname;
    
    /** @ORM\Column(length=64, nullable=true) */
    protected $city;
    
    /** @ORM\Column(length=64, nullable=true) */
    protected $region;
    
    /** @ORM\Column(length=64, nullable=true) */
    protected $country;
    
    /** @ORM\Column(length=16, nullable=true) */
    protected $zipcode;
    
    /** @ORM\Column(length=32, nullable=true) */
    protected $phone;
    
    /** @ORM\Column(length=64, nullable=false) */
    protected $source;
    
    /** @ORM\Column(type="datetime", name="created_at", nullable=true) */
    protected $createdAt;
    
    public function beforeCreate()
    {
        if (empty($this->get('email'))) {
            throw new \Exception('Email cannot be empty');
        }
        
        if (is_null($this->get('createdAt'))) {
            $this->set('createdAt', new \DateTime());
        }
        
        return $this;
    }
}