<?php
declare(strict_types=1);

namespace Averay\SfConnect\Encoding;

use Averay\SfConnect\Data\SObjectFieldType;
use Averay\SfConnect\Data\SObjectFieldType as FieldType;
use Averay\SfConnect\Objects\Record;
use Averay\SfConnect\Objects\SObjectDescribed;
use Averay\SfConnect\Objects\SObjectField;

class SObjectEncoder implements EncoderInterface, DecoderInterface
{
  private const PICKLIST_SEPARATOR = ';';

  private const DATE_FORMAT_DATE = 'Y-m-d';
  private const DATE_FORMAT_DATETIME = 'Y-m-d\\TH:i:s\\Z';

  public function encode(SObjectDescribed $sobject, array $decoded): array
  {
    $encoded = [];
    foreach ($decoded as $fieldName => $value) {
      $encoded[$fieldName] = self::encodeField($sobject->getField($fieldName), $value);
    }
    return $encoded;
  }

  public function decode(SObjectDescribed $sobject, array|Record $encoded): array
  {
    $values = $encoded instanceof Record ? $encoded->getValues() : $encoded;

    $decoded = [];
    foreach ($values as $fieldName => $value) {
      $decoded[$fieldName] = self::decodeField($sobject->getField($fieldName), $value);
    }
    return $decoded;
  }

  private static function encodeField(SObjectField $field, mixed $value): mixed
  {
    static $tz = new \DateTimeZone('UTC');

    if ($value === null) {
      return null;
    }

    return match ($field->type) {
      FieldType::Date => \DateTimeImmutable::createFromInterface($value)
        ->setTimezone($tz)
        ->format(self::DATE_FORMAT_DATE),
      FieldType::DateTime => \DateTimeImmutable::createFromInterface($value)
        ->setTimezone($tz)
        ->format(self::DATE_FORMAT_DATETIME),
      FieldType::MultiPicklist => implode(self::PICKLIST_SEPARATOR, $value),
      default => $value,
    };
  }

  private static function decodeField(SObjectField $field, mixed $value): mixed
  {
    if ($value === null) {
      return null;
    }

    return match ($field->type) {
      FieldType::Date => \DateTimeImmutable::createFromFormat(self::DATE_FORMAT_DATE, $value),
      FieldType::DateTime => \DateTimeImmutable::createFromFormat(self::DATE_FORMAT_DATETIME, $value),
      FieldType::MultiPicklist => $value === '' ? [] : explode(self::PICKLIST_SEPARATOR, $value),
      default => $value,
    };
  }
}
