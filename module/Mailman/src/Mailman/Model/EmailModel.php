<?php

namespace Mailman\Model;

use Base\Model\AbstractModel;

class EmailModel extends AbstractModel
{
    public function __construct() 
    {
        $this->init('Mailman\Entity\Email');
    }
}
