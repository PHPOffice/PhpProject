<?php
/**
 * PHPProject
 *
 * Copyright (c) 2012 - 2012 PHPProject
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPProject
 * @package    PHPProject
 * @copyright  Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */


/**	PHPProject root directory */
if (!defined('PHPPROJECT_ROOT')) {
	/**
	 * @ignore
	 */
	define('PHPPROJECT_ROOT', dirname(__FILE__) . '/../');
	require(PHPPROJECT_ROOT . 'PHPProject/Autoloader.php');
}

/**
 * PHPProject_IOFactory
 *
 * @category   PHPProject
 * @package    PHPProject
 * @copyright  Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class PHPProject_IOFactory
{
	/**
	 * Search locations
	 *
	 * @var	array
	 * @access	private
	 * @static
	 */
	private static $_searchLocations = array(
		array( 'type' => 'IWriter', 'path' => 'PHPProject/Writer/{0}.php', 'class' => 'PHPProject_Writer_{0}' ),
		array( 'type' => 'IReader', 'path' => 'PHPProject/Reader/{0}.php', 'class' => 'PHPProject_Reader_{0}' )
	);

	/**
	 * Autoresolve classes
	 *
	 * @var	array
	 * @access	private
	 * @static
	 */
	private static $_autoResolveClasses = array(
		'GanttProject',
		'MSProjectExchange'
	);

    /**
     *	Private constructor for PHPProject_IOFactory
     */
    private function __construct() { }

    /**
     * Get search locations
     *
	 * @static
	 * @access	public
     * @return	array
     */
	public static function getSearchLocations() {
		return self::$_searchLocations;
	}

	/**
	 * Set search locations
	 *
	 * @static
	 * @access	public
	 * @param	array $value
	 * @throws	Exception
	 */
	public static function setSearchLocations($value) {
		if (is_array($value)) {
			self::$_searchLocations = $value;
		} else {
			throw new Exception('Invalid parameter passed.');
		}
	}

	/**
	 * Add search location
	 *
	 * @static
	 * @access	public
	 * @param	string $type		Example: IWriter
	 * @param	string $location	Example: PHPProject/Writer/{0}.php
	 * @param	string $classname 	Example: PHPProject_Writer_{0}
	 */
	public static function addSearchLocation($type = '', $location = '', $classname = '') {
		self::$_searchLocations[] = array( 'type' => $type, 'path' => $location, 'class' => $classname );
	}

	/**
	 * Create PHPProject_Writer_IWriter
	 *
	 * @static
	 * @access	public
	 * @param	PHPProject $phpProject
	 * @param	string  $writerType	Example: Excel2007
	 * @return	PHPProject_Writer_IWriter
	 * @throws	Exception
	 */
	public static function createWriter(PHPProject $phpProject, $writerType = '') {
		// Search type
		$searchType = 'IWriter';

		// Include class
		foreach (self::$_searchLocations as $searchLocation) {
			if ($searchLocation['type'] == $searchType) {
				$className = str_replace('{0}', $writerType, $searchLocation['class']);

				$instance = new $className($phpProject);
				if ($instance !== NULL) {
					return $instance;
				}
			}
		}

		// Nothing found...
		throw new Exception("No $searchType found for type $writerType");
	}

	/**
	 * Create PHPProject_Reader_IReader
	 *
	 * @static
	 * @access	public
	 * @param	string $readerType	Example: GanttProject
	 * @return	PHPProject_Reader_IReader
	 * @throws	Exception
	 */
	public static function createReader($readerType = '') {
		// Search type
		$searchType = 'IReader';

		// Include class
		foreach (self::$_searchLocations as $searchLocation) {
			if ($searchLocation['type'] == $searchType) {
				$className = str_replace('{0}', $readerType, $searchLocation['class']);

				$instance = new $className();
				if ($instance !== NULL) {
					return $instance;
				}
			}
		}

		// Nothing found...
		throw new Exception("No $searchType found for type $readerType");
	}	//	function createReader()

	/**
	 * Loads PHPProject from file using automatic PHPProject_Reader_IReader resolution
	 *
	 * @static
	 * @access public
	 * @param 	string 		$pFileName		The name of the spreadsheet file
	 * @return	PHPProject
	 * @throws	Exception
	 */
	public static function load($pFilename) {
		$reader = self::createReaderForFile($pFilename);
		return $reader->load($pFilename);
	}	//	function load()

	/**
	 * Identify file type using automatic PHPProject_Reader_IReader resolution
	 *
	 * @static
	 * @access public
	 * @param 	string 		$pFileName		The name of the spreadsheet file to identify
	 * @return	string
	 * @throws	Exception
	 */
	public static function identify($pFilename) {
		$reader = self::createReaderForFile($pFilename);
		$className = get_class($reader);
		$classType = explode('_',$className);
		unset($reader);
		return array_pop($classType);
	}	//	function identify()

	/**
	 * Create PHPProject_Reader_IReader for file using automatic PHPProject_Reader_IReader resolution
	 *
	 * @static
	 * @access	public
	 * @param 	string 		$pFileName		The name of the spreadsheet file
	 * @return	PHPProject_Reader_IReader
	 * @throws	Exception
	 */
	public static function createReaderForFile($pFilename) {

		// First, lucky guess by inspecting file extension
		$pathinfo = pathinfo($pFilename);

		if (isset($pathinfo['extension'])) {
			switch (strtolower($pathinfo['extension'])) {
				case 'gan':			//	GanttProject
					$extensionType = 'GanttProject';
					break;
				case 'mpx':			//	MSProjectExchange
					$extensionType = 'MSProjectExchange';
					break;
				default:
					break;
			}

			$reader = self::createReader($extensionType);
			// Let's see if we are lucky
			if (isset($reader) && $reader->canRead($pFilename)) {
				return $reader;
			}

		}

		// If we reach here then "lucky guess" didn't give any result
		// Try walking through all the options in self::$_autoResolveClasses
		foreach (self::$_autoResolveClasses as $autoResolveClass) {
			//	Ignore our original guess, we know that won't work
		    if ($reader !== $extensionType) {
				$reader = self::createReader($autoResolveClass);
				if ($reader->canRead($pFilename)) {
					return $reader;
				}
			}
		}

    	throw new Exception('Unable to identify a reader for this file');
	}	//	function createReaderForFile()
}
