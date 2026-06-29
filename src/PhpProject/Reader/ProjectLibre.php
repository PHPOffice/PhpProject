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

namespace PhpOffice\PhpProject\Reader;

use PhpOffice\PhpProject\PhpProject;

/**
 * ProjectLibre reader
 *
 * A ProjectLibre `.pod` file (version 1.5.5+) is made of serialized Java data,
 * a separator, then an MSPDI file. This reader locates the separator and reads
 * the embedded MSPDI part with the MSPDI reader.
 */
class ProjectLibre implements ReaderInterface
{
    /**
     * Separator placed before the embedded MSPDI file inside a `.pod` file
     */
    const MSPDI_SEPARATOR = '@@@@@@@@@@ProjectLibreSeparator_MSXML@@@@@@@@@@';

    /**
     * @param string $pFilename
     * @return bool
     */
    public function canRead(string $pFilename): bool
    {
        if (!file_exists($pFilename) || !is_readable($pFilename)) {
            return false;
        }
        $content = (string) file_get_contents($pFilename);

        return strpos($content, self::MSPDI_SEPARATOR) !== false;
    }

    /**
     * @param string $pFilename
     * @throws \Exception
     * @return PhpProject
     */
    public function load(string $pFilename): PhpProject
    {
        if (!file_exists($pFilename) || !is_readable($pFilename)) {
            throw new \Exception('The file is not accessible.');
        }

        // Keep only the MSPDI part, located after the separator.
        $content = (string) file_get_contents($pFilename);
        $position = strpos($content, self::MSPDI_SEPARATOR);
        if ($position === false) {
            throw new \Exception('The file is not a valid ProjectLibre file.');
        }
        $mspdi = substr($content, $position + strlen(self::MSPDI_SEPARATOR));

        // The MSPDI reader expects a file, so we write the MSPDI part to a
        // temporary file before delegating to it.
        $tempFile = (string) tempnam(sys_get_temp_dir(), 'PHPPROJECT');
        file_put_contents($tempFile, $mspdi);

        $phpProject = (new MSPDI())->load($tempFile);

        unlink($tempFile);

        return $phpProject;
    }
}
