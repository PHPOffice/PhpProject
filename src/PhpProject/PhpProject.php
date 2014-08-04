<?php
/**
 * This file is part of PHPProject - A pure PHP library for reading and writing
 * presentations documents.
 *
 * PHPProject is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPProject
 * @copyright   2009-2014 PHPProject contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpProject;

/**
 * PHPProject
 *
 * @category   PHPProject
 * @package    PHPProject
 * @copyright  Copyright (c) 2006 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class PhpProject
{
    /**
     * Document properties
     *
     * @var PHPProject_DocumentProperties
     */
    private $properties;

    /**
     * Document informations
     *
     * @var PHPProject_DocumentInformations
     */
    private $informations;
    
    /**
     * Collection of task objects
     *
     * @var PHPProject_Task[]
     */
    private $taskCollection = array();
    
    /**
     * Collection of resource objects
     *
     * @var PHPProject_Resource[]
     */
    private $resourceCollection = array();

    /**
     * Active task
     *
     * @var int
     */
    private $activeTaskIndex = 0;

    /**
     * Active resource
     *
     * @var int
     */
    private $activeResourceIndex = 0;
    
    /**
     * Create a new PHPProject
     */
    public function __construct()
    {
        // Create document properties
        $this->properties = new DocumentProperties();
        // Create document informations
        $this->informations = new DocumentInformations();
    }

    //===============================================
    // Document Properties
    //===============================================
    /**
     * Get properties
     *
     * @return PHPProject_DocumentProperties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set properties
     *
     * @param PHPProject_DocumentProperties    $pValue
     */
    public function setProperties(DocumentProperties $pValue)
    {
        $this->properties = $pValue;
    }

    //===============================================
    // Document Informations
    //===============================================
    /**
     * Get informations
     * 
     * @return PHPProject_DocumentInformations
     */
    public function getInformations()
    {
        return $this->informations;
    }
    
    /**
     * Set informations
     *
     * @param PHPProject_DocumentProperties    $pValue
     */
    public function setInformations(DocumentInformations $pValue)
    {
        $this->informations = $pValue;
    }
    
    //===============================================
    // Resources
    //===============================================
    /**
     * Create a resource
     *
     * @return PHPProject_Resource
     * @throws Exception
     */
    public function createResource()
    {
        $newRessource = new Resource();
        $newRessource->setIndex($this->getResourceCount());
        $this->resourceCollection[] = $newRessource;
        $this->activeResourceIndex = $this->getResourceCount() - 1;
        return $newRessource;
    }

    /**
     * Get resource count
     *
     * @return int
     */
    public function getResourceCount()
    {
        return count($this->resourceCollection);
    }
    
    /**
     * Get all resources
     *
     * @return PHPProject_Resource[]
     */
    public function getAllResources()
    {
        return $this->resourceCollection;
    }
    
    /**
     * Get active resource
     *
     * @return PHPProject_Resource
     */
    public function getActiveResource()
    {
        return $this->resourceCollection[$this->activeResourceIndex];
    }
    
    /**
     * Get resource by index
     *
     * @param int $pIndex Resource index
     * @return PHPProject_Resource
     * @throws Exception
     */
    public function getResource($pIndex = 0)
    {
        if ($pIndex > count($this->resourceCollection) - 1) {
            throw new Exception('Resource index is out of bounds.');
        } else {
            return $this->resourceCollection[$pIndex];
        }
    }
    
    /**
     * Get active resource index
     *
     * @return int Active resource index
     */
    private function getActiveResourceIndex()
    {
        return $this->activeResourceIndex;
    }
    
    /**
     * Set active resource index
     *
     * @param int $pIndex Active resource index
     * @throws Exception
     * @return PHPProject_Resource
     */
    private function setActiveResourceIndex($pIndex = 0)
    {
        if ($pIndex > count($this->resourceCollection) - 1) {
            throw new Exception('Active resource index is out of bounds.');
        } else {
            $this->activeResourceIndex = $pIndex;
        }
        return $this->getActiveResource();
    }
    
    //===============================================
    // Tasks
    //===============================================
    /**
     * Create a task
     *
     * @return PHPProject_Task
     * @throws Exception
     */
    public function createTask()
    {
        $newTask = new Task();
        $newTask->setIndex($this->getTaskCount());
        $this->taskCollection[] = $newTask;
        $this->activeTaskIndex = $this->getTaskCount() - 1;
        return $newTask;
    }
    
    /**
     * Get task count
     *
     * @return int
     */
    public function getTaskCount()
    {
        return count($this->taskCollection);
    }
    
    /**
     * Get all tasks
     *
     * @return PHPProject_Task[]
     */
    public function getAllTasks()
    {
        return $this->taskCollection;
    }
    
    /**
     * Get active task
     *
     * @return PHPProject_Task
     */
    public function getActiveTask()
    {
        return $this->taskCollection[$this->activeTaskIndex];
    }
    
    /**
     * Get task by index
     *
     * @param int $pIndex Task index
     * @return PHPProject_Task
     * @throws Exception
     */
    public function getTask($pIndex = 0)
    {
        if ($pIndex > count($this->taskCollection) - 1) {
            throw new Exception('Task index is out of bounds.');
        } else {
            return $this->taskCollection[$pIndex];
        }
    }

    /**
     * Remove task by index
     *
     * @param int $pIndex Active task index
     * @throws Exception
     */
    public function removeTaskByIndex($pIndex = 0)
    {
        if ($pIndex > count($this->taskCollection) - 1) {
            throw new Exception('Task index is out of bounds.');
        } else {
            array_splice($this->taskCollection, $pIndex, 1);
        }
        // Adjust active sheet index if necessary
        if (($this->activeTaskIndex >= $pIndex) &&
            ($pIndex > count($this->taskCollection) - 1)) {
            --$this->activeTaskIndex;
        }
    }

    /**
     * Get active task index
     *
     * @return int Active task index
     */
    public function getActiveTaskIndex()
    {
        return $this->activeTaskIndex;
    }

    /**
     * Set active task index
     *
     * @param int $pIndex Active task index
     * @throws Exception
     * @return PHPProject_Task
     */
    public function setActiveTaskIndex($pIndex = 0)
    {
        if ($pIndex > count($this->taskCollection) - 1) {
            throw new Exception('Active task index is out of bounds.');
        } else {
            $this->activeTaskIndex = $pIndex;
        }
        return $this->getActiveTask();
    }
}
