.. _general:

General usage
=============

Basic example
-------------

The following is a basic example of the PHPProject library. More examples
are provided in the `samples
folder <https://github.com/PHPOffice/PHPProject/tree/master/samples/>`__.

.. code-block:: php

    require_once 'src/PhpProject/Autoloader.php';
    \PhpOffice\PhpProject\Autoloader::register();

    $objPHPProject = new PhpProject();

    // Create resource
    $objRes1 = $objPHPProject->createResource();
    $objRes1->setTitle('UserBoy');

    // Create a task
    $objTask1 = $objPHPProject->createTask();
    $objTask1->setName('Start of the project');
    $objTask1->setStartDate('02-01-2012');
    $objTask1->setEndDate('03-01-2012');
    $objTask1->setProgress(0.5);
    $objTask1->addResource($objRes1);

    $oWriterGAN = IOFactory::createWriter($objPHPPowerPoint, 'GanttProject');
    $oWriterGAN->save(__DIR__ . "/sample.gan");

Document information
--------------------

You can set the document information such as title, creator, and company
name. Use the following functions:

.. code-block:: php

    $properties = $objPHPProject->getProperties();
    $properties->setCreator('My name');
    $properties->setCompany('My factory');
    $properties->setTitle('My title');
    $properties->setDescription('My description');
    $properties->setCategory('My category');
    $properties->setLastModifiedBy('My name');
    $properties->setCreated(mktime(0, 0, 0, 3, 12, 2014));
    $properties->setModified(mktime(0, 0, 0, 3, 14, 2014));
    $properties->setSubject('My subject');
    $properties->setKeywords('my, key, word');

