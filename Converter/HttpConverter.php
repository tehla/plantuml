<?php


namespace Tehla\PumlBundle\Converter;

use Tehla\PumlBundle\Exception\ConvertException;
use Tehla\PumlBundle\Helper\EncodepHelper;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class HttpConverter
 * @property $path http://www.plantuml.com/plantuml
 */
class HttpConverter implements MarkdownToPngInterface
{
    use PathTrait;

    /** @var HttpClientInterface */
    private $httpClient;

    /** @var Filesystem */
    private $filesystem;

    /**
     * HttpConverter constructor.
     * @param HttpClientInterface $httpClient
     * @param Filesystem $filesystem
     */
    public function __construct(HttpClientInterface $httpClient, Filesystem $filesystem)
    {
        $this->httpClient = $httpClient;
        $this->filesystem = $filesystem;
    }


	/**
	 * @param string $markdown
	 * @return \SplFileInfo
	 * @throws ClientExceptionInterface
	 * @throws ConvertException
	 * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
	 * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
	 * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
	 * @throws \Exception
	 */
    public function convert(string $markdown): \SplFileInfo
    {
        $encoded = EncodepHelper::encode($markdown);
        try {
            $url = sprintf("%s/png/%s", $this->path, $encoded);
            $response = $this->httpClient->request('GET', $url);

            return $this->generateFile($response->getContent())->current();

        } catch (ClientExceptionInterface $e) {
            if ($e->getCode() === 400) {//HTTP Bad request
                throw new ConvertException($encoded, 0, $e);
            }
            throw $e;
        }
    }

    /**
     * @param $content
     * @return \Generator | \SplFileInfo[]
     */
    private function generateFile($content): \Generator
    {
        $tempPath = $this->filesystem->tempnam(sys_get_temp_dir(), 'puml_png');
        $this->filesystem->dumpFile($tempPath, $content);
        return new \SplFileInfo($tempPath);
    }
}
