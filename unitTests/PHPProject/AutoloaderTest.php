<?php


class AutoloaderTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        if (!defined('PHPPROJECT_ROOT'))
        {
            define('PHPPROJECT_ROOT', APPLICATION_PATH . '/');
        }
        require_once(PHPPROJECT_ROOT . 'PHPProject/Autoloader.php');
    }

    public function testAutoloaderNonPHPProjectClass()
    {
        $className = 'InvalidClass';

        $result = PHPProject_Autoloader::Load($className);
        //    Must return a boolean...
        $this->assertTrue(is_bool($result));
        //    ... indicating failure
        $this->assertFalse($result);
    }

    public function testAutoloaderInvalidPHPProjectClass()
    {
        $className = 'PHPProject_Invalid_Class';

        $result = PHPProject_Autoloader::Load($className);
        //    Must return a boolean...
        $this->assertTrue(is_bool($result));
        //    ... indicating failure
        $this->assertFalse($result);
    }

    public function testAutoloadValidPHPProjectClass()
    {
        $className = 'PHPProject_IOFactory';

        $result = PHPProject_Autoloader::Load($className);
        //    Check that class has been loaded
        $this->assertTrue(class_exists($className));
    }

    public function testAutoloadInstantiateSuccess()
    {
        $result = new PHPProject_Task(1,2,3);
        //    Must return an object...
        $this->assertTrue(is_object($result));
        //    ... of the correct type
        $this->assertTrue(is_a($result,'PHPProject_Task'));
    }

}