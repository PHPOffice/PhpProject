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
 * Planner
 *
 * @category    PHPProject
 * @package        PHPProject
 * @copyright    Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class Planner implements ReaderInterface
{
    /**
     * PHPProject object
     *
     * @var \PhpOffice\PhpProject\PhpProject
     */
    private $phpProject;

    /**
     * Create a new Planner
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
     * @return PHPProject
     */
    
    public function load(string $pFilename): PhpProject
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
                    case 'resources':
                        $this->readNodeResources($oXML, $oNode);
                        break;                    
                }
            }
        }
        
        return $this->phpProject;
    }

    /**
     * Node "Resources"
     * @param XMLReader $oXML
     * @param \DOMElement $domNode
     */
    private function readNodeResources(XMLReader $oXML, \DOMElement $domNode): void
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
     * @param \DOMElement $domNode
     * @param Resource $oResource
     */
    private function readNodeResource(\DOMElement $domNode, Resource $oResource): void
    {
        // Attributes
        $oResource->setIndex($domNode->getAttribute('id'));
        $oResource->setTitle($domNode->getAttribute('name'));
    }
}