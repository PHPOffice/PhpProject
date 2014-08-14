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
     * @var DocumentProperties
     */
    private $properties;

    /**
     * Document informations
     *
     * @var DocumentInformations
     */
    private $informations;
    
    /**
     * Collection of task objects
     *
     * @var Task[]
     */
    private $taskCollection = array();
    
    /**
     * Collection of resource objects
     *
     * @var Resource[]
     */
    private $resourceCollection = array();

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
        return $this;
    }

    //===============================================
    // Document Informations
    //===============================================
    /**
     * Get informations
     * 
     * @return DocumentInformations
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
        return $this;
    }
    
    //===============================================
    // Resources
    //===============================================
    /**
     * Create a resource
     *
     * @return Resource
     * @throws \Exception
     */
    public function createResource()
    {
        $newRessource = new Resource();
        $this->resourceCollection[] = $newRessource;
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
     * @return \PhpOffice\PhpProject\Resource[]
     */
    public function getAllResources()
    {
        return $this->resourceCollection;
    }
    
    /**
     * Get active resource
     *
     * @return Resource|null
     */
    public function getActiveResource()
    {
        if (!empty($this->resourceCollection)) {
            return end($this->resourceCollection);
        }
        return null;
    }
    
    /**
     * Get resource from index
     *
     * @return Resource|null
     */
    public function getResourceFromIndex($pIndex)
    {
        foreach ($this->resourceCollection as $oResource) {
            if ($oResource->getIndex() == $pIndex) {
                return $oResource;
            }
        }
        return null;
    }
    
    //===============================================
    // Tasks
    //===============================================
    /**
     * Create a task
     *
     * @return Task
     * @throws \Exception
     */
    public function createTask()
    {
        $newTask = new Task();
        $this->taskCollection[] = $newTask;
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
     * @return Task[]
     */
    public function getAllTasks()
    {
        return $this->taskCollection;
    }
    
    /**
     * Get active task
     *
     * @return Task
     */
    public function getActiveTask()
    {
        if (!empty($this->taskCollection)) {
            return end($this->taskCollection);
        }
        return null;
    }
    
    /**
     * Get task from index
     *
     * @return Task|null
     */
    public function getTaskFromIndex($pIndex, Task $oTaskParent = null)
    {
        if (is_null($oTaskParent)) {
            $arrayTask = $this->taskCollection;
        } else {
            $arrayTask = $oTaskParent->getTasks();
        }
        foreach ($arrayTask as $oTask) {
            if ($oTask->getIndex() == $pIndex) {
                return $oTask;
            } else {
                if ($oTask->getTaskCount() > 0) {
                    $return = $this->getTaskFromIndex($pIndex, $oTask);
                    if ($return instanceof Task) {
                        return $return;
                    }
                }
            }
        }
        return null;
    }

    /**
     * Remove task by index
     *
     * @param int $pIndex Active task index
     * @throws \Exception
     */
    public function removeTaskByIndex($pIndex = 0)
    {
        if (!isset($this->taskCollection[$pIndex])) {
            throw new \Exception('Task index is out of bounds.');
        } else {
            array_splice($this->taskCollection, $pIndex, 1);
        }
    }
}
