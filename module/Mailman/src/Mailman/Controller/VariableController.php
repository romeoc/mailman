<?php

namespace Mailman\Controller;

class VariableController extends AbstractController
{
    protected $entity = 'Mailman\Entity\Variable';
    protected $filters = array('id', 'target', 'value');
}
