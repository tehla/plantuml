<?php

namespace Tehla\PumlBundle\Maker;

use Tehla\PumlBundle\Helper\MakerHelper;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Yaml\Yaml;

class AssetMaker extends AbstractMaker
{
    const COMMANDE_NAME = 'tehla:make:puml_asset';


    /**
     * @inheritDoc
     */
    public static function getCommandName(): string
    {
        return self::COMMANDE_NAME;
    }

    /**
     * @inheritDoc
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command->setDescription("Create builder classes for plantuml");
        $command->addArgument("languages", InputArgument::IS_ARRAY, "ex : archimate, or uml");
    }

    /**
     * @inheritDoc
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
        // TODO: Implement configureDependencies() method.
    }

    /**
     * @inheritDoc
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $languages = $input->getArgument('languages');
        foreach ($languages as $language) {
            $parsed = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/views/' .$language.'/dictionnary.yaml'));
            foreach ($parsed['dictionnary'] as $name => $config) {

                $classNameDetails = $generator->createClassNameDetails(
                    MakerHelper::toCamelCase($name, false),
                    str_replace('Maker', 'Asset', __NAMESPACE__) . '\\' . MakerHelper::toCamelCase($language, false)
                );

                if (isset($config['extends'])) {
                    $config['extends'] = MakerHelper::toCamelCase($config['extends'], false);
                }

                $this->generateFromYaml($io, $generator, $classNameDetails, $config, $language);
            }
        }
    }

    private function generateFromYaml(
        ConsoleStyle $io,
        Generator $generator,
        ClassNameDetails $classNameDetails,
        array $config,
        string $language
    ){
        $templateName = __DIR__ . '/../Resources/views/' .$language . DIRECTORY_SEPARATOR . 'template.twig';
        $targetPath = __DIR__ . '/../Asset/' . ucfirst($language)  . DIRECTORY_SEPARATOR . $classNameDetails->getShortName() . '.php';

        if (file_exists($targetPath)) {
            unlink($targetPath);
        }
        MakerHelper::cleanConfig($config);

        $generator->generateFile($targetPath, $templateName, $config + [
                'namespace' => MakerHelper::getNamespace($classNameDetails),
                'shortname' => $classNameDetails->getShortName()
            ]);
        $generator->writeChanges();
    }
}