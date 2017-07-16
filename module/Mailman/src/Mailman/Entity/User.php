<?php

namespace Mailman\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\AbstractEntity;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="user")
 */
class User extends AbstractEntity
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /** @ORM\Column(length=128, unique=true, nullable=false) */
    protected $username;
    
    /** @ORM\Column(length=128, unique=true, nullable=false) */
    protected $email;
    
    /** @ORM\Column(length=128, nullable=false) */
    protected $password;
}
