<?php

namespace Mailman\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\AbstractEntity;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="email")
 */
class Email extends AbstractEntity
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /** @ORM\Column(length=128, nullable=false) */
    protected $title;
    
    /** @ORM\Column(length=255, nullable=false) */
    protected $subject;
    
    /** @ORM\Column(type="text", length=65535, nullable=false) */
    protected $content;
}
