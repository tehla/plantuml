<?php

namespace Tehla\PumlBundle\Asset\Archimate;

class Renderer extends \Tehla\PumlBundle\Asset\Renderer
{
    const INCLUDE_MACROS = '!includeurl https://raw.githubusercontent.com/ebbypeter/Archimate-PlantUML/master/Archimate.puml';

    public function start(\Tehla\PumlBundle\Asset\Renderer $renderer)
    {
        \Tehla\PumlBundle\Asset\Renderer::start($this);
        $this->lines->add(self::INCLUDE_MACROS);
    }

}
