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
 * @copyright   2009-2014 PHPProject contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

declare(strict_types=1);

namespace PhpOffice\PhpProject\Writer;

use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\Reader\ProjectLibre as ProjectLibreReader;

/**
 * ProjectLibre writer
 *
 * A ProjectLibre `.pod` file is made of serialized Java data, a separator, then
 * an MSPDI file. This writer outputs a minimal `.pod`: the Java stream signature,
 * the separator, then an MSPDI file produced by the MSPDI writer. The file can be
 * read back by the ProjectLibre reader.
 */
class ProjectLibre implements WriterInterface
{
    /**
     * Java serialization stream signature placed at the beginning of a `.pod` file
     */
    const JAVA_PREAMBLE = "\xAC\xED\x00\x05";

    /**
     * PHPProject object
     *
     * @var PhpProject
     */
    protected $phpProject;

    /**
     * Create a new ProjectLibre writer
     *
     * @param PhpProject $phpProject
     */
    public function __construct(PhpProject $phpProject)
    {
        $this->phpProject = $phpProject;
    }

    /**
     * @param string $pFilename
     * @throws \Exception
     */
    public function save(string $pFilename): void
    {
        if (file_exists($pFilename) && !is_writable($pFilename)) {
            throw new \Exception("Could not open file $pFilename for writing.");
        }

        // The MSPDI writer writes to a file, so we let it produce the MSPDI part
        // in a temporary file before reading it back.
        $tempFile = (string) tempnam(sys_get_temp_dir(), 'PHPPROJECT');
        (new MSPDI($this->phpProject))->save($tempFile);
        $mspdi = (string) file_get_contents($tempFile);
        unlink($tempFile);

        // Assemble the minimal .pod: preamble + separator + MSPDI.
        $content = self::JAVA_PREAMBLE.ProjectLibreReader::MSPDI_SEPARATOR.$mspdi;

        $fileHandle = fopen($pFilename, 'wb+');
        fwrite($fileHandle, $content);
        fclose($fileHandle);
    }
}
