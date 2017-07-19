<?php

namespace Mailman\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Base\Entity\AbstractEntity;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="action", uniqueConstraints={@UniqueConstraint(name="unique_task_contact_action", columns={"contact_id", "task_id"})})
 */
class Action extends AbstractEntity
{
    const STATUS_FAILED = 0;
    const STATUS_READY = 1;
    const STATUS_DELIVERED = 2;
    const STATUS_OPENED = 3;
    const STATUS_CLICKED = 4;
    
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /** @ORM\Column(type="smallint", length=1, nullable=false) */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Contact")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    protected $contact;
    
    /**
     * @ORM\ManyToOne(targetEntity="Task")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id", onDelete="NO ACTION")
     */
    protected $task;
    
    /** @ORM\Column(type="datetime", name="received_at", nullable=true) */
    protected $receivedAt;
}
