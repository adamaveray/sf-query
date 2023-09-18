<?php
declare(strict_types=1);

namespace Averay\SfConnect\Objects;

use Averay\SfConnect\ClientInterface;
use Averay\SfConnect\Data\SObjectUrl;

/**
 * @property-read bool $activateable
 * @property-read string|null $associateEntityType
 * @property-read string|null $associateParentEntity
 * @property-read bool $createable
 * @property-read bool $custom
 * @property-read bool $customSetting
 * @property-read bool $deepCloneable
 * @property-read bool $deletable
 * @property-read bool $deprecatedAndHidden
 * @property-read bool $feedEnabled
 * @property-read bool $hasSubtypes
 * @property-read bool $isInterface
 * @property-read bool $isSubtype
 * @property-read string $keyPrefix
 * @property-read string $label
 * @property-read string $labelPlural
 * @property-read bool $layoutable
 * @property-read bool $mergeable
 * @property-read bool $mruEnabled
 * @property-read string $name
 * @property-read bool $queryable
 * @property-read bool $replicateable
 * @property-read bool $retrieveable
 * @property-read bool $searchable
 * @property-read bool $triggerable
 * @property-read bool $undeletable
 * @property-read bool $updateable
 * @property-read array<string,string> $urls
 */
readonly class SObject extends AbstractObject implements \JsonSerializable
{
  public function __construct(array $values, private ClientInterface $client)
  {
    parent::__construct($values);
  }

  protected function getUniqueIdentifier(): string
  {
    return $this->name;
  }

  public function getUrl(SObjectUrl $type): string
  {
    return $this->urls[$type->value];
  }

  public function jsonSerialize(): array
  {
    return $this->values;
  }

  public static function createFromJson(array $values, ClientInterface $client): static
  {
    return new static($values, $client);
  }
}
