<?php

namespace Tehla\PumlBundle\Asset\Uml;

use Tehla\PumlBundle\Asset\{
BuildInterface, WrapperInterface, ConstructTrait, BuildTrait
};

/**
* Generated by AssetMaker
* @see AssetMaker
*/
class Component  implements BuildInterface 
{
use ConstructTrait, BuildTrait;

/** @var array  */
protected $patterns = [
	'component "name" [',
	'children',
	']',
];

/** @var array  */
protected $replaces = [
	'name' => 'name',
	'children' => '_children_',
];

	protected $name;

			
		public static function create(string $desc = '', ?string $name = null): self
		{
		return new static('', $desc, $name);
		}
		
		public function is() :bool
		{
		return $this->type = '';
		}
	

						public function withName($name): self
			{
			$this->name = $name;
			return $this;
			}
			

}
