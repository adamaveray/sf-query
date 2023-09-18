<?php
declare(strict_types=1);

namespace Averay\SfConnect\Objects;

/**
 * @property string $Id
 * @property array<string,mixed> $attributes
 *
 * @psalm-consistent-constructor
 */
class Record
{
  use ObjectAccessTrait;

  /** @return array<string,mixed> */
  public function getValues(): array
  {
    return array_diff_key($this->values, ['attributes' => true]);
  }
}
