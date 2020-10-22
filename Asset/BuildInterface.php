<?php


namespace Tehla\PumlBundle\Asset;

/**
 * Interface BuildInterface
 */
interface BuildInterface
{
    /**
     * @param Renderer $renderer
     *
     * Rajoute dans Renderer::$lines
     * de nouvelle lignes Puml
     * @see Renderer::$lines
     */
    public function build(Renderer $renderer);

    public function getName(): string;

    public function getDesc(): string;
}
