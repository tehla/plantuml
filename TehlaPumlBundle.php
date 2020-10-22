<?php

namespace Tehla\PumlBundle;

use Tehla\PumlBundle\DependencyInjection\ConverterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TehlaPumlBundle extends \Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ConverterCompilerPass());
    }
}
