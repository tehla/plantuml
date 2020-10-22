<?php

namespace Tehla\PumlBundle\Asset\Common;

use Tehla\PumlBundle\Helper\PumlDisplayHelper;
use Tehla\PumlBundle\Asset\BuildInterface;
use Tehla\PumlBundle\Asset\ConstructTrait;
use Tehla\PumlBundle\Asset\Renderer;

class Relationship implements BuildInterface
{
	use ConstructTrait;
	const PATTERN = '%s %s %s %s';

	/** @var BuildInterface */
	public $from, $to;
	/** @var string */
	private $commentFrom, $commentTo;

	/**
	 * @inheritDoc
	 */
	public function build(Renderer $renderer)
	{
		$renderer->lines->add(sprintf(self::PATTERN,
			$this->commentFrom
				? $this->from->getName() . '"'.$this->commentFrom.'"'
				: PumlDisplayHelper::doubleQuoteIfTiret($this->from->getName()),
			$this->type,
			$this->commentTo
				? $this->to->getName() . '"'.$this->commentTo.'"'
				: PumlDisplayHelper::doubleQuoteIfTiret($this->to->getName()),
			!empty($this->desc) ? ' : '.$this->desc : ''
		));
	}

	public static function create($from, $to, $desc = '')
	{
		return (new self('-->', $desc))->addFromTo($from, $to);
	}

	public static function createTiret($from, $to, $desc = '')
	{
		return (new self('..>', $desc))->addFromTo($from, $to);
	}

	public static function createExtension($from, $to, $desc = '')
	{
		return (new self('--|>', $desc))->addFromTo($from, $to);
	}

	public static function createComposition($from, $to, $desc = '')
	{
		return (new self('--*', $desc))->addFromTo($from, $to);
	}

	public static function createAggregation($from, $to, $desc = '')
	{
		return (new self('--o', $desc))->addFromTo($from, $to);
	}

	public function addFromTo(BuildInterface $from, BuildInterface $to): Relationship
	{
		$this->from = $from;
		$this->to = $to;
		return $this;
	}

	public function addComment(?string $commentFrom = null, ?string $commentTo = null): Relationship
	{
		$this->commentFrom = $commentFrom;
		$this->commentTo = $commentTo;
		return $this;
	}


}