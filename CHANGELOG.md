# Changelog

## 0.3.0 - Not released
### Bug Fixes
- Fixed `Task::setProgress()` with non-numeric values on PHP 8+ - @slayerfx GH-25
- Fixed invalid SPDX license identifier in `composer.json` - @slayerfx GH-26
- Removed unnecessary `version` field from `composer.json` - @slayerfx GH-26
- Added code coverage configuration in `phpunit.xml.dist` - @slayerfx GH-27
- Fixed `number_format()` null parameter deprecation in `MsProjectMPX` on PHP 8.1+ - @slayerfx GH-28
- Fixed `PhpProject` class casing in samples (was working on Windows only, broken on Linux) - @slayerfx GH-29
- Fixed inaccurate `@return string` PHPDoc on `DocumentProperties::getCustomPropertyValue/Type()` (now `string|null`) - @slayerfx GH-31
- Fixed PHP 8.4 implicit nullable parameter deprecations (now using `?Type $param = null`) - @slayerfx GH-31
- Fixed `PhpProject::setInformations()` PHPDoc parameter type (was `PHPProject_DocumentProperties`, now `DocumentInformations`) - @slayerfx GH-32
- Fixed `Task::setStartDate()/setEndDate()` PHPDoc return type (was `DocumentInformations`, now `self`) - @slayerfx GH-32
- Fixed string/int operation in `Writer/GanttProject` and `Writer/MsProjectMPX::sanitizeTask` (explicit `(int)` cast on duration) - @slayerfx GH-32
- Added explicit `return null;` in `DocumentProperties::getCustomPropertyValue/Type()` - @slayerfx GH-32

### Miscellaneous
- Bumped phpstan analysis level from 1 to 2 - @slayerfx GH-32
- Created `Reader/ReaderInterface` and `Writer/WriterInterface`, implemented in concrete Reader/Writer classes - @slayerfx GH-32
- Updated obsolete PHPDoc class references (`PHPProject_*` → `self` or correct class name) - @slayerfx GH-32
- Replaced invalid PHPDoc types (`datetime` → `int`, `index` → `int`, `multitype` → `array`, `Exception` → `\Exception`) - @slayerfx GH-32
- Removed phantom `@param XMLReader $oXML` PHPDoc tags in `Reader/GanttProject` - @slayerfx GH-32
- Added phpstan job to CI (level 1) - @slayerfx GH-31
- Replaced Scrutinizer code coverage badge with Coveralls in README - @slayerfx GH-30
- Removed Scrutinizer Code Quality badge from README - @slayerfx GH-30
- Added CI job to check samples execution - @slayerfx GH-29
- Added PHP 7.4, 8.0, 8.1, 8.2, 8.3, 8.4 and 8.5 to CI matrix - @slayerfx GH-28
- Deleted Travis files - @slayerfx GH-25
- Migrated from Travis to GitHub Actions - @slayerfx GH-25
- Dropped support for PHP 5.x/7.x, minimum PHP version is now 7.3 - @slayerfx GH-25
- Migrated tests to PHPUnit 9 - @slayerfx GH-25
- Updated `phpunit.xml.dist` for PHPUnit 9 - @slayerfx GH-25
- Updated dependencies: PHPUnit ^9.0, PHP_CodeSniffer ^3.0, PHPMD ^2.15 - @slayerfx GH-25
- Removed abandoned dependencies: phpcpd, phploc - @slayerfx GH-25
- Removed deprecated PSR-0 autoloading - @slayerfx GH-25
- Refactored Task & Resource Index - @Progi1984 GH-16

## 0.2.0 - 2014-08-13
### Features
- MSProjectExchange Reader - @Progi1984 GH-4
- MSProjectExchange Writer - @Progi1984 GH-2

### Miscellaneous
- Refactored resources management - @Progi1984

## 0.1.0 - 2014-08-08

### Features
- Support of Composer - @Progi1984 GH-7 GH-9
- Support of namespaces - @Progi1984 GH-12
- GanttProject Writer - @Progi1984 GH-1
- GanttProject Reader - @Progi1984 GH-3

### Miscellaneous
- QA : Documentation - @Progi1984 GH-8 GH-12
- QA : Unit Tests - @Progi1984 GH-12
