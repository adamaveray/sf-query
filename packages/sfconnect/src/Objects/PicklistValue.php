<?php
declare(strict_types=1);

namespace Averay\SfConnect\Objects;

final class PicklistValue
{
  public function __construct(
    public readonly string $value,
    public readonly string $label,
    public readonly bool $active,
    public readonly bool $defaultValue,
    public readonly mixed $validFor,
  ) {
  }

  public static function createFromData(array $values): self
  {
    return new self(
      $values['value'],
      $values['label'],
      $values['active'],
      $values['defaultValue'],
      $values['validFor'],
    );
  }
}
