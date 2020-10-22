<?php

namespace Tehla\PumlBundle\Asset;

use Doctrine\Common\Collections\ArrayCollection;

trait ConstructTrait
{
    /** @var BuildInterface[]|iterable */
    protected $children;

    protected $type;

    protected $name;

    protected $desc;

    public function __construct(string $type = '', string $desc = '', ?string $name = null)
    {
        $this->children = new ArrayCollection();
        $this->type = $type;
        $this->desc = $desc;
        $this->name = $name ?? uniqid('plantuml');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDesc(): string
    {
        return $this->desc;
    }
}
