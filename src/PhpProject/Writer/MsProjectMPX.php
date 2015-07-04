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

namespace PhpOffice\PhpProject\Writer;

use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\Resource;
use PhpOffice\PhpProject\Task;

/**
 * MsProjectMPx
 *
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
     * Content to write in File
     * @var string[]
     */
    private $fileContent = array();
    
    
    /**
     * Create a new PHPProject_Writer_GanttProject
     *
     * @param    PHPProject    $phpProject
     */
    public function __construct(PhpProject $phpProject)
    {
        $this->phpProject = $phpProject;
    }
    
    /**
     * 
     * @param string $pFilename
     * @throws Exception
     */
    public function save($pFilename)
    {
        $arrProjectInfo = $this->sanitizeProject();
        
        $this->writeRecordMPX();
        // Project Header
        $this->writeRecord30($arrProjectInfo);
        // Text Resource Table Definition
        $this->writeRecord40();
        // Numeric Resource Table Definition
        $this->writeRecord41();
        // Resources
        foreach ($this->phpProject->getAllResources() as $oResource) {
            $this->writeRecord50($oResource);
        }
        // Text Task Table Definition
        $this->writeRecord60();
        // Numeric Task Table Definition
        $this->writeRecord61();
        // Tasks
        foreach ($this->phpProject->getAllTasks() as $oTask) {
            $this->writeRecord70($oTask);
        }
        
        // Writing XML Object in file
        // Open file
        if (file_exists($pFilename) && !is_writable($pFilename)) {
            throw new \Exception("Could not open file $pFilename for writing.");
        }
        $fileHandle = fopen($pFilename, 'wb+');
        // Write Content
        fwrite($fileHandle, implode(PHP_EOL, $this->fileContent));
        // Close file
        fclose($fileHandle);
    }
    
    /**
     * @return multitype:Ambigous <number, unknown>
     */
    private function sanitizeProject()
    {
        // Info Project
        $minDate = 0;
        // Browse all tasks
        $arrTasks = $this->phpProject->getAllTasks();
        foreach ($arrTasks as $oTask) {
            if ($oTask->getTaskCount() == 0) {
                $this->sanitizeTask($oTask);
            } else {
                $this->sanitizeTaskParent($oTask);
            }
            $tStartDate = $oTask->getStartDate();
            if ($minDate == 0 || $tStartDate < $minDate) {
                $minDate = $tStartDate;
            }
        }
        
        return array(
            'date_start' => (int)$minDate
        );
    }
    
    /**
     * Permits to clean a task
     * - If the duration is not filled, but the end date is, we calculate it.
     * - If the end date is not filled, but the duration is, we calculate it.
     * @param PHPProject_Task $oTask
     */
    private function sanitizeTask(Task $oTask)
    {
        $pDuration = $oTask->getDuration();
        $pEndDate = $oTask->getEndDate();
        $pStartDate = $oTask->getStartDate();
        
        if (is_null($pDuration) && !is_null($pEndDate)) {
            $iTimeDiff = $pEndDate - $pStartDate;
            $iNumDays = $iTimeDiff / 60 / 60 / 24;
            $oTask->setDuration($iNumDays + 1);
        } elseif (!is_null($pDuration) && is_null($pEndDate)) {
            $oTask->setEndDate($pStartDate + ($pDuration * 24 * 60 * 60));
        }
    }
    
    /**
     * Permits to clean parent task and calculate parent data like total duration,
     *   date start and complete average.
     * @param PHPProject_Task $oParentTask
     */
    private function sanitizeTaskParent(Task $oParentTask)
    {
        $arrTasksChilds = $oParentTask->getTasks();
        
        $iProgress = 0;
        $tStartDate = null;
        $tEndDate = null;
        foreach ($arrTasksChilds as $oTaskChild) {
            if ($oTaskChild->getTaskCount() == 0) {
                $this->sanitizeTask($oTaskChild);
            } else {
                $this->sanitizeTaskParent($oTaskChild);
            }
            
            $iProgress += $oTaskChild->getProgress();
            if (is_null($tStartDate)) {
                $tStartDate = $oTaskChild->getStartDate();
            } elseif ($tStartDate > $oTaskChild->getStartDate()) {
                $tStartDate = $oTaskChild->getStartDate();
            }
            
            if (is_null($tEndDate)) {
                $tEndDate = $oTaskChild->getEndDate();
            } elseif ($tEndDate < $oTaskChild->getEndDate()) {
                $tEndDate = $oTaskChild->getEndDate();
            }
        }
        $oParentTask->setProgress($iProgress / $oParentTask->getTaskCount());
        $oParentTask->setStartDate($tStartDate);
        $oParentTask->setEndDate($tEndDate);
        $oParentTask->setDuration((($tEndDate - $tStartDate) / 60 / 60 / 24) + 1);
    }

    /**
     * Record MPX
     */
    private function writeRecordMPX()
    {
        $this->fileContent[] = 'MPX;Microsoft Project for Windows;4.0;ANSI';
    }
    
    /**
     * Record "Project Header"
     */
    private function writeRecord30(array $arrProjectInfo)
    {
        $this->fileContent[] = '30;Project1;;;Standard;'.date('d/m/Y', $arrProjectInfo['date_start']).';;0;'.date('d/m/Y').';;$0,00;$0,00;$0,00;0h;0h;0h;0%;0d;0d;0d;0%;;;;;0d;0d';
    }
    
    /**
     * Record "Text Resource Table Definition"
     */
    private function writeRecord40()
    {
        $this->fileContent[] = '40;ID;Name';
    }
    
    /**
     * Record "Numeric Resource Table Definition"
     */
    private function writeRecord41()
    {
        $this->fileContent[] = '41;40;1';
    }

    /**
     * Record "Resource"
     * @param Resource $oResource
     */
    private function writeRecord50(Resource $oResource)
    {
        $this->fileContent[] = '50;'.$oResource->getIndex().';'.$oResource->getTitle();
    }

    /**
     * Record "Text Task Table Definition"
     */
    private function writeRecord60()
    {
        $this->fileContent[] = '60;ID;Name;Duration;% Complete;Start';
    }
    
    /**
     * Record "Numeric Task Table Definition"
     */
    private function writeRecord61()
    {
        $this->fileContent[] = '61;90;1;40;44;50';
    }

    /**
     * Record "Task"
     * @param Task $oTask
     */
    private function writeRecord70(Task $oTask)
    {
        $this->fileContent[] = '70;'.$oTask->getIndex().';'.$oTask->getName().';'.$oTask->getDuration().'d;'.number_format($oTask->getProgress(), 1).';'.date('d/m/Y', $oTask->getStartDate());
        
        foreach ($oTask->getResources() as $oResource) {
            $this->writeRecord75($oResource);
        }
        
        foreach ($oTask->getTasks() as $oSubTask) {
            $this->writeRecord70($oSubTask);
        }
    }
    
    /**
     * Record "Resource Assignment"
     * @param Resource $oResource
     */
    private function writeRecord75(Resource $oResource)
    {
        $this->fileContent[] = '75;'.$oResource->getIndex().';1;;;;;;;;;;;';
    }
}
