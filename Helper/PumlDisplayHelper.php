<?php


namespace Tehla\PumlBundle\Helper;


use Tehla\PumlBundle\Asset\BuildInterface;
use Tehla\PumlBundle\Asset\Common\Line;
use Tehla\PumlBundle\Asset\Transparent;
use Tehla\PumlBundle\Asset\WrapperInterface;

class PumlDisplayHelper
{
    const DIRECTIONS = ['up', 'right', 'down', 'left'];

	/**
	 * @param BuildInterface $centerBuilder
	 * @param iterable|BuildInterface[] $aroundBuilders
	 * @param WrapperInterface $wrapper
	 * @param string $direction
	 * @param bool $antihoraire
	 * Un enroulage en escargot / @
	 */
    public static function around(BuildInterface $centerBuilder, iterable $aroundBuilders, WrapperInterface $wrapper, $direction = 'up', $antihoraire = false)
    {
        $wrapper->append($centerBuilder);
        $previous = $centerBuilder;
        foreach ($aroundBuilders as $i => $next) {
            if (self::shouldTurn($i)) {
                self::changeDirection($direction, $antihoraire);
            }
            $wrapper->append($next);
            $wrapper->append(new Line(self::go($direction, $previous, $next)));
            $previous = $next;
        }
    }

    public static function grid(iterable $grid , WrapperInterface $wrapper)
	{
		foreach ($grid as $rowAssets) {
			$firstRowAsset = reset($rowAssets);
			foreach ($rowAssets as $rowAsset) {
				$wrapper->append($rowAsset);
				if (isset($previousFirstRowAsset) && $rowAsset === $firstRowAsset) {
					unset($previousRowAsset);
					$wrapper->append(new Line(self::go('down', $previousFirstRowAsset, $firstRowAsset)));
				}
				if (isset($previousRowAsset)) {
					$wrapper->append(new Line(self::go('right', $previousRowAsset, $rowAsset)));
				}
				$previousRowAsset = $rowAsset;
			}
			$previousFirstRowAsset = reset($rowAssets);
		}
	}

	public static function convertToGrid(array $list): array
	{
		$grid = [];
		$list = array_values($list);
		$listCount = 0;
		$goldenSize = ceil(sizeof($list) / 3);

		$rowsCount = 0;
		while ($rowsCount <= $goldenSize * 2) {
			$row = [];
			$colsCount = 0;
			while ($colsCount <= $goldenSize) {
				if (isset($list[$listCount])) {
					$row[] = $list[$listCount];
					$listCount++;
				}
				$colsCount++;
			}
			$grid[] = $row;
			$rowsCount++;
		}

		return $grid;
	}

    public static function horizontal(iterable $builders, WrapperInterface $wrapper)
    {
        foreach ($builders as $builder) {
			$wrapper->append($builder);
        	if (isset($previous)) {
				$wrapper->append(new Line(self::go('right', $previous, $builder)));
			}
            $previous = $builder;
        }
    }

    public static function vertical(iterable $builders, WrapperInterface $wrapper, $maxByColumns = 10)
    {
		foreach ($builders as $builder) {
			$wrapper->append($builder);
			if (isset($previous)) {
				$wrapper->append(new Line(self::go('down', $previous, $builder)));
			}
			$previous = $builder;
		}
    }

    private static function shouldTurn($iteration)
    {
        return $iteration > 0 && (floor(sqrt($iteration)) * ceil(sqrt($iteration))) == $iteration;
    }

    public static function changeDirection(string &$direction, bool $antihoraire = false)
    {
    	$directions = $antihoraire ? array_reverse(self::DIRECTIONS) : self::DIRECTIONS;
        $direction = $directions[(array_search($direction, self::DIRECTIONS) +1) % 4];
    }

	public static function go($direction, BuildInterface $from, BuildInterface $to)
    {
		return sprintf('%s -[hidden]%s- %s',
			self::doubleQuoteIfTiret($from->getName()),
			$direction,
			self::doubleQuoteIfTiret($to->getName())
		);
    }

	public static function doubleQuoteIfTiret(string $name) {
    	if (strpos($name, '-') || strpos($name, ' ')) {
    		$name = "\"$name\"";
		}
    	return $name;
	}
}
