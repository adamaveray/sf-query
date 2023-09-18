<?php
declare(strict_types=1);

namespace Averay\SfConnect\Objects;

use Averay\SfConnect\Data\SObjectFieldType;

/**
 * @property-read bool $aggregatable
 * @property-read bool $aiPredictionField
 * @property-read bool $autoNumber
 * @property-read int $byteLength
 * @property-read bool $calculated
 * @property-read string|null $calculatedFormula
 * @property-read bool $cascadeDelete
 * @property-read bool $caseSensitive
 * @property-read string|null $compoundFieldName
 * @property-read string|null $controllerName
 * @property-read bool $createable
 * @property-read bool $custom
 * @property-read mixed|null $defaultValue
 * @property-read string|null $defaultValueFormula
 * @property-read bool $defaultedOnCreate
 * @property-read bool $dependentPicklist
 * @property-read bool $deprecatedAndHidden
 * @property-read int $digits
 * @property-read bool $displayLocationInDecimal
 * @property-read bool $encrypted
 * @property-read bool $externalId
 * @property-read string|null $extraTypeInfo
 * @property-read bool $filterable
 * @property-read array|null $filteredLookupInfo
 * @property-read bool $formulaTreatNullNumberAsZero
 * @property-read bool $groupable
 * @property-read bool $highScaleNumber
 * @property-read bool $htmlFormatted
 * @property-read bool $idLookup
 * @property-read string|null $inlineHelpText
 * @property-read string $label
 * @property-read int $length
 * @property-read string|null $mask
 * @property-read string|null $maskType
 * @property-read string $name
 * @property-read bool $nameField
 * @property-read bool $namePointing
 * @property-read bool $nillable
 * @property-read bool $permissionable
 * @property-read array $picklistValues
 * @property-read bool $polymorphicForeignKey
 * @property-read int $precision
 * @property-read bool $queryByDistance
 * @property-read string|null $referenceTargetField
 * @property-read array $referenceTo
 * @property-read string|null $relationshipName
 * @property-read mixed|null $relationshipOrder
 * @property-read bool $restrictedDelete
 * @property-read bool $restrictedPicklist
 * @property-read int $scale
 * @property-read bool $searchPrefilterable
 * @property-read string $soapType
 * @property-read bool $sortable
 * @property-read SObjectFieldType $type
 * @property-read bool $unique
 * @property-read bool $updateable
 * @property-read bool $writeRequiresMasterRead
 */
readonly final class SObjectField extends AbstractObject implements \JsonSerializable
{
  public function __construct(array $values)
  {
    $values['type'] = SObjectFieldType::from($values['type']);
    parent::__construct($values);
  }

  protected function getUniqueIdentifier(): string
  {
    return $this->name;
  }

  public function jsonSerialize(): array
  {
    $values = $this->values;
    $values['type'] = $values['type']->value;
    return $values;
  }
}
