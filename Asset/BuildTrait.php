<?php

namespace Tehla\PumlBundle\Asset;

use Tehla\PumlBundle\Asset\BuildInterface;
use Tehla\PumlBundle\Asset\Renderer;
use Tehla\PumlBundle\Helper\BuildHelper;

/**
 * Trait BuildTrait
 * @property iterable|BuildInterface[] $children
 * @property iterable $patterns
 * @property iterable $replaces
 */
trait BuildTrait
{
    public function get($ppty)
    {
        return $this->{$ppty};
    }

    public function build(Renderer $renderer)
    {
        foreach ($this->patterns as $pattern) {

            $content = $pattern;
            foreach ($this->replaces as $search => $replace) {
                if ('_children_' === $replace) {
                    if ($search !== $pattern) {
                        continue;//end foreach [search => replace]
                    }
                    $content = '';
                    foreach ($this->children as $child) {
                        if ($child instanceof BuildInterface) {
                            $child->build($renderer);
                        }
                    }
                    continue;//end foreach [search => replace]
                }

                switch (true) {
                    case BuildHelper::caseStartWithUnderscore($search, $replace) :
                        $value = $this->{substr($replace, 1)};
                        $value = BuildHelper::format($value, $search);
                        $value = '_' . $value;
                        $content = str_replace($search, $value, $content);
                        break;

                    case BuildHelper::caseBelongsSubProperty($replace):
                        $sub = $this->{explode('.', $replace)[0]};
                        $subPptyName = explode('.', $replace)[1];
                        $value = method_exists($sub, 'get')
                            ? $sub->get($subPptyName)
                            : $sub->{$subPptyName};
                        $value = BuildHelper::format($value, $search);
                        $content = str_replace($search, $value, $content);
                        break;

					case $this->{$replace} !== null:
						$value =  $this->{$replace};
						$value = BuildHelper::format($value, $search);
						$content = str_replace($search, $value, $content);
						break;

                    default:

                }//end switch
            }//end foreach [search => replace]
            if (!empty($content)) {
                $renderer->lines->add($content);
            }
        }//end foreach patterns
    }
}