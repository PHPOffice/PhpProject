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

namespace PhpOffice\PhpProject\Reader;

use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\Resource;
use PhpOffice\PhpProject\Shared\XMLReader;
use PhpOffice\PhpProject\Task;

/**
 * GnomePlanner
 */
class GnomePlanner implements ReaderInterface
{
    /**
     * PHPProject object
     *
     * @var PhpProject
     */
    protected $phpProject;

    /**
     * Create a new GnomePlanner
     */
    public function __construct()
    {
        $this->phpProject = new PhpProject();
    }

    /**
     *
     * @param string $pFilename
     * @return bool
     */
    public function canRead(string $pFilename): bool
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
     * @return PhpProject
     */
    public function load(string $pFilename): PhpProject
    {
        if (!$this->canRead($pFilename)) {
            throw new \Exception('The file is not accessible.');
        }
        $content = file_get_contents($pFilename);
        $xml = new XMLReader();
        $xml->getDomFromString($content);

        $nodes = $xml->getElements('*');
        if ($nodes->length > 0) {
            foreach ($nodes as $node) {
                switch ($node->nodeName) {
                    case 'resources':
                        $this->readNodeResources($xml, $node);
                        break;
                    case 'tasks':
                        $this->readNodeTasks($xml, $node);
                        break;
                    case 'allocations':
                        $this->readNodeAllocations($xml, $node);
                        break;
                }
            }
        }

        return $this->phpProject;
    }

    /**
     * Node "Resources"
     * @param XMLReader $xml
     * @param \DOMElement $domNode
     */
    protected function readNodeResources(XMLReader $xml, \DOMElement $domNode): void
    {
        $nodes = $xml->getElements('*', $domNode);
        if ($nodes->length > 0) {
            foreach ($nodes as $node) {
                if ($node->nodeName == 'resource') {
                    $resource = $this->phpProject->createResource();
                    $this->readNodeResource($node, $resource);
                }
            }
        }
    }

    /**
     * Node "Resource"
     * @param \DOMElement $domNode
     * @param Resource $resource
     */
    protected function readNodeResource(\DOMElement $domNode, Resource $resource): void
    {
        // Attributes
        if ($domNode->hasAttribute('id')) {
            $resource->setIndex($domNode->getAttribute('id'));
        }
        if ($domNode->hasAttribute('name')) {
            $resource->setTitle($domNode->getAttribute('name'));
        }
    }

    /**
     * Node "Tasks"
     * @param XMLReader $xml
     * @param \DOMElement $domNode
     */
    protected function readNodeTasks(XMLReader $xml, \DOMElement $domNode): void
    {
        $nodes = $xml->getElements('*', $domNode);
        if ($nodes->length > 0) {
            foreach ($nodes as $node) {
                if ($node->nodeName == 'task') {
                    $task = $this->phpProject->createTask();
                    $this->readNodeTask($xml, $node, $task);
                }
            }
        }
    }

    /**
     * Node "Task"
     * @param XMLReader $xml
     * @param \DOMElement $domNode
     */
    protected function readNodeTask(XMLReader $xml, \DOMElement $domNode, Task $task): void
    {
        // Attributes
        if ($domNode->hasAttribute('id')) {
            $task->setIndex($domNode->getAttribute('id'));
        }
        if ($domNode->hasAttribute('name')) {
            $task->setName($domNode->getAttribute('name'));
        }
        if ($domNode->hasAttribute('start')) {
            $task->setStartDate($domNode->getAttribute('start'));
        }
        if ($domNode->hasAttribute('end')) {
            $task->setEndDate($domNode->getAttribute('end'));
        }
        if ($domNode->hasAttribute('work')) {
            $task->setDuration($domNode->getAttribute('work'));
        }
        if ($domNode->hasAttribute('percent-complete')) {
            $task->setProgress((float) $domNode->getAttribute('percent-complete') / 100);
        }

        // SubNodes
        $nodes = $xml->getElements('*', $domNode);
        if ($nodes->length > 0) {
            foreach ($nodes as $node) {
                if ($node->nodeName == 'task') {
                    $taskChild = $task->createTask();
                    $this->readNodeTask($xml, $node, $taskChild);
                }
            }
        }
    }

    /**
     * Node "Allocations"
     * @param XMLReader $xml
     * @param \DOMElement $domNode
     */
    protected function readNodeAllocations(XMLReader $xml, \DOMElement $domNode): void
    {
        $nodes = $xml->getElements('*', $domNode);
        if ($nodes->length > 0) {
            foreach ($nodes as $node) {
                if ($node->nodeName == 'allocation') {
                    $this->readNodeAllocation($node);
                }
            }
        }
    }

    /**
     * Node "Allocation"
     * @param \DOMElement $domNode
     */
    protected function readNodeAllocation(\DOMElement $domNode): void
    {
        // Attributes
        $idTask = $domNode->getAttribute('task-id');
        $idResource = $domNode->getAttribute('resource-id');

        $resource = $this->phpProject->getResourceFromIndex($idResource);
        $task = $this->phpProject->getTaskFromIndex($idTask);

        if ($resource instanceof Resource && $task instanceof Task) {
            $task->addResource($resource);
        }
    }
}

