# Installing/configuring

## Requirements

Mandatory:

- PHP 5.3+
- PHP [XML Parser](http://www.php.net/manual/en/xml.installation.php) extension

Optional PHP extensions:

- [XMLWriter](http://php.net/manual/en/book.xmlwriter.php)

## Installation

There are two ways to install PhpProject, i.e. via [Composer](http://getcomposer.org/) or manually by downloading the library.

### Using Composer

To install via Composer, add the following lines to your `composer.json`:

``` json
{
    "require": {
       "phpoffice/phpproject": "dev-master"
    }
}
```

### Manual install

To install manually, [download PhpProject package from github](https://github.com/PHPOffice/PhpProject/archive/master.zip). Extract the package and put the contents to your machine. To use the library, include `src/PhpProject/Autoloader.php` in your script and invoke `Autoloader::register`.

``` php
require_once '/path/to/src/PhpProject/Autoloader.php';
\PhpOffice\PhpProject\Autoloader::register();
```

## Using samples

After installation, you can browse and use the samples that we've provided, either by command line or using browser. If you can access your PhpProject library folder using browser, point your browser to the `samples` folder, e.g. `http://localhost/PhpProject/samples/`.
