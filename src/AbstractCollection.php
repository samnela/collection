<?php
declare(strict_types=1);

/**
 * This file is part of the ramsey/collection library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey <ben@benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @link https://benramsey.com/projects/ramsey-collection/ Documentation
 * @link https://packagist.org/packages/ramsey/collection Packagist
 * @link https://github.com/ramsey/collection GitHub
 */

namespace Ramsey\Collection;

use Ramsey\Collection\Tool\TypeTrait;
use Ramsey\Collection\Tool\ValueToStringTrait;

/**
 * This class provides an implementation of the CollectionInterface, to
 * minimize the effort required to implement this interface
 */
abstract class AbstractCollection extends AbstractArray implements CollectionInterface
{
    use TypeTrait;
    use ValueToStringTrait;

    public function add($element): bool
    {
        $this[] = $element;

        return true;
    }

    public function contains($element, bool $strict = true): bool
    {
        return in_array($element, $this->data, $strict);
    }

    public function offsetSet($offset, $value): void
    {
        if ($this->checkType($this->getType(), $value) === false) {
            throw new \InvalidArgumentException(
                'Value must be of type ' . $this->getType() . '; value is '
                . $this->toolValueToString($value)
            );
        }

        $this->data[] = $value;
    }

    public function remove($element): bool
    {
        if (($position = array_search($element, $this->data, true)) !== false) {
            unset($this->data[$position]);

            return true;
        }

        return false;
    }
}
