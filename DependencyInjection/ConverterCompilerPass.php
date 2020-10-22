<?php

namespace Tehla\PumlBundle\DependencyInjection;

use Tehla\PumlBundle\Converter\FileAndForgetDecorator;
use Tehla\PumlBundle\Converter\HttpConverter;
use Tehla\PumlBundle\Converter\JarConverter;
use Tehla\PumlBundle\Converter\MarkdownToPngInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ConverterCompilerPass implements CompilerPassInterface
{
    const OFFICIAL_PUML_SERVER_URL_EXCEPTION = "
    Le serveur %s ne peut pas être utilisé en dehors d'un environnement de développement.
Veuillez renseigner le paramètre puml_config.converter_path.http avec une une URL de serveur HTTP dédié pour l'environnement de %s";

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('puml_config');

        if ($config['converter'] === 'jar') {
            $container->findDefinition(JarConverter::class)
                ->addMethodCall('setPath', [$config['converter_path']['jar']]);
            $container->setAlias(MarkdownToPngInterface::class, JarConverter::class);
        }

        if ($config['converter'] === 'http' && isset($config['converter_path']['http'])) {
            if ($container->getParameter('kernel.environment') !== 'dev'
                && $config['converter_path']['http'] === Configuration::OFFICIAL_PUML_SERVER_URL) {
                throw new InvalidArgumentException(sprintf(
                    self::OFFICIAL_PUML_SERVER_URL_EXCEPTION,
                    $config['converter_path']['http'],
                    $container->getParameter('kernel.environment')
                ));
            }

            $container->findDefinition(HttpConverter::class)
                ->addMethodCall('setPath', [$config['converter_path']['http']]);
            $container->setAlias(MarkdownToPngInterface::class, HttpConverter::class);
        }
    }
}
