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
use PhpOffice\PhpProject\Resource;
use PhpOffice\PhpProject\Shared\XMLReader;
use PhpOffice\PhpProject\Task;

/**
 * GanttProject
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
        if (file_exists($pFilename) && is_readable($pFilename)) {
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param string $pFilename
     * @throws \Exception
     * @return PHPProject
     */
    public function load($pFilename)
    {
        if (!file_exists($pFilename) || !is_readable($pFilename)) {
            throw new \Exception('The file is not accessible.');
        }
        $content = file_get_contents($pFilename);
        $oXML = new XMLReader();
        $oXML->getDomFromString($content);
        
        $oNodes = $oXML->getElements('*');
        if ($oNodes->length > 0) {
            foreach ($oNodes as $oNode) {
                switch ($oNode->nodeName) {
                    case 'allocations':
                        $this->readNodeAllocations($oXML, $oNode);
                        break;
                    case 'description':
                        $this->readNodeDescription($oNode);
                        break;
                    case 'resources':
                        $this->readNodeResources($oXML, $oNode);
                        break;
                    case 'tasks':
                        $this->readNodeTasks($oXML, $oNode);
                        break;
                }
            }
        }
        
        return $this->phpProject;
    }
    
    /**
     * Node "Description"
     * @param XMLReader $oXML
     * @param \DOMElement $domNode
     */
    private function readNodeDescription(\DOMElement $domNode)
    {
        $this->phpProject->getProperties()->setDescription($domNode->nodeValue);
    }
    
    /**
     * Node "Tasks"
     * @param XMLReader $oXML
     * @param \DOMElement $domNode
     */
    private function readNodeTasks(XMLReader $oXML, \DOMElement $domNode)
    {
        $oNodes = $oXML->getElements('*', $domNode);
        if ($oNodes->length > 0) {
            foreach ($oNodes as $oNode) {
                if ($oNode->nodeName == 'task') {
                    $oTask = $this->phpProject->createTask();
                    $this->readNodeTask($oXML, $oNode, $oTask);
                }
            }
        }
    }
    
    /**
     * Node "Task"
     * @param XMLReader $oXML
     * @param \DOMElement $domNode
     */
    private function readNodeTask(XMLReader $oXML, \DOMElement $domNode, Task $oTask)
    {
        // Attributes
        $oTask->setIndex($domNode->getAttribute('id'));
        $oTask->setName($domNode->getAttribute('name'));
        $oTask->setStartDate($domNode->getAttribute('start'));
        $oTask->setDuration($domNode->getAttribute('duration'));
        $oTask->setProgress($domNode->getAttribute('complete'));
        
        // SubNodes
        $oNodes = $oXML->getElements('*', $domNode);
        if ($oNodes->length > 0) {
            foreach ($oNodes as $oNode) {
                if ($oNode->nodeName == 'task') {
                    $oTaskChild = $oTask->createTask();
                    $this->readNodeTask($oXML, $oNode, $oTaskChild);
                }
            }
        }
    }
    
    /**
     * Node "Resources"
     * @param XMLReader $oXML
     * @param \DOMElement $domNode
     */
    private function readNodeResources(XMLReader $oXML, \DOMElement $domNode)
    {
        $oNodes = $oXML->getElements('*', $domNode);
        if ($oNodes->length > 0) {
            foreach ($oNodes as $oNode) {
                if ($oNode->nodeName == 'resource') {
                    $oResource = $this->phpProject->createResource();
                    $this->readNodeResource($oNode, $oResource);
                }
            }
        }
    }
    /**
     * Node "Resource"
     * @param XMLReader $oXML
     * @param \DOMElement $domNode
     */
    private function readNodeResource(\DOMElement $domNode, Resource $oResource)
    {
        // Attributes
        $oResource->setIndex($domNode->getAttribute('id'));
        $oResource->setTitle($domNode->getAttribute('name'));
    }
    
    /**
     * Node "Allocations"
     * @param XMLReader $oXML
     * @param \DOMElement $domNode
     */
    private function readNodeAllocations(XMLReader $oXML, \DOMElement $domNode)
    {
        $oNodes = $oXML->getElements('*', $domNode);
        if ($oNodes->length > 0) {
            foreach ($oNodes as $oNode) {
                if ($oNode->nodeName == 'allocation') {
                    $this->readNodeAllocation($oNode);
                }
            }
        }
    }
    /**
     * Node "Allocation"
     * @param XMLReader $oXML
     * @param \DOMElement $domNode
     */
    private function readNodeAllocation(\DOMElement $domNode)
    {
        // Attributes
        $idTask = $domNode->getAttribute('task-id');
        $idResource = $domNode->getAttribute('resource-id');
        
        $oResource = $this->phpProject->getResourceFromIndex($idResource);
        $oTask = $this->phpProject->getTaskFromIndex($idTask);
        
        if ($oResource instanceof Resource && $oTask instanceof Task) {
            $oTask->addResource($oResource);
        }
    }
}
