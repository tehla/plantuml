<?php

namespace Tehla\PumlBundle\Asset;

interface WrapperInterface
{
    public function append($child): WrapperInterface;
}
