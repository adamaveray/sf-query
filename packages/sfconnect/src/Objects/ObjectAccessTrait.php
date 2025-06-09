<?php
declare(strict_types=1);

namespace Averay\SfConnect\Objects;

trait ObjectAccessTrait
{
  /** @param array<string,mixed> $values */
  public function __construct(protected readonly array $values) {}

  public function __get(string $name): mixed
  {
    return $this->values[$name] ?? null;
  }

  public function __isset(string $name): bool
  {
    return isset($this->values[$name]);
  }

  public function __set(string $name, mixed $value): void
  {
    trigger_error('Cannot write to readonly object');
  }
}
