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
 * PHPProject_DocumentInformations
 *
 * @category    PHPProject
 * @package        PHPProject
 * @copyright    Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class DocumentInformations
{
    /**
     * Start Date
     * @var int
     */
    private $startDate;

    /**
     * End Date
     * @var int
     */
    private $endDate;

    /**
     * Create a new PHPProject_DocumentInformations
     */
    public function __construct()
    {
    }

    /**
     * Get Start Date
     * @return int
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set Start Date
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
     * @return int
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set End Date
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
}
