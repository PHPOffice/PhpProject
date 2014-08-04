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
/**
 * PHPProject_Reader_MSProjectExchange
 *
 * Docs : 
 * http://support.microsoft.com/default.aspx?scid=KB;EN-US;Q270139
 *
 * @category    PHPProject
 * @package        PHPProject
 * @copyright    Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class MSProjectExchange
{
    /**
     * PHPProject object
     *
     * @var PHPProject
     */
    private $_phpProject;
    
    /**
     * Create a new PHPProject_Reader_MSProjectExchange
     *
     * @param    PHPProject    $phpProject    PHPProject object
     */
    public function __construct()
    {
        $this->_phpProject    = new PhpProject();
    }
    
    /**
     * 
     *
     * @param string $pFilename
     * @return PHPProject
     */
    public function load($pFilename = null)
    {
    
        return $this->_phpProject;
    }
}
