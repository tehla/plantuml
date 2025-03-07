<?php

namespace Tehla\PumlBundle\Asset\Archimate;

use Tehla\PumlBundle\Asset\{
BuildInterface, WrapperInterface, ConstructTrait, BuildTrait
};

/**
* Generated by AssetMaker
* @see AssetMaker
*/
class Group  implements BuildInterface , WrapperInterface
{
use ConstructTrait, BuildTrait;

/** @var array  */
protected $patterns = [
	'Type(name, "desc"){',
	'children',
	'}',
];

/** @var array  */
protected $replaces = [
	'Type' => 'type',
	'name' => 'name',
	'desc' => 'desc',
	'children' => '_children_',
];


			
		public static function createGroup(string $desc = 'group', ?string $name = null): self
		{
		return new static('group', $desc, $name);
		}
		
		public function isGroup() :bool
		{
		return $this->type = 'group';
		}
			
		public static function createGrouping(string $desc = 'grouping', ?string $name = null): self
		{
		return new static('grouping', $desc, $name);
		}
		
		public function isGrouping() :bool
		{
		return $this->type = 'grouping';
		}
	



	public function append($child): WrapperInterface
	{
	$this->children->add($child);
	return $this;
	}
}
