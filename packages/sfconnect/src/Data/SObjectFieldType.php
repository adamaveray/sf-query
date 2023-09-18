<?php
declare(strict_types=1);

namespace Averay\SfConnect\Data;

/**
 * @see https://developer.salesforce.com/docs/atlas.en-us.244.0.object_reference.meta/object_reference/field_types.htm
 */
enum SObjectFieldType: string
{
  public const ANYTYPE_TYPES = [
    self::Boolean,
    self::Date,
    self::DateTime,
    self::Double,
    self::Email,
    self::Id,
    self::Int,
    self::Percent,
    self::Picklist,
    self::String,
    self::Url,
  ];

  case Address = 'address';
  case AnyType = 'anyType';
  case Base64 = 'base64';
  case Boolean = 'boolean';
  case Currency = 'currency';
  case Date = 'date';
  case DateTime = 'datetime';
  case Double = 'double';
  case Email = 'email';
  case EncryptedString = 'encryptedstring';
  case Id = 'id';
  case Int = 'int';
  case Location = 'location';
  case MultiPicklist = 'multipicklist';
  case Percent = 'percent';
  case Phone = 'phone';
  case Picklist = 'picklist';
  case Reference = 'reference';
  case String = 'string';
  case Textarea = 'textarea';
  case Url = 'url';
}
