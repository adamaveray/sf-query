<?php
declare(strict_types=1);

namespace Averay\SfConnect\Objects;

abstract readonly class AbstractObject
{
  use ObjectAccessTrait {
    ObjectAccessTrait::__isset as private __objectAccessIsset;
    ObjectAccessTrait::__get as private __objectAccessGet;
  }

  private const PROPERTY_UNIQUE_IDENTIFIER = 'uniqueIdentifier';

  abstract protected function getUniqueIdentifier(): string;

  public function __isset(string $name): bool
  {
    return $name === self::PROPERTY_UNIQUE_IDENTIFIER || $this->__objectAccessIsset($name);
  }

  public function __get(string $name): mixed
  {
    if ($name === self::PROPERTY_UNIQUE_IDENTIFIER) {
      return $this->getUniqueIdentifier();
    }

    return $this->__objectAccessGet($name);
  }

  final public function __set(string $name, mixed $value): void
  {
    trigger_error('Cannot write to readonly object');
  }
}
