<?php

namespace Tehla\PumlBundle\Converter;

interface MarkdownToPngInterface
{
    public function convert(string $markdown): \SplFileInfo;
}
