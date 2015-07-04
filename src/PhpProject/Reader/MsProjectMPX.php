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

namespace PhpOffice\PhpProject\Reader;

use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\Task;

/**
 * MPX File Format
 * @link http://support.microsoft.com/kb/270139/en-us
 * @category    PHPProject
 * @package        PHPProject
 * @copyright    Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class MsProjectMPX
{
    /**
     * PHPProject object
     *
     * @var \PhpOffice\PhpProject\PhpProject
     */
    private $phpProject;
    
    /**
     * Numeric Resource Table
     * @var string[]
     */
    private $defResource = array();
    
    /**
     * Numeric Table Table
     * @var string[]
     */
    private $defTask = array();
    
    /**
     * Index in $defTask for the precedessor
     * @var integer
     */
    private $iParentTaskIdx;
    
    /**
     * last Task created
     * @var Task
     */
    private $oPreviousTask;
    
    /**
     * Create a new GanttProject
     */
    public function __construct()
    {
        $this->phpProject = new PhpProject();
    }
    /**
     *
     * @param string $pFilename
     * @return PHPProject
     */
    public function canRead($pFilename)
    {
        if (!file_exists($pFilename) || !is_readable($pFilename)) {
            return false;
        }
        $sContent = file_get_contents($pFilename);
        $arrayLines = explode(PHP_EOL, $sContent);
        
        // The only required record is the File Creation record
        foreach ($arrayLines as $sLine) {
            $arrayRecord = explode(';', $sLine);
            if (!is_numeric($arrayRecord[0]) && $arrayRecord[0] == 'MPX') {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * 
     * @param string $pFilename
     * @throws \Exception
     * @return PHPProject|null
     */
    public function load($pFilename)
    {
        if (!$this->canRead($pFilename)) {
            throw new \Exception('The file is not accessible.');
        }
        $sContent = file_get_contents($pFilename);
        $arrayLines = explode(PHP_EOL, $sContent);
        
        foreach ($arrayLines as $sLine) {
            $arrayRecord = explode(';', $sLine);
            switch ($arrayRecord[0]) {
                case 'MPX': // File Creation
                case '10': // Currency Settings
                case '11': // Default Settings
                case '12': // Date and Time Settings
                case '20': // Base Calendar Definition
                case '25': // Base Calendar Hours
                case '26': // Base Calendar Exception
                    break;
                case '30': // Project Header
                    $this->readRecord30($arrayRecord);
                    break;
                case '40': // Text Resource Table Definition
                    // Label for 41
                    break;
                case '41': // Numeric Resource Table Definition
                    $this->readRecord41($arrayRecord);
                    break;
                case '50': // Resource
                    $this->readRecord50($arrayRecord);
                    break;
                //case '51': // Resource Notes
                //case '55': // Resource Calendar Definition
                //case '56': // Resource Calendar Hours
                //case '57': // Resource Calendar Exception
                //    break;
                case '60': // Text Task Table Definition
                    // Label for 61
                    break;
                case '61': // Numeric Task Table Definition
                    $this->readRecord61($arrayRecord);
                    break;
                case '70': // Task
                    $this->readRecord70($arrayRecord);
                    break;
                //case '71': // Task Notes
                //case '72': // Recurring Task
                //    break;
                case '75': // Resource Assignment
                    $this->readRecord75($arrayRecord);
                    break;
                case '76': // Resource Assignment Workgroup Fields
                case '80': // Project Names
                case '81': // DDE and OLE Client Links
                case '0': // Comments
                default:
                    // throw new \Exception('load : Not implemented ('.$arrayRecord[0].')');
            }
        }
        
        return $this->phpProject;
    }
    
    /**
     * Project Header
     * @param array $record
     */
    private function readRecord30(array $record)
    {
        // 0 : Record
        // 1 : Project tab
        // 2 : Company
        // 3 : Manager
        // 4 : Calendar (Standard used if no entry)
        // 5 : Start Date (either this field or the next field is calculated for an imported file, depending on the Schedule From setting)
        if (isset($record[5]) && !empty($record[5])) {
            $this->phpProject->getInformations()->setStartDate($record[5]);
        }
        // 6 : Finish Date
        //if (isset($record[6]) && !empty($record[6])) {
        //    $this->phpProject->getInformations()->setEndDate($record[6]);
        //}
        // 7 : Schedule From (0 = start, 1 = finish)
        // 8 : Current Date*
        // 9 : Comments
        // 10 : Cost*
        // 11 : Baseline Cost
        // 12 : Actual Cost
        // 13 : Work
        // 14 : Baseline Work
        // 15 : Actual Work
        // 16 : Work
        // 17 : Duration
        // 18 : Baseline Duration
        // 19 : Actual Duration
        // 20 : Percent Complete
        // 21 : Baseline Start
        // 22 : Baseline Finish
        // 23 : Actual Start
        // 24 : Actual Finish
        // 25 : Start Variance
        // 26 : Finish Variance
        // 27 : Subject
        // 28 : Author
        // 29 : Keywords
    }
    
    /**
     * Numeric Resource Table Definition
     * @param array $record
     */
    private function readRecord41(array $record)
    {
        array_shift($record);
        foreach ($record as $key => $item) {
            switch ($item) {
                case 1: // Name
                    $this->defResource[$key+1] = 'setTitle';
                    break;
                case 40: // ID
                    $this->defResource[$key+1] = 'setIndex';
                    break;
                case 41: // Max Units
                    break;
                case 49: // Unique ID
                    break;
                //default:
                    //throw new \Exception('readRecord41 : Not implemented ('.$item.')');
            }
        }
    }
    
    /**
     * Resource
     * @param array $record
     */
    private function readRecord50(array $record)
    {
        $oResource = $this->phpProject->createResource();
        
        foreach ($this->defResource as $key => $method) {
            $oResource->{$method}($record[$key]);
        }
    }
    
    /**
     * Numeric Task Table Definition
     * @param array $record
     */
    private function readRecord61(array $record)
    {
        array_shift($record);
        foreach ($record as $key => $item) {
            switch ($item) {
                case 1: // Name
                    $this->defTask[$key + 1] = 'setName';
                    break;
                case 2: // WBS
                    break;
                case 3: // Outline Level
                    break;
                case 40: // Duration
                    $this->defTask[$key + 1] = 'setDuration';
                    break;
                case 44: // % Complete
                    $this->defTask[$key + 1] = 'setProgress';
                    break;
                case 50: // Start
                    $this->defTask[$key + 1] = 'setStartDate';
                    break;
                case 58: // Actual Start
                    break;
                case 70: // Predecessors
                    $this->iParentTaskIdx = $key + 1;
                    break;
                case 80: // Fixed
                    break;
                case 90: // ID
                    $this->defTask[$key + 1] = 'setIndex';
                    break;
                case 91: // Constraint Type
                    break;
                case 98: // Unique ID
                    break;
                case 99: // Outline Number
                    break;
                case 120: // Summary
                    break;
                //default:
                    //throw new \Exception('readRecord41 : Not implemented ('.$item.')');
            }
        }
    }
    
    /**
     * Task
     * @param array $record
     */
    private function readRecord70(array $record)
    {
        $oTask = null;
        if (!is_null($this->iParentTaskIdx) && !empty($record[$this->iParentTaskIdx])) {
            $oTaskParent = $this->phpProject->getTaskFromIndex($record[$this->iParentTaskIdx]);
            if (is_object($oTaskParent)) {
                $oTask = $oTaskParent->createTask();
            }
        }
        if (is_null($oTask)) {
            $oTask = $this->phpProject->createTask();
        }
        
        foreach ($this->defTask as $key => $method) {
            if ($method == 'setDuration') {
                if (substr($record[$key], -1) == 'd') {
                    $record[$key] = intval(substr($record[$key], 0, -1));
                }
            }
            if ($method == 'setProgress') {
                if (substr($record[$key], -1) == '%') {
                    $record[$key] = substr($record[$key], 0, -1);
                    $record[$key] = str_replace(',', '.', $record[$key]);
                    $record[$key] = floatval($record[$key]) / 100;
                }
            }
            $oTask->{$method}($record[$key]);
        }
        $this->oPreviousTask = $oTask;
    }
    
    /**
     * Resource Assignment
     * @param array $record
     */
    private function readRecord75(array $record)
    {
        // 0 : Record
        // 1 : ID
        $idResource = null;
        if (isset($record[1]) && !empty($record[1])) {
            $idResource = $record[1];
        }
        // 2 : Units
        // 3 : Work
        // 4 : Planned Work
        // 5 : Actual Work
        // 6 : Overtime Work
        // 7 : Cost
        // 8 : Planned Cost
        // 9 : Actual Cost
        // 10 : Start*
        // 11 : Finish*
        // 12 : Delay
        // 13 : Resource Unique ID
        
        if (!is_null($idResource) && $this->oPreviousTask instanceof Task) {
            $oResource = $this->phpProject->getResourceFromIndex($idResource);
            if (!is_null($oResource)) {
                $this->oPreviousTask->addResource($oResource);
            }
        }
    }
}
