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
use PhpOffice\PhpProject\Shared\XMLWriter;
use PhpOffice\PhpProject\Task;

/**
 * PHPProject_Writer_GanttProject
 *
 * @category    PHPProject
 * @package        PHPProject
 * @copyright    Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class GanttProject
{
    /**
     * PHPProject object
     *
     * @var \PhpOffice\PhpProject\PhpProject
     */
    private $phpProject;
    
    /**
     * 
     * @var array
     */
    private $arrAllocations;
    
    
    /**
     * Create a new PHPProject_Writer_GanttProject
     *
     * @param    PHPProject    $phpProject
     */
    public function __construct(PhpProject $phpProject)
    {
        $this->phpProject = $phpProject;
        $this->arrAllocations = array();
    }
    
    /**
     * 
     * @param string $pFilename
     * @throws Exception
     */
    public function save($pFilename)
    {
        $arrProjectInfo = $this->sanitizeProject();
        
        // Create XML Object
        $oXML = new XMLWriter(XMLWriter::STORAGE_DISK);
        $oXML->startDocument('1.0', 'UTF-8');
        // project
        $oXML->startElement('project');
        if (isset($arrProjectInfo['date_start']) && $arrProjectInfo['date_start'] != 0) {
            $oXML->writeAttribute('view-date', date('Y-m-d', $arrProjectInfo['date_start']));
        }
        $oXML->writeAttribute('version', '2.0');
        
        // view
        $oXML->startElement('view');
        $oXML->writeAttribute('id', 'resource-table');
        
        // field
        $oXML->startElement('field');
        $oXML->writeAttribute('id', '0');
        $oXML->writeAttribute('name', 'Nom');
        $oXML->writeAttribute('width', '56');
        $oXML->writeAttribute('valuetype', '0');
        $oXML->endElement();
        
        $oXML->startElement('field');
        $oXML->writeAttribute('id', '1');
        $oXML->writeAttribute('name', 'Rôle par défaut');
        $oXML->writeAttribute('width', '43');
        $oXML->writeAttribute('valuetype', '1');
        $oXML->endElement();
        
        // >view
        $oXML->endElement();
        
        // tasks
        $oXML->startElement('tasks');
        
        // tasksproperties
        $oXML->startElement('tasksproperties');
        
        // taskproperty
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd0');
        $oXML->writeAttribute('name', 'type');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'icon');
        $oXML->endElement();
        
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd1');
        $oXML->writeAttribute('name', 'priority');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'icon');
        $oXML->endElement();
        
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd2');
        $oXML->writeAttribute('name', 'info');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'icon');
        $oXML->endElement();
        
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd3');
        $oXML->writeAttribute('name', 'name');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'text');
        $oXML->endElement();
        
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd4');
        $oXML->writeAttribute('name', 'begindate');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'date');
        $oXML->endElement();
        
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd5');
        $oXML->writeAttribute('name', 'enddate');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'date');
        $oXML->endElement();
        
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd6');
        $oXML->writeAttribute('name', 'duration');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'int');
        $oXML->endElement();
        
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd7');
        $oXML->writeAttribute('name', 'completion');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'int');
        $oXML->endElement();
        
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd8');
        $oXML->writeAttribute('name', 'coordinator');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'text');
        $oXML->endElement();
        
        $oXML->startElement('taskproperty');
        $oXML->writeAttribute('id', 'tpd9');
        $oXML->writeAttribute('name', 'predecessorsr');
        $oXML->writeAttribute('type', 'default');
        $oXML->writeAttribute('valuetype', 'text');
        $oXML->endElement();
        // >taskproperty
        
        // >tasksproperties
        $oXML->endElement();
        
        // task
        foreach ($this->phpProject->getAllTasks() as $oTask) {
            $this->writeTask($oXML, $oTask);
        }
        
        // >tasks
        $oXML->endElement();
        
        // resources
        $oXML->startElement('resources');
        
        // resource
        foreach ($this->phpProject->getAllResources() as $oResource) {
            $this->writeResource($oXML, $oResource);
        }
        
        // >resources
        $oXML->endElement();
        
        // allocations
        $oXML->startElement('allocations');
        
        if (count($this->arrAllocations) > 0) {
            foreach ($this->arrAllocations as $itmAllocation) {
                $this->writeAllocation($oXML, $itmAllocation['id_task'], $itmAllocation['id_res']);
            }
        }
        
        // >allocations
        $oXML->endElement();
        
        // taskdisplaycolumns
        $oXML->startElement('tasksproperties');
        
        // displaycolumn
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd2');
        $oXML->writeAttribute('order', '-1');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'false');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd7');
        $oXML->writeAttribute('order', '-1');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'false');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd6');
        $oXML->writeAttribute('order', '-1');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'false');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd10');
        $oXML->writeAttribute('order', '-1');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'false');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd1');
        $oXML->writeAttribute('order', '-1');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'false');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd9');
        $oXML->writeAttribute('order', '-1');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'false');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd8');
        $oXML->writeAttribute('order', '-1');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'false');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd0');
        $oXML->writeAttribute('order', '-1');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'false');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd3');
        $oXML->writeAttribute('order', '0');
        $oXML->writeAttribute('width', '199');
        $oXML->writeAttribute('visible', 'true');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd4');
        $oXML->writeAttribute('order', '1');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'true');
        $oXML->endElement();
        
        $oXML->startElement('displaycolumn');
        $oXML->writeAttribute('property-id', 'tpd5');
        $oXML->writeAttribute('order', '2');
        $oXML->writeAttribute('width', '75');
        $oXML->writeAttribute('visible', 'true');
        $oXML->endElement();
        // >displaycolumn
        
        // >taskdisplaycolumns
        $oXML->endElement();
        
        // >project
        $oXML->endElement();
        
        // Writing XML Object in file
        // Open file
        if (file_exists($pFilename) && !is_writable($pFilename)) {
            throw new \Exception("Could not open file $pFilename for writing.");
        }
        $fileHandle = fopen($pFilename, 'wb+');
        // Write XML Content
        fwrite($fileHandle, $oXML->getData());
        // Close file
        fclose($fileHandle);
    }
    
    private function writeTask(XMLWriter $oXML, Task $oTask)
    {
        $oXML->startElement('task');
        $oXML->writeAttribute('id', $oTask->getIndex());
        $oXML->writeAttribute('name', $oTask->getName());
        $oXML->writeAttribute('start', date('Y-m-d', $oTask->getStartDate()));
        $oXML->writeAttribute('duration', $oTask->getDuration());
        $oXML->writeAttribute('complete', $oTask->getProgress() * 100);
        $oXML->writeAttribute('meeting', 'false');
        $oXML->writeAttribute('expand', 'true');
        
        // Resources Allocations
        if ($oTask->getResourceCount() > 0) {
            foreach ($oTask->getResources() as $oResource) {
                $itmAllocation = array();
                $itmAllocation['id_res'] = $oResource->getIndex();
                $itmAllocation['id_task'] = $oTask->getIndex();
                $this->arrAllocations[] = $itmAllocation;
            }
        }
        
        // Children
        if ($oTask->getTaskCount() > 0) {
            $arrTasksChilds = $oTask->getTasks();
            foreach ($arrTasksChilds as $oTaskChild) {
                $this->writeTask($oXML, $oTaskChild);
            }
        } else {
            // Nothing
        }
        $oXML->endElement();
    }
    
    /**
     * 
     * @param XMLWriter $oXML
     * @param \PhpOffice\PhpProject\Resource $oResource
     */
    private function writeResource(XMLWriter $oXML, \PhpOffice\PhpProject\Resource $oResource)
    {
        $oXML->startElement('resource');
        $oXML->writeAttribute('id', $oResource->getIndex());
        $oXML->writeAttribute('name', $oResource->getTitle());
        $oXML->writeAttribute('function', 'Default:0');
        $oXML->writeAttribute('contacts', '');
        $oXML->writeAttribute('phone', '');
        $oXML->endElement();
    }
    
    /**
     * Write allocation of a resource for a task
     * @param XMLWriter $oXML
     * @param integer $piIdTask
     * @param integer $piIdResource
     */
    private function writeAllocation(XMLWriter $oXML, $piIdTask, $piIdResource)
    {
        $oXML->startElement('allocation');
        $oXML->writeAttribute('task-id', $piIdTask);
        $oXML->writeAttribute('resource-id', $piIdResource);
        $oXML->writeAttribute('function', 'Default:0');
        $oXML->writeAttribute('responsible', 'true');
        $oXML->writeAttribute('load', '100.0');
        $oXML->endElement();
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
}
