<?php

namespace Tehla\PumlBundle\Converter;

use Tehla\PumlBundle\Exception\ConvertException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Class JarConverter
 * @property $path /path/to/plantuml.jar
 */
class JarConverter implements MarkdownToPngInterface, LoggerAwareInterface
{
    use PathTrait, LoggerAwareTrait;

    const PATTERN = "java -jar %s %s -o %s -verbose ";

    /** @var Filesystem */
    private $filesystem;

    /**
     * JarConverter constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

	/**
	 * @param string $markdown
	 * @return \SplFileInfo
	 * @throws ConvertException
	 */
    public function convert(string $markdown): \SplFileInfo
    {
    	$inputFile = $this->renderInputFile($markdown);
        $outputFile = $this->renderOutputFile($inputFile);
        $process = Process::fromShellCommandline(
            $cmd = sprintf(self::PATTERN, $this->path, $inputFile->getRealPath(), $outputFile->getPath())
        );

        $buffered = [];
        $process->run(function($type, $buffer) use (&$buffered) {
            $buffered[] = $buffer;
        });
        $this->logger->debug('planuml.jar', [
            'md' => $inputFile->getRealPath(),
            'png' => $outputFile->getRealPath(),
            'buffered' => $buffered
        ]);

        if (!file_exists($outputFile->getRealPath())) {
            throw new ConvertException(sprintf("Expected file not found from %s to %s",
					$inputFile->getRealPath(), $outputFile->getRealPath())
            );
        }

        return $outputFile;
    }

	/**
	 * @see TempFileListener::onKernelTerminate()
	 *
	 * @param string $mdText
	 * @return \SplFileInfo
	 */
	private function renderInputFile(string $mdText): \SplFileInfo
	{
		$path = $this->filesystem->tempnam(sys_get_temp_dir(), 'puml_', 'md');
		file_put_contents($path, $mdText);

		return new \SplFileInfo($path);
	}

    private function renderOutputFile(\SplFileInfo $inputFile)
    {
        $tempPath = $inputFile->getPath()
            . DIRECTORY_SEPARATOR
            . $inputFile->getBasename($inputFile->getExtension()) . 'png';

        return new \SplFileInfo($tempPath);
    }
}
