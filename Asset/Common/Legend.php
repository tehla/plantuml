<?php

namespace Tehla\PumlBundle\Asset\Common;

use Tehla\PumlBundle\Asset\{BuildInterface,WrapperInterface,ConstructTrait,Renderer};

class Legend implements BuildInterface, WrapperInterface
{
	use ConstructTrait;

	public function build(Renderer $renderer)
	{
		$renderer->lines->add('legend');
		foreach ($this->children as $childBuilder) {
			$childBuilder->build($renderer);
		}
		$renderer->lines->add('endlegend');
	}

	public function append($child): WrapperInterface
	{
		$this->children->add($child);
		return $this;
	}
}
