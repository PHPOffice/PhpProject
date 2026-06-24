<?php

/**
 * This file is part of PHPProject - A pure PHP library for reading and writing
 * project management files.
 *
 * PHPProject is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPProject/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPProject
 * @copyright   2009-2014 PHPProject contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

declare(strict_types=1);

namespace PhpOffice\PhpProject\Writer;

use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\Task;

/**
 * HTML writer (Gantt chart rendered with frappe-gantt)
 */
class HTML implements WriterInterface
{
    /**
     * PHPProject object
     *
     * @var PhpProject
     */
    protected $phpProject;

    /**
     * Create a new HTML writer
     *
     * @param PhpProject $phpProject
     */
    public function __construct(PhpProject $phpProject)
    {
        $this->phpProject = $phpProject;
    }

    /**
     * @param string $pFilename
     * @throws \Exception
     */
    public function save(string $pFilename): void
    {
        // Tasks (frappe-gantt JS objects)
        $tasks = '';
        foreach ($this->phpProject->getAllTasks() as $task) {
            $tasks .= $this->writeTask($task);
        }

        // Full HTML page : header + tasks + footer
        $content = $this->writeHeader() . $tasks . $this->writeFooter();

        // Writing the HTML page in file
        if (file_exists($pFilename) && !is_writable($pFilename)) {
            throw new \Exception("Could not open file $pFilename for writing.");
        }
        $fileHandle = fopen($pFilename, 'wb+');
        fwrite($fileHandle, $content);
        fclose($fileHandle);
    }

    /**
     * Generate the HTML header : page skeleton, frappe-gantt includes and the
     * opening of the tasks array.
     *
     * @return string
     */
    protected function writeHeader(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PhpProject</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.css">
    <script src="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.umd.js"></script>
</head>
<body>
    <div id="gantt"></div>
    <script>
        let tasks = [

HTML;
    }

    /**
     * Generate the JS object for one task (frappe-gantt format).
     *
     * @param Task $task
     * @return string
     */
    protected function writeTask(Task $task): string
    {
        $data = array(
            'id' => (string) $task->getIndex(),
            'name' => $task->getName(),
        );
        if ($task->getStartDate() !== null) {
            $data['start'] = date('Y-m-d', $task->getStartDate());
        }
        if ($task->getEndDate() !== null) {
            $data['end'] = date('Y-m-d', $task->getEndDate());
        }
        $data['progress'] = (int) (($task->getProgress() ?? 0) * 100);

        $line = '            ' . (string) json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ",\n";

        // Sub-tasks (recursive)
        foreach ($task->getTasks() as $taskChild) {
            $line .= $this->writeTask($taskChild);
        }

        return $line;
    }

    /**
     * Generate the HTML footer : close the tasks array, instantiate the Gantt
     * chart and close the page.
     *
     * @return string
     */
    protected function writeFooter(): string
    {
        return <<<'HTML'
        ];
        let gantt = new Gantt("#gantt", tasks);
    </script>
</body>
</html>
HTML;
    }
}
