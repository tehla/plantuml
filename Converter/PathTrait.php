<?php

namespace Tehla\PumlBundle\Converter;

use Manymore\ExtensionBundle\DependencyInjection\ConverterCompilerPass;

/**
 * Trait PathTrait
 * @see ConverterCompilerPass
 */
trait PathTrait
{
    /** @var string */
    protected $path;

    public function setPath(string $path)
    {
        $this->path = $path;
    }
}
