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
 * Autoloader
 */
class Autoloader
{
    /** @const string */
    const NAMESPACE_PREFIX = 'PhpOffice\\PhpProject\\';

    /**
     * Register
     *
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * Autoload
     *
     * @param string $class
     */
    public static function autoload($class)
    {
        $prefixLength = strlen(self::NAMESPACE_PREFIX);
        if (0 === strncmp(self::NAMESPACE_PREFIX, $class, $prefixLength)) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, $prefixLength));
            $file = realpath(__DIR__ . (empty($file) ? '' : DIRECTORY_SEPARATOR) . $file . '.php');
            // @codeCoverageIgnoreStart
            if (file_exists($file)) {
                require_once $file;
            }
            // @codeCoverageIgnoreEnd
        }
    }
}
