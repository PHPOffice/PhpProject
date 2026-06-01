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

declare(strict_types=1);

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
    private $name = '';

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
     * Collection of Resource
     * 
     * @var Resource[]
     */
    private $resourceCollection = array();
    
    /**
     * Collection of task objects
     *
     * @var self[]
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
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Set name
     *
     * @param string $pValue Name of the task
     * @return self
     */
    public function setName(string $pValue): self
    {
        $this->name = $pValue;
        return $this;
    }
    
    /**
     * Get duration
     *
     * @return string|null
     */
    public function getDuration()
    {
        return $this->duration;
    }
    
    /**
     * Set duration (in days)
     *
     * @param int|float|string $pValue Duration of the resource
     * @return self
     */
    public function setDuration($pValue): self
    {
        $this->duration = $pValue;
        return $this;
    }
    
    /**
     * Get Start Date
     *
     * @return int|null
     */
    public function getStartDate(): ?int
    {
        return $this->startDate;
    }

    /**
     * Set Start Date
     *
     * @param int|string|null $pValue
     * @return self
     */
    public function setStartDate($pValue = null): self
    {
        if ($pValue === null) {
            $pValue = time();
        } elseif (is_string($pValue)) {
            if (is_numeric($pValue)) {
                $pValue = intval($pValue);
            } else {
                $pValue = strtotime($pValue);
                if ($pValue === false) {
                    $pValue = null;
                }
            }
        }

        $this->startDate = $pValue;
        return $this;
    }

    /**
     * Get End Date
     *
     * @return int|null
     */
    public function getEndDate(): ?int
    {
        return $this->endDate;
    }

    /**
     * Set End Date
     *
     * @param int|string|null $pValue
     * @return self
     */
    public function setEndDate($pValue = null): self
    {
        if ($pValue === null) {
            $pValue = time();
        } elseif (is_string($pValue)) {
            if (is_numeric($pValue)) {
                $pValue = intval($pValue);
            } else {
                $pValue = strtotime($pValue);
                if ($pValue === false) {
                    $pValue = null;
                }
            }
        }

        $this->endDate = $pValue;
        return $this;
    }
    
    /**
     * Get Progress
     *
     * @return float|null
     */
    public function getProgress(): ?float
    {
        return $this->progress;
    }
    
    /**
     * Set progress
     *
     * @param int|float|string $pValue Progress of the task
     * @return self
     */
    public function setProgress($pValue = 0): self
    {
        if (!is_numeric($pValue)) {
            $this->progress = 0;
            return $this;
        }
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
    public function getIndex(): int
    {
        return $this->index;
    }
    
    /**
     * Set index
     * @param int|string $value
     */
    public function setIndex($value): self
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
     * @param Resource $oResource
     */
    public function addResource(Resource $oResource): self
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
    public function getResources(): array
    {
        return $this->resourceCollection;
    }

    public function getResourceCount(): int
    {
        return count($this->resourceCollection);
    }
    
    //===============================================
    // Tasks
    //===============================================
    public function createTask(): self
    {
        $newTask = new self();
        $this->taskCollection[] = $newTask;
        return $newTask;
    }
    
    /**
     * Returns a collection of all subtasks created in the task
     *
     * @return self[]
     */
    public function getTasks(): array
    {
        return $this->taskCollection;
    }

    public function getTaskCount(): int
    {
        return count($this->taskCollection);
    }
}
