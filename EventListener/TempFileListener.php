<?php

namespace Tehla\PumlBundle\EventListener;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

class TempFileListener
{
	/** @var Filesystem */
	private $filesystem;

	/**
	 * TempFileListener constructor.
	 * @param Filesystem $filesystem
	 */
	public function __construct(Filesystem $filesystem)
	{
		$this->filesystem = $filesystem;
	}

	public function onKernelTerminate(TerminateEvent $event)
	{
		$response = $event->getResponse();
		if ($response instanceof BinaryFileResponse) {
			$file = $response->getFile();
			array_map(function ($listedFile) {
				$this->filesystem->remove($listedFile);
			}, glob($file->getPath()
				. DIRECTORY_SEPARATOR
				. $file->getBasename($file->getExtension())
				.'*'
			));
		}
	}
}
