<?php

namespace Mailman\Model;

use Base\Model\AbstractModel;

class VariableModel extends AbstractModel
{
    public function __construct() 
    {
        $this->init('Mailman\Entity\Variable');
    }

    /**
     * Return all variables as JSON
     * @return string
     */
    public function listAsJson()
    {
        $allVariables = $this->all();
        $variables = array();
        
        foreach ($allVariables as $variable) {
            $variables[$variable->target] = $variable->value;
        }
        
        return json_encode($variables);
    }
}
