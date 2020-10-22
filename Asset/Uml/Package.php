<?php

namespace Tehla\PumlBundle\Asset\Uml;

use Tehla\PumlBundle\Asset\{
BuildInterface, WrapperInterface, ConstructTrait, BuildTrait
};

/**
* Generated by AssetMaker
* @see AssetMaker
*/
class Package  implements BuildInterface , WrapperInterface
{
use ConstructTrait, BuildTrait;

/** @var array  */
protected $patterns = [
	'package "name" <<Type>> {',
	'children',
	'}',
];

/** @var array  */
protected $replaces = [
	'desc' => 'desc',
	'children' => '_children_',
];

	protected $name;

			
		public static function createNode(string $desc = 'Node', ?string $name = null): self
		{
		return new static('Node', $desc, $name);
		}
		
		public function isNode() :bool
		{
		return $this->type = 'Node';
		}
			
		public static function createRectangle(string $desc = 'Rectangle', ?string $name = null): self
		{
		return new static('Rectangle', $desc, $name);
		}
		
		public function isRectangle() :bool
		{
		return $this->type = 'Rectangle';
		}
			
		public static function createFolder(string $desc = 'Folder', ?string $name = null): self
		{
		return new static('Folder', $desc, $name);
		}
		
		public function isFolder() :bool
		{
		return $this->type = 'Folder';
		}
			
		public static function createFrame(string $desc = 'Frame', ?string $name = null): self
		{
		return new static('Frame', $desc, $name);
		}
		
		public function isFrame() :bool
		{
		return $this->type = 'Frame';
		}
			
		public static function createCloud(string $desc = 'Cloud', ?string $name = null): self
		{
		return new static('Cloud', $desc, $name);
		}
		
		public function isCloud() :bool
		{
		return $this->type = 'Cloud';
		}
			
		public static function createDatabase(string $desc = 'Database', ?string $name = null): self
		{
		return new static('Database', $desc, $name);
		}
		
		public function isDatabase() :bool
		{
		return $this->type = 'Database';
		}
	

						public function withName($name): self
			{
			$this->name = $name;
			return $this;
			}
			

	public function append($child): WrapperInterface
	{
	$this->children->add($child);
	return $this;
	}
}
