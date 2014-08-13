.. _intro:

Introduction
============

PHPProject is a library written in pure PHP that provides a set of 
classes to write to different project management file formats, i.e. Microsoft 
`MSProjectExchange <http://support.microsoft.com/kb/270139>` 
(.mpx) and `GanttProject <http://www.ganttproject.biz/>`__ (.gan). 

PHPProject is an open source project licensed under the terms of `LGPL
version 3 <https://github.com/PHPOffice/PHPProject/blob/develop/COPYING.LESSER>`__.
PHPProject is aimed to be a high quality software product by incorporating
`continuous integration <https://travis-ci.org/PHPOffice/PHPProject>`__ and
`unit testing <http://phpoffice.github.io/PHPProject/coverage/develop/>`__.
You can learn more about PHPProject by reading this Developers'
Documentation and the `API Documentation <http://phpoffice.github.io/PHPProject/docs/develop/>`__.

Features
--------

- Create an in-memory project management representation
- Set file meta data (author, title, description, etc)
- Add resources from scratch or from existing one
- Add tasks from scratch or from existing one
- Output to different file formats: MSProjectExchange (.mpx), GanttProject (.gan)
- ... and lots of other things!

File formats
------------

Below are the supported features for each file formats.

Writers
~~~~~~~

+---------------------------+----------------------+--------+-------+
| Features                  |                      | MPX    | GAN   |
+===========================+======================+========+=======+
| **Document Properties**   | Standard             |        |       |
+---------------------------+----------------------+--------+-------+
|                           | Custom               |        |       |
+---------------------------+----------------------+--------+-------+
| **Document Informations** |                      |        |       |
+---------------------------+----------------------+--------+-------+
| **Project**               | Task                 | ✓      | ✓     |
+---------------------------+----------------------+--------+-------+
|                           | Resource             | ✓      | ✓     |
+---------------------------+----------------------+--------+-------+
|                           | Allocation           | ✓      | ✓     |
+---------------------------+----------------------+--------+-------+

Readers
~~~~~~~
+---------------------------+----------------------+--------+-------+
| Features                  |                      | MPX    | GAN   |
+===========================+======================+========+=======+
| **Document Properties**   | Standard             |        |       |
+---------------------------+----------------------+--------+-------+
|                           | Custom               |        |       |
+---------------------------+----------------------+--------+-------+
| **Document Informations** |                      | ✓      |       |
+---------------------------+----------------------+--------+-------+
| **Project**               | Task                 | ✓      | ✓     |
+---------------------------+----------------------+--------+-------+
|                           | Resource             | ✓      | ✓     |
+---------------------------+----------------------+--------+-------+
|                           | Allocation           | ✓      | ✓     |
+---------------------------+----------------------+--------+-------+

Contributing
------------

We welcome everyone to contribute to PHPProject. Below are some of the
things that you can do to contribute:

-  Read `our contributing
   guide <https://github.com/PHPOffice/PHPProject/blob/master/CONTRIBUTING.md>`__
-  `Fork us <https://github.com/PHPOffice/PHPProject/fork>`__ and `request
   a pull <https://github.com/PHPOffice/PHPProject/pulls>`__ to the
   `develop <https://github.com/PHPOffice/PHPProject/tree/develop>`__
   branch
-  Submit `bug reports or feature
   requests <https://github.com/PHPOffice/PHPProject/issues>`__ to GitHub
-  Follow `@PHPOffice <https://twitter.com/PHPOffice>`__ on Twitter
