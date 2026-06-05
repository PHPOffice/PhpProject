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
    private $phpProject;

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
        $resource->setIndex($domNode->getAttribute('id'));
        $resource->setTitle($domNode->getAttribute('name'));
    }
}
