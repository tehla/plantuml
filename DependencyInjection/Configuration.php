<?php


namespace Tehla\PumlBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const ROOT = 'manymore_puml';
    const JAR_DEFAULT = __DIR__ . '/../Resources/jar/plantuml.jar';
    const OFFICIAL_PUML_SERVER_URL = 'http://www.plantuml.com/plantuml';

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder  = new TreeBuilder(self::ROOT);
        $treeBuilder->getRootNode()
            ->children()
                ->integerNode('temp_file_ttl')->defaultValue(0)->end()
                ->scalarNode('converter')->defaultValue('jar')->end()
                ->arrayNode('converter_path')->addDefaultsIfNotSet()->children()
                    ->scalarNode('jar')->defaultValue(self::JAR_DEFAULT)->example(self::JAR_DEFAULT)->end()
                    ->scalarNode('http')->defaultValue(self::OFFICIAL_PUML_SERVER_URL)->example(self::OFFICIAL_PUML_SERVER_URL)->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
