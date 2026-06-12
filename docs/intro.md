# Introduction

PhpProject is a library written in pure PHP that provides a set of classes to write to different project management file formats, i.e. Microsoft [MSProjectExchange](http://support.microsoft.com/kb/270139) (.mpx) and [GanttProject](http://www.ganttproject.biz/) (.gan).

PhpProject is an open source project licensed under the terms of [LGPL version 3](https://github.com/PHPOffice/PhpProject/blob/develop/COPYING.LESSER). PhpProject is aimed to be a high quality software product by incorporating continuous integration and [unit testing](https://phpoffice.github.io/PhpProject/coverage/). You can learn more about PhpProject by reading this Developers' Documentation and the [API Documentation](https://phpoffice.github.io/PhpProject/docs/).

## Features

- Create an in-memory project management representation
- Set file meta data (author, title, description, etc)
- Add resources from scratch or from existing one
- Add tasks from scratch or from existing one
- Output to different file formats: MSProjectExchange (.mpx), GanttProject (.gan), Gnome Planner (.planner)
- ... and lots of other things!

## File formats

Below are the supported features for each file formats.

### Writers

| Features                  |            | MPX | GAN | Planner |
|---------------------------|------------|-----|-----|---------|
| **Document Properties**   | Standard   |     |     |         |
|                           | Custom     |     |     |         |
| **Document Informations** |            |     |     |         |
| **Project**               | Task       | ✓   | ✓   | ✓       |
|                           | Resource   | ✓   | ✓   | ✓       |
|                           | Allocation | ✓   | ✓   | ✓       |

### Readers

| Features                  |            | MPX | GAN | Planner |
|---------------------------|------------|-----|-----|---------|
| **Document Properties**   | Standard   |     |     |         |
|                           | Custom     |     |     |         |
| **Document Informations** |            | ✓   |     |         |
| **Project**               | Task       | ✓   | ✓   | ✓       |
|                           | Resource   | ✓   | ✓   | ✓       |
|                           | Allocation | ✓   | ✓   | ✓       |

## Contributing

We welcome everyone to contribute to PhpProject. Below are some of the things that you can do to contribute:

- Read [our contributing guide](https://github.com/PHPOffice/PhpProject/blob/master/CONTRIBUTING.md)
- [Fork us](https://github.com/PHPOffice/PhpProject/fork) and [request a pull](https://github.com/PHPOffice/PhpProject/pulls) to the [develop](https://github.com/PHPOffice/PhpProject/tree/develop) branch
- Submit [bug reports or feature requests](https://github.com/PHPOffice/PhpProject/issues) to GitHub
- Follow [@PHPOffice](https://twitter.com/PHPOffice) on Twitter
