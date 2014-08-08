# PHPProject

[![Latest Stable Version](https://poser.pugx.org/phpoffice/phpproject/v/stable.png)](https://packagist.org/packages/phpoffice/phpproject)
[![Build Status](https://travis-ci.org/PHPOffice/PHPProject.svg?branch=master)](https://travis-ci.org/PHPOffice/PHPProject)
[![Code Quality](https://scrutinizer-ci.com/g/PHPOffice/PHPProject/badges/quality-score.png?s=b5997ce59ac2816b4514f3a38de9900f6d492c1d)](https://scrutinizer-ci.com/g/PHPOffice/PHPProject/)
[![Code Coverage](https://scrutinizer-ci.com/g/PHPOffice/PHPProject/badges/coverage.png?s=742a98745725c562955440edc8d2c39d7ff5ae25)](https://scrutinizer-ci.com/g/PHPOffice/PHPProject/)
[![Total Downloads](https://poser.pugx.org/phpoffice/phpproject/downloads.png)](https://packagist.org/packages/phpoffice/phpproject)
[![License](https://poser.pugx.org/phpoffice/phpproject/license.png)](https://packagist.org/packages/phpoffice/phpproject)


PHPProject is a library written in pure PHP that provides a set of classes to write to different project management file formats, i.e. Microsoft [MSProjectExchange](http://support.microsoft.com/kb/270139) (MPX) or [GanttProject](http://www.ganttproject.biz) (GAN). 
PHPProject is an open source project licensed under the terms of [LGPL version 3](https://github.com/PHPOffice/PHPProject/blob/develop/COPYING.LESSER). PHPProject is aimed to be a high quality software product by incorporating [continuous integration](https://travis-ci.org/PHPOffice/PHPProject) and [unit testing](http://phpoffice.github.io/PHPProject/coverage/develop/). You can learn more about PHPProject by reading the [Developers' Documentation](http://phpproject.readthedocs.org/) and the [API Documentation](http://phpoffice.github.io/PHPProject/docs/develop/).

Read more about PHPProject:

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Getting started](#getting-started)
- [Known issues](#known-issues)
- [Contributing](#contributing)
- [Developers' Documentation](http://phpproject.readthedocs.org/)
- [API Documentation](http://phpoffice.github.io/PHPProject/docs/master/)

### Features

- Create an in-memory project management representation
- Set file meta data (author, title, description, etc)
- Add resources from scratch or from existing one
- Add tasks from scratch or from existing one
- Output to different file formats: MSProjectExchange (.mpx), GanttProject (.gan)
- ... and lots of other things!

### Requirements

PHPProject requires the following:

- PHP 5.3+
- [XML Parser extension](http://www.php.net/manual/en/xml.installation.php)

### Installation

It is recommended that you install the PHPProject library [through composer](http://getcomposer.org/). To do so, add
the following lines to your ``composer.json``.

```json
{
    "require": {
       "phpoffice/phpproject": "dev-master"
    }
}
```

Alternatively, you can download the latest release from the [releases page](https://github.com/PHPOffice/PHPProject/releases).
In this case, you will have to register the autoloader. Register autoloading is required only if you do not use composer in your project.

```php
require_once 'path/to/PhpProject/src/PhpProject/Autoloader.php';
\PhpOffice\PhpProject\Autoloader::register();
```

## Getting started

The following is a basic usage example of the PHPProject library.

```php
require_once 'src/PhpProject/Autoloader.php';
\PhpOffice\PhpProject\Autoloader::register();

$objPHPProject = new PhpProject();$objPHPProject = new PhpProject();

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
```

More examples are provided in the [samples folder](samples/). You can also read the [Developers' Documentation](http://phpproject.readthedocs.org/) and the [API Documentation](http://phpoffice.github.io/PHPProject/docs/master/) for more details.


## Contributing

We welcome everyone to contribute to PHPProject. Below are some of the things that you can do to contribute:

- Read [our contributing guide](https://github.com/PHPOffice/PHPProject/blob/master/CONTRIBUTING.md)
- [Fork us](https://github.com/PHPOffice/PHPProject/fork) and [request a pull](https://github.com/PHPOffice/PHPProject/pulls) to the [develop](https://github.com/PHPOffice/PHPProject/tree/develop) branch
- Submit [bug reports or feature requests](https://github.com/PHPOffice/PHPProject/issues) to GitHub
- Follow [@PHPOffice](https://twitter.com/PHPOffice) on Twitter
