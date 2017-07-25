<?php

namespace Mailman\Entity;

use Doctrine\ORM\Mapping as ORM;
use Base\Entity\AbstractEntity;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="mailman_task")
 */
class Task extends AbstractEntity
{
    const TYPE_MAILER = 1;
    const TYPE_IMPORT = 2;
    
    const STATUS_IDLE = 0;
    const STATUS_SCHEDULED = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_FINISHED = 3;
    
    static $mapStatuses = array(
        self::STATUS_IDLE => 'Idle',
        self::STATUS_SCHEDULED => 'Scheduled',
        self::STATUS_PROCESSING => 'Processing',
        self::STATUS_FINISHED => 'Finished'
    );
    
    static $mapTypes = array(
        self::TYPE_MAILER => 'Email Processor',
        self::TYPE_IMPORT => 'Contact Importer'
    );
    
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /** @ORM\Column(length=64, nullable=false) */
    protected $name;
    
    /** @ORM\Column(type="text", length=1048576, nullable=true) */
    protected $encodedData;
    
    /** @ORM\Column(type="smallint", length=1, nullable=false) */
    protected $type;
    
    /** @ORM\Column(type="smallint", length=1, nullable=false) */
    protected $status;
    
    /** @ORM\Column(type="datetime", name="scheduled_at", nullable=false) */
    protected $scheduledAt;
    
    /** @ORM\Column(type="datetime", name="created_at", nullable=true) */
    protected $createdAt;
    
    public function beforeCreate()
    {
        if (is_null($this->get('createdAt'))) {
            $this->set('createdAt', new \DateTime());
        }
        
        return $this;
    }
}
