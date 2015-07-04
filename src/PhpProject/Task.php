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
     * @var int
     */
    private $startDate;
    
    /**
     * End Date
     *
     * @var int
     */
    private $endDate;
    
    /**
     * Progress
     *
     * @var    float
     */
    private $progress;
    
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
    private $resourceCollection = array();
    
    /**
     * Collection of task objects
     *
     * @var PHPProject_Task[]
     */
    private $taskCollection = array();
    
    /**
     * Index of Resource
     * @var integer
     */
    public static $lastIndex = 0;
    
    public function __construct()
    {
        $this->index = self::$lastIndex;
        self::$lastIndex++;
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
     * Set duration (in days)
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
     * @param int $pValue
     * @return DocumentInformations
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
     * @param int $pValue
     * @return DocumentInformations
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
            $this->progress = (double)1;
        } elseif ($pValue < 0) {
            $this->progress = (double)0;
        } else {
            $this->progress = (double)$pValue;
        }
        return $this;
    }
    
    /**
     * Get index
     */
    public function getIndex()
    {
        return $this->index;
    }
    
    /**
     * Set index
     * @param integer $value
     */
    public function setIndex($value)
    {
        if (is_numeric($value)) {
            $this->index = (int)$value;
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
    public function addResource(Resource $oResource)
    {
        if (!in_array($oResource, $this->resourceCollection)) {
            $this->resourceCollection[] = &$oResource;
        }
        return $this;
    }

    /**
     * Returns a collection of all resources used by the task
     * 
     * @return Resource[]
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
        $newTask = new self();
        $this->taskCollection[] = $newTask;
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
