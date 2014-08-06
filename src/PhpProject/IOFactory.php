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
 * IOFactory
 */
class IOFactory
{
    /**
     * Autoresolve classes
     *
     * @var array
     */
    private static $autoResolveClasses = array('GanttProject');

    /**
     * Create writer
     *
     * @param PhpProject $phpProject
     * @param string $name
     * @return \PhpOffice\PhpProject\Writer\WriterInterface
     */
    public static function createWriter(PhpProject $phpProject, $name = 'GanttProject')
    {
        $class = 'PhpOffice\\PhpProject\\Writer\\' . $name;
        return self::loadClass($class, $name, 'writer', $phpProject);
    }

    /**
     * Create reader
     *
     * @param  string $name
     * @return \PhpOffice\PhpProject\Reader\ReaderInterface
     */
    public static function createReader($name = 'GanttProject')
    {
        $class = 'PhpOffice\\PhpProject\\Reader\\' . $name;
        return self::loadClass($class, $name, 'reader');
    }

    /**
     * Loads PHPProject from file using automatic \PhpOffice\PhpProject\Reader\ReaderInterface resolution
     *
     * @param  string        $pFilename
     * @return PhpProject
     * @throws \Exception
     */
    public static function load($pFilename)
    {
        // Try loading using self::$autoResolveClasses
        foreach (self::$autoResolveClasses as $autoResolveClass) {
            $reader = self::createReader($autoResolveClass);
            if ($reader->canRead($pFilename)) {
                return $reader->load($pFilename);
            }
        }

        throw new \Exception("Could not automatically determine \PhpOffice\PhpProject\Reader\ReaderInterface for file.");
    }

    /**
     * Load class
     *
     * @param string $class
     * @param string $name
     * @param string $type
     * @param \PhpOffice\PhpProject\PhpProject $phpProject
     * @throws \Exception
     * @return
     */
    private static function loadClass($class, $name, $type, PhpProject $phpProject = null)
    {
        if (class_exists($class) && self::isConcreteClass($class)) {
            if (is_null($phpProject)) {
                return new $class();
            } else {
                return new $class($phpProject);
            }
        } else {
            throw new \Exception('"'.$name.'" is not a valid '.$type.'.');
        }
    }

    /**
     * Is it a concrete class?
     *
     * @param string $class
     * @return bool
     */
    private static function isConcreteClass($class)
    {
        $reflection = new \ReflectionClass($class);

        return !$reflection->isAbstract() && !$reflection->isInterface();
    }
}
