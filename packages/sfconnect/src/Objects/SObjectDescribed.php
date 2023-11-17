<?php
declare(strict_types=1);

namespace Averay\SfConnect\Objects;

/**
 * @property-read array<string,SObjectField> $fields
 */
readonly final class SObjectDescribed extends SObject
{
  public function __construct(array $values)
  {
    $values['fields'] = self::processFields($values['fields']);
    parent::__construct($values);
  }

  /**
   * @param list<array> $fields
   * @return array<string,SObjectField>
   */
  private static function processFields(array $fields): array
  {
    $processedFields = [];
    foreach ($fields as $fieldValues) {
      $field = new SObjectField($fieldValues);
      $processedFields[$field->name] = $field;
    }
    return $processedFields;
  }

  public function jsonSerialize(): array
  {
    $values = parent::jsonSerialize();
    $values['fields'] = array_map(static fn(SObjectField $field): array => $field->jsonSerialize(), $values['fields']);
    return $values;
  }

  public function getField(string $fieldName): SObjectField
  {
    $field = $this->fields[$fieldName] ?? null;
    if ($field === null) {
      throw new \OutOfBoundsException('Undefined field "' . $fieldName . '"');
    }
    return $field;
  }
}
