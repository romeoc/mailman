<?php

namespace Mailman\Model;

use Base\Model\AbstractModel;

class ContactModel extends AbstractModel
{
    protected $entityManager = null;
    
    public function __construct() 
    {
        $this->init('Mailman\Entity\Contact');
    }
    
    public function importCsv($task)
    {
        $path = "data/uploads/{$task->encodedData}";
        $file = fopen($path, "r");
        
        $result = array(
            'successful'    => 0,
            'duplicate'     => 0,
            'failed'        => 0,
            'failed_rows'   => array()
        );
        
        $columns = fgetcsv($file, 120000, ',');
        $count = 0;
        
        while (($row = fgetcsv($file, 120000, ',')) !== false) {
            $data = array(); 
            $count++;
            
            foreach ($columns as $key => $name) {
                $data[$name] = $row[$key];
            }
            
            if (!$data['source']) {
                $data['source'] = 'Import #' . str_replace('.csv', '', $task->encodedData);
            }
            
            try {
                $this->create($data, false);
                $result['successful']++;
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                $result['duplicate']++;
            } catch (\Exception $e) {
                $result['failed']++;
                $result['failed_rows'][] = $count;
            }
        }
        
        $result['filename'] = $task->encodedData;
        $data = array(
            'id' => $task->id,
            'encodedData' => json_encode($result),
            'status' => \Mailman\Entity\Task::STATUS_FINISHED
        );

        $this->getServiceLocator()->get('task_model')->update($data);
        fclose($file);
    }
}
