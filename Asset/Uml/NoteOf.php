<?php

namespace Tehla\PumlBundle\Asset\Uml;

use Tehla\PumlBundle\Asset\{
BuildInterface, WrapperInterface, ConstructTrait, BuildTrait
};

/**
* Generated by AssetMaker
* @see AssetMaker
*/
class NoteOf  implements BuildInterface , WrapperInterface
{
use ConstructTrait, BuildTrait;

/** @var array  */
protected $patterns = [
	'note Position of "OfAsset"',
	'children',
	'end note',
];

/** @var array  */
protected $replaces = [
	'Position' => 'position',
	'OfAsset' => 'ofAsset',
	'children' => '_children_',
];

	protected $position, $ofAsset;

			
		public static function create(string $desc = '', ?string $name = null): self
		{
		return new static('', $desc, $name);
		}
		
		public function is() :bool
		{
		return $this->type = '';
		}
	

						
			public function withPositionOfAsset($position, $ofAsset): self
			{
							$this->position = $position;
							$this->ofAsset = $ofAsset;
						return $this;
			}
			

	public function append($child): WrapperInterface
	{
	$this->children->add($child);
	return $this;
	}
}
