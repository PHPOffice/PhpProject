<?php

/**
 * This file is part of PHPProject - A pure PHP library for reading and writing
 * project management files.
 *
 * PHPProject is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPProject/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPProject
 * @copyright   2010-2014 PHPProject contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

declare(strict_types=1);

namespace PhpOffice\PhpProject\Shared;

/**
 * XML Reader wrapper
 *
 * @since   0.10.0
 */
class XMLReader
{
    /**
     * DOMDocument object
     *
     * @var \DOMDocument
     */
    private $dom = null;

    /**
     * DOMXpath object
     *
     * @var \DOMXpath
     */
    private $xpath = null;

    /**
     * Get DOMDocument from ZipArchive
     *
     * @param string $zipFile
     * @param string $xmlFile
     * @return \DOMDocument|false
     * @throws \Exception
     */
    public function getDomFromZip(string $zipFile, string $xmlFile)
    {
        if (file_exists($zipFile) === false) {
            throw new \Exception('Cannot find archive file.');
        }

        $zip = new \ZipArchive();
        $zip->open($zipFile);
        $content = $zip->getFromName($xmlFile);
        $zip->close();

        if ($content === false) {
            return false;
        } else {
            return $this->getDomFromString($content);
        }
    }

    /**
     * Get DOMDocument from content string
     *
     * @param string $content
     * @return \DOMDocument
     */
    public function getDomFromString(string $content): \DOMDocument
    {
        $this->dom = new \DOMDocument();
        $this->dom->loadXML($content);

        return $this->dom;
    }

    /**
     * Get elements
     *
     * @param string $path
     * @param \DOMNode $contextNode
     * @return \DOMNodeList<\DOMElement>|array<\DOMElement>
     */
    public function getElements(string $path, ?\DOMNode $contextNode = null)
    {
        if ($this->dom === null) {
            return array();
        }
        if ($this->xpath === null) {
            $this->xpath = new \DOMXpath($this->dom);
        }

        return $this->xpath->query($path, $contextNode);
    }

    /**
     * Get element
     *
     * @param string $path
     * @param \DOMNode|null $contextNode
     * @return \DOMElement|null
     */
    public function getElement(string $path, ?\DOMNode $contextNode = null): ?\DOMElement
    {
        $elements = $this->getElements($path, $contextNode);
        $item = $elements->item(0);
        if ($item instanceof \DOMElement) {
            return $item;
        }
        return null;
    }

    /**
     * Get element attribute
     *
     * @param string $attribute
     * @param \DOMElement|null $contextNode
     * @param string $path
     * @return string|null
     */
    public function getAttribute(string $attribute, ?\DOMElement $contextNode = null, ?string $path = null): ?string
    {
        $return = null;
        if ($path !== null) {
            $elements = $this->getElements($path, $contextNode);
            if ($elements->length > 0) {
                /** @var \DOMElement $node Type hint */
                $node = $elements->item(0);
                $return = $node->getAttribute($attribute);
            }
        } else {
            if ($contextNode !== null) {
                $return = $contextNode->getAttribute($attribute);
            }
        }

        return ($return == '') ? null : $return;
    }

    /**
     * Get element value
     *
     * @param string $path
     * @param \DOMElement $contextNode
     * @return string|null
     */
    public function getValue(string $path, ?\DOMElement $contextNode = null): ?string
    {
        $elements = $this->getElements($path, $contextNode);
        if ($elements->length > 0) {
            return $elements->item(0)->nodeValue;
        } else {
            return null;
        }
    }

    /**
     * Count elements
     *
     * @param string $path
     * @param \DOMElement $contextNode
     * @return integer
     */
    public function countElements(string $path, ?\DOMElement $contextNode = null): int
    {
        $elements = $this->getElements($path, $contextNode);

        return $elements->length;
    }

    /**
     * Element exists
     *
     * @param string $path
     * @param \DOMElement $contextNode
     * @return boolean
     */
    public function elementExists(string $path, ?\DOMElement $contextNode = null): bool
    {
        return $this->getElements($path, $contextNode)->length > 0;
    }
}
