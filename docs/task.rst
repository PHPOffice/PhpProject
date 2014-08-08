.. _task:

Task
======

A task is an activity that needs to be accomplished.

- ``name``
- ``duration`` in days
- ``progress`` in percent
- ``date start``
- ``date end``

Example:

.. code-block:: php
	$oTask = $oPHPProject->createTask()
		->setName('TaskName')
		->setDuration(7)
		->setProgress(0.2)
		->setDateStart('2014-01-01');

Allocation
-------
For each task, a resource can be assigned.

.. code-block:: php
   $oTask->addResource($oResource);