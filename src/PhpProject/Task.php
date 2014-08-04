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
 * PHPProject_Task
 *
 * @category    PHPProject
 * @package        PHPProject
 * @copyright    Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class Task
{
    /**
     * Name
     * 
     * @var string
     */
    private $name;
    
    /**
     * Duration
     * 
     * @var string
     */
    private $duration;
    
    /**
     * Start Date
     *
     * @var    datetime
     */
    private $startDate;
    
    /**
     * End Date
     *
     * @var    datetime
     */
    private $endDate;
    
    /**
     * Progress
     *
     * @var    float
     */
    private $progress;
    
    /**
     * Parent Project
     * 
     * @var PHPProject
     */
    private $parentProject;
    
    /**
     * Parent Task
     *
     * @var PHPProject_Task
     */
    private $parentTask;
    
    /**
     * Index
     *
     * @var integer
     */
    private $index;
    
    /**
     * Collection of PHPProject_Resource index
     * 
     * @var integer[]
     */
    private $resourceCollection;
    
    /**
     * Collection of task objects
     *
     * @var PHPProject_Task[]
     */
    private $taskCollection = array();
    
    /**
     * Active task
     *
     * @var int
     */
    private $_activeTaskIndex = 0;
    
    public function __construct(PhpProject $pParent, $pIndex, Task $pParentTask = null)
    {
        $this->parentProject = $pParent;
        $this->parentTask = $pParentTask;
        $this->index = $pIndex;
        
        $this->resourceCollection = array();
    }
    
    /**
     * Get parent
     *
     * @return PHPProject
     */
    public function getParent()
    {
        return $this->_parent;
    }

    /**
     * Get parent task
     *
     * @return PHPProject_Task
     */
    public function getParentTask()
    {
        return $this->parentTask;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set name
     *
     * @param string $pValue Name of the task
     * @return PHPProject_Task
     */
    public function setName($pValue)
    {
        $this->name = $pValue;
        return $this;
    }
    
    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }
    
    /**
     * Set duration
     *
     * @param string $pValue Duration of the resource
     * @return PHPProject_Task
     */
    public function setDuration($pValue)
    {
        $this->duration = $pValue;
        return $this;
    }
    
    /**
     * Get Start Date
     *
     * @return    datetime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set Start Date
     *
     * @param    datetime    $pValue
     * @return    PHPProject_DocumentInformations
     */
    public function setStartDate($pValue = null)
    {
        if ($pValue === null) {
            $pValue = time();
        } elseif (is_string($pValue)) {
            if (is_numeric($pValue)) {
                $pValue = intval($pValue);
            } else {
                $pValue = strtotime($pValue);
            }
        }

        $this->startDate = $pValue;
        return $this;
    }

    /**
     * Get End Date
     *
     * @return    datetime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set End Date
     *
     * @param    datetime    $pValue
     * @return    PHPProject_DocumentInformations
     */
    public function setEndDate($pValue = null)
    {
        if ($pValue === null) {
            $pValue = time();
        } elseif (is_string($pValue)) {
            if (is_numeric($pValue)) {
                $pValue = intval($pValue);
            } else {
                $pValue = strtotime($pValue);
            }
        }

        $this->endDate = $pValue;
        return $this;
    }
    
    /**
     * Get Progress
     *
     * @return float
     */
    public function getProgress()
    {
        return $this->progress;
    }
    
    /**
     * Set progress
     *
     * @param float $pValue Progress of the task
     * @return PHPProject_Task
     */
    public function setProgress($pValue = 0)
    {
        if ($pValue > 1) {
            $this->progress = 1;
        } elseif ($pValue < 0) {
            $this->progress = 0;
        } else {
            $this->progress = $pValue;
        }
        return $this;
    }
    
    //===============================================
    // Resources
    //===============================================
    /**
     * Add a resource used by the current task
     * @param PHPProject_Resource $pResource
     */
    public function addResource(Resource $pResource)
    {
        if (array_search($pResource->getIndex(), $this->resourceCollection) === false) {
            $this->resourceCollection[] = $pResource->getIndex();
        }
        return $this;
    }

    /**
     * Returns a collection of all resources used by the task
     * 
     * @return integer[]
     */
    public function getResources()
    {
        return $this->resourceCollection;
    }

    public function getResourceCount()
    {
        return count($this->resourceCollection);
    }
    
    //===============================================
    // Tasks
    //===============================================
    public function createTask()
    {
        $newTask = new self($this->parentProject, $this->getTaskCount(), $this);
        $this->taskCollection[] = $newTask;
        $this->_activeTaskIndex = $this->getTaskCount() - 1;
        return $newTask;
    }
    
    /**
     * Returns a collection of all subtasks created in the task
     *
     * @return PHPProject_Task[]
     */
    public function getTasks()
    {
        return $this->taskCollection;
    }

    public function getTaskCount()
    {
        return count($this->taskCollection);
    }
}
