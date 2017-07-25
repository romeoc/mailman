<?php

namespace Mailman\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\AbstractEntity;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="mailman_variable")
 */
class Variable extends AbstractEntity
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /** @ORM\Column(length=128, unique=true, nullable=false) */
    protected $target;
    
    /** @ORM\Column(type="text", length=4092, nullable=false) */
    protected $value;
}
