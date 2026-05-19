<?php

namespace PhpOffice\PhpProject\Writer;

interface WriterInterface
{
    /**
     * Save PHPProject to file
     *
     * @param  string $pFilename
     * @return void
     */
    public function save($pFilename);
}