<?php

declare(strict_types=1);

namespace PhpOffice\PhpProject\Writer;

interface WriterInterface
{
    /**
     * Save PHPProject to file
     *
     * @param  string $pFilename
     * @return void
     */
    public function save(string $pFilename): void;
}