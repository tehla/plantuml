<?php

namespace Tehla\PumlBundle\Asset;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Renderer implements WrapperInterface
{

    /** @var Collection */
    public $lines;

    public $children;

    const START = '@startuml';
    const END = '@enduml';

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->lines = new ArrayCollection();
    }

    public function start(Renderer $renderer)
    {
        $renderer->lines->add(self::START);
    }

    public function end(Renderer $renderer)
    {
        $renderer->lines->add(self::END);
    }

    public function append($child): WrapperInterface
    {
        $this->children->add($child);
        return $this;
    }

    public function render()
    {
        $this->start($this);
        foreach ($this->children as $child) {
            if ($child instanceof BuildInterface) {
            	try {
					$child->build($this);
				} catch (\Exception $e) {
					throw $e;
				}
            }
        }
        $this->end($this);

        return implode(PHP_EOL, $this->lines->toArray());
    }
}
