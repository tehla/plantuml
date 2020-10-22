<?php

namespace Tehla\PumlBundle\Asset\Common;

use Tehla\PumlBundle\Asset\{BuildInterface,WrapperInterface,ConstructTrait,Renderer};

class Line implements BuildInterface
{
	/**
	 * @var string
	 */
	private $desc = '';

	public function __construct(string $desc = '')
    {
        $this->desc = $desc;
    }

    /**
     * @inheritDoc
     */
    public function build(Renderer $renderer)
    {
        $renderer->lines->add($this->desc);
    }

	public function getName(): string
	{
		return $this->desc;
	}

	public function getDesc(): string
	{
		return $this->desc;
	}
}
