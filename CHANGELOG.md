# Changelog

## 0.3.0 - Not released
### Bug Fixes
- Fixed `Task::setProgress()` with non-numeric values on PHP 8+ - @slayerfx

### Miscellaneous
- Deleted Travis files - @slayerfx
- Migrated from Travis to GitHub Actions - @slayerfx
- Dropped support for PHP 5.x/7.x, minimum PHP version is now 7.3 - @slayerfx
- Migrated tests to PHPUnit 9 - @slayerfx
- Updated `phpunit.xml.dist` for PHPUnit 9 - @slayerfx
- Updated dependencies: PHPUnit ^9.0, PHP_CodeSniffer ^3.0, PHPMD ^2.15, phpDocumentor ^3.9.1 - @slayerfx
- Removed abandoned dependencies: phpcpd, phploc - @slayerfx
- Removed deprecated PSR-0 autoloading - @slayerfx
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
