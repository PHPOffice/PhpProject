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
    private $_properties;

    /**
     * Document informations
     *
     * @var PHPProject_DocumentInformations
     */
    private $_informations;
    
    /**
     * Collection of task objects
     *
     * @var PHPProject_Task[]
     */
    private $_taskCollection = array();
    
    /**
     * Collection of resource objects
     *
     * @var PHPProject_Resource[]
     */
    private $_resourceCollection = array();

    /**
     * Active task
     *
     * @var int
     */
    private $_activeTaskIndex = 0;

    /**
     * Active resource
     *
     * @var int
     */
    private $_activeResourceIndex = 0;
    
    /**
     * Create a new PHPProject
     */
    public function __construct() {
        // Create document properties
        $this->_properties = new DocumentProperties();
        // Create document informations
        $this->_informations = new DocumentInformations();
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
        return $this->_properties;
    }

    /**
     * Set properties
     *
     * @param PHPProject_DocumentProperties    $pValue
     */
    public function setProperties(DocumentProperties $pValue)
    {
        $this->_properties = $pValue;
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
        return $this->_informations;
    }
    
    /**
     * Set informations
     *
     * @param PHPProject_DocumentProperties    $pValue
     */
    public function setInformations(DocumentInformations $pValue)
    {
        $this->_informations = $pValue;
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
    public function createResource() {
        $newRessource = new Resource($this, $this->getResourceCount());
        $this->_resourceCollection[] = $newRessource;
        $this->_activeResourceIndex = $this->getResourceCount() - 1;
        return $newRessource;
    }

    /**
     * Get resource count
     *
     * @return int
     */
    public function getResourceCount()
    {
        return count($this->_resourceCollection);
    }
    
    /**
     * Get all resources
     *
     * @return PHPProject_Resource[]
     */
    public function getAllResources(){
        return $this->_resourceCollection;
    }
    
    /**
     * Get active resource
     *
     * @return PHPProject_Resource
     */
    public function getActiveResource()
    {
        return $this->_resourceCollection[$this->_activeResourceIndex];
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
        if ($pIndex > count($this->_resourceCollection) - 1) {
            throw new Exception('Resource index is out of bounds.');
        } else {
            return $this->_resourceCollection[$pIndex];
        }
    }
    
    /**
     * Get active resource index
     *
     * @return int Active resource index
     */
    private function getActiveResourceIndex()
    {
        return $this->$_activeResourceIndex;
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
        if ($pIndex > count($this->_resourceCollection) - 1) {
            throw new Exception('Active resource index is out of bounds.');
        } else {
            $this->_activeResourceIndex = $pIndex;
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
    public function createTask() {
        $newTask = new Task($this, $this->getTaskCount());
        $this->_taskCollection[] = $newTask;
        $this->_activeTaskIndex = $this->getTaskCount() - 1;
        return $newTask;
    }
    
    /**
     * Get task count
     *
     * @return int
     */
    public function getTaskCount()
    {
        return count($this->_taskCollection);
    }
    
    /**
     * Get all tasks
     *
     * @return PHPProject_Task[]
     */
    public function getAllTasks()
    {
        return $this->_taskCollection;
    }
    
    /**
     * Get active task
     *
     * @return PHPProject_Task
     */
    public function getActiveTask()
    {
        return $this->_taskCollection[$this->_activeTaskIndex];
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
        if ($pIndex > count($this->_taskCollection) - 1) {
            throw new Exception('Task index is out of bounds.');
        } else {
            return $this->_taskCollection[$pIndex];
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
        if ($pIndex > count($this->_taskCollection) - 1) {
            throw new Exception('Task index is out of bounds.');
        } else {
            array_splice($this->_taskCollection, $pIndex, 1);
        }
        // Adjust active sheet index if necessary
        if (($this->_activeTaskIndex >= $pIndex) &&
            ($pIndex > count($this->_taskCollection) - 1)) {
            --$this->_activeTaskIndex;
        }
    }

    /**
     * Get active task index
     *
     * @return int Active task index
     */
    public function getActiveTaskIndex()
    {
        return $this->_activeTaskIndex;
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
        if ($pIndex > count($this->_taskCollection) - 1) {
            throw new Exception('Active task index is out of bounds.');
        } else {
            $this->_activeTaskIndex = $pIndex;
        }
        return $this->getActiveTask();
    }
}
