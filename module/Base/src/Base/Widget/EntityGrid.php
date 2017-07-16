<?php

namespace Base\Widget;

/**
 * Create a grid for a doctrine entity
 * 
 * Module: Application
 * Author: Romeo Cozac <romeo_cozac@yahoo.com>
 * 
 */

use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class EntityGrid implements ServiceLocatorAwareInterface
{
    const DIRECTION_ASCENDING = "asc";
    
    const DIRECTION_DESCENDING = "desc";
    
    //Doctrine Entity
    protected $entity;

    //Doctrine Entity Class 
    protected $entityName;
    
    //Grid Rows Data
    protected $repository;
    
    //Grid Page Rows Count
    protected $limit = 200;
    
    //Current Page
    protected $page = 1;
    
    //Pager Count
    protected $visiblePages = 5;
    
    //Grid Columns
    protected $filters = array();
    
    //Grid Total Rows Count
    protected $count;
    
    //Starting Entry Index
    protected $index = 1;
    
    //Pager Starting Page
    protected $startingPage = 0;
    
    //Pager Ending Page
    protected $endingPage = 0;
    
    //Order grid by this column
    protected $orderBy = 'id';
    
    //Search by all filter types
    protected $search;
    
    //Ordering result direction
    protected $direction = self::DIRECTION_ASCENDING;
    
    //Service Locator
    protected $service;
    
    //Value maps (for dropdowns)
    protected $valueMaps = array();
    
    //Should be a URL - add column with this field
    protected $extraAction;
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->service;
    }
    
    public function __construct($service, $entity, $params = null)
    {
        $this->entityName = $entity;
        $this->entity = new $entity();
        $this->setServiceLocator($service);
        $this->parseParams($params);
    }
    
    /**
     * Handle input parameters. Available parameters are:
     * - page (int) : the current page number
     * - filters (array | string) : grid columns
     * - limit (int) : grid rows count
     * - orderBy (string) : order by column
     * - direction (string) : ASC or DESC
     * 
     * @param array $params
     */
    protected function parseParams($params)
    {
        if (array_key_exists('page', $params)) {
            $this->setPage($params['page']);
        }
        
        if (array_key_exists('filter', $params)) {
            $this->addFilter($params['filter']);
        } else {
            $this->filters = $this->getPropertiesArray();
        }
        
        if (array_key_exists('limit', $params)) {
            $this->setLimit($params['limit']);
        }
        
        if (array_key_exists('orderBy', $params)) {
            $this->setOrderColumn($params['orderBy']);
        }
        
        if (array_key_exists('direction', $params)) {
            $this->setOrderDirection($params['direction']);
        }
        
        if (array_key_exists('search', $params)) {
            $this->setSearch($params['search']);
        }
        
        if (array_key_exists('extraAction', $params)) {
            $this->setExtraAction($params['extraAction']);
        }
        
        if (array_key_exists('valueMaps', $params)) {
            $this->valueMaps = $params['valueMaps'];
        }
    }
    
    /**
     * Add column to grid
     * 
     * @param string | array $columns
     */
    public function addFilter($columns)
    {
        if (!is_array($columns)) {
            $columns = array($columns);
        }

        foreach ($columns as $column) {
            if (property_exists($this->entity, $column)){
                $this->filters[] = $column;
            }
        }
    }
    
    /**
     * Set row limit
     * 
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }
    
    /**
     * Get row limit
     * 
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }
    
    /**
     * Set current page
     * 
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }
    
    /**
     * Get current page
     * 
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }
    
    /**
     * Set current search term
     * 
     * @param string $search
     */
    public function setSearch($search)
    {
        $this->search = $search;
    }
    
    /**
     * Get current search term
     * 
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }
    
    /**
     * Set Column for Order by
     * 
     * @param string $column
     */
    public function setOrderColumn($column)
    {
        if (property_exists($this->entity, $column)){
            $this->orderBy = $column;
        }
    }
    
    /**
     * Get order by column
     * 
     * @return string
     */
    public function getOrderColumn()
    {
        return $this->orderBy;
    }
    
    /**
     * Set direction for order by
     * 
     * @param string $order
     */
    public function setOrderDirection($order)
    {
        $this->direction = $order;
    }
    
    /**
     * Set Extra Action
     * 
     * @param string $extraAction
     */
    public function setExtraAction($extraAction)
    {
        $this->extraAction = $extraAction;
    }
    
    /**
     * Get direction for oder by
     * 
     * @return string
     */
    public function getOrderDirection()
    {
        return $this->direction;
    }
    
    /**
     * Get total rows count
     * 
     * @return int
     */
    public function getSize()
    {
        if (!isset($this->count)) {
            $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $sql = "SELECT COUNT(o) FROM $this->entityName o ";
            
            $this->count = $entityManager
                ->createQuery($sql)
                ->getSingleScalarResult();
        }

        return $this->count;
    }
    
    /**
     * Return the data as JSON
     * return @string
     */
    public function asJson()
    {
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $data = $entityManager->createQuery($this->getSql())->getArrayResult();

        return json_encode($data);
    }
    
    /**
     * Prepare rows data and update index
     */
    protected function prepareData()
    {
        $this->index = $this->limit * ($this->page - 1);
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        
        $this->repository = $entityManager
            ->createQuery($this->getSql())
            ->setMaxResults($this->limit)
            ->setFirstResult($this->index)
            ->getResult();
    }
    
    /**
     * Get listing SQL query
     * @return string
     */
    public function getSql()
    {
        $sql = "SELECT e.@filters FROM $this->entityName e ";
        if (!empty($this->search)) {
            $search = 'WHERE ';
            foreach ($this->filters as $filter) {
                $search .= "e.{$filter} LIKE '%@search%' OR ";
            }
            
            $sql .= substr($search, 0, -4);
        }
        
        $sql .= "ORDER BY e.@orderColumn @direction";
        
        $filters = implode(',e.', $this->filters);
        if (!empty($this->extraAction) && !in_array($this->extraAction, $this->filters)) {
            $filters .= ",e.{$this->extraAction}";
        }
        
        $sql = str_replace('@filters', $filters, $sql);
        $sql = str_replace('@orderColumn', $this->orderBy, $sql);
        $sql = str_replace('@direction', $this->direction, $sql);
        $sql = str_replace('@search', $this->search, $sql);
        
        return $sql;
    }
    
    /**
     * Prepare pager data
     */
    protected function preparePages()
    {
        $totalPages = ceil($this->getSize()/$this->limit);
        if ($totalPages < $this->visiblePages) {
            $this->startingPage = 1;
            $this->endingPage = $totalPages;
        } elseif ($this->page < ceil($this->visiblePages/2)){
            $this->startingPage = 1;
            $this->endingPage = $this->visiblePages; 
        } elseif($this->page > $totalPages - floor($this->visiblePages/2)){
            $this->startingPage = $totalPages - $this->visiblePages + 1; 
            $this->endingPage = $totalPages; 
        } else {
            $this->startingPage = $this->page - floor($this->visiblePages / 2);
            $this->endingPage = $this->page + floor($this->visiblePages / 2);
        }
    }
    
    /**
     * Return Grid Html
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function toHtml()
    {
        $this->prepareData();
        $this->preparePages();
        
        $controller = explode('\\', $this->entityName);
        $controller = strtolower(end($controller));
                
        $view = new ViewModel(array(
            'elements'      => $this->repository,
            'limit'         => $this->limit,
            'page'          => $this->page,
            'size'          => $this->getSize(),
            'filters'       => $this->filters,
            'visiblePages'  => $this->visiblePages,
            'startingPage'  => $this->startingPage,
            'endingPage'    => $this->endingPage,
            'orderBy'       => $this->orderBy,
            'direction'     => $this->direction,
            'search'        => $this->search,
            'extraAction'   => $this->extraAction,
            'valueMaps'     => $this->valueMaps,
            'controller'    => $controller,
            'params'        => $this->getParams()
        ));
        
        $view->setTemplate('widget/grid');
        return $view;
    }
    
    /**
     * Get url query params for current action
     */
    public function getParams()
    {
        $params = array();
        $params['action'] = 'list';
        
        if ($this->orderBy != 'id') {
            $params['orderBy'] = $this->orderBy;
        }
        
        if ($this->direction != self::DIRECTION_ASCENDING) {
            $params['direction'] = $this->direction;
        }
        
        if (!empty($this->search)) {
            $params['search'] = $this->search;
        }
        
        return $params;
    }
    
    /**
     * Get all properties of the entity
     * 
     * @return array
     */
    protected function getPropertiesArray()
    {
        $clone = (array) $this->entity;
        
        while ( list ($key, $value) = each ($clone) ) {
            if (!is_object($value)) {
                $newKey = explode ("\0", $key);
                $clone[$key] = end($newKey);
            }
        }

        return $clone;
    }
}
