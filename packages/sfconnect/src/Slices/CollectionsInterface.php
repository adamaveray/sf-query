<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Objects\Record;
use Averay\SfConnect\Objects\SObject;
use Averay\SfConnect\Objects\SObjectField;

/** @psalm-require-extends \Averay\SfConnect\ClientInterface */
interface CollectionsInterface
{
  /**
   * @param list<string|Record> $records
   * @param list<SObjectField|string> $fields
   * @return list<array|null>
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_composite_sobjects_collections_retrieve.htm
   */
  public function getCollection(string|SObject $sobject, array $records, array $fields): array;

  /**
   * @param list<array{ attributes: array{ type: string } } & array<string,mixed>> $records
   * @return list<array{ success: true, id: string, errors: list<mixed> } | array{ success: false, errors: list<mixed> }>
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_composite_sobjects_collections_create.htm
   */
  public function createCollection(array $records, bool $allOrNone = false): array;

  /**
   * @param list<array<string,mixed>> $records
   * @return list<array{ id: string, success: bool, errors: list<mixed> }>
   */
  public function createCollectionOfType(string|SObject $sobject, array $records, bool $allOrNone = false): array;

  /**
   * @param list<array{ attributes: array{ type: string }, id: string } & array<string,mixed>> $records
   * @return list<array{ id: string, success: bool, errors: list<mixed> }>
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_composite_sobjects_collections_update.htm
   */
  public function updateCollection(array $records, bool $allOrNone = false): array;

  /**
   * @param array<string, array<string,mixed>> $records Keys are object IDs, values are object values to update
   * @return list<array{ id: string, success: bool, errors: list<mixed> }>
   */
  public function updateCollectionOfType(string|SObject $sobject, array $records, bool $allOrNone = false): array;

  /**
   * @param list<array<string,mixed>> $records
   * @return list<array{ id: string, success: bool, errors: list<mixed>, created: bool }>
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_composite_sobjects_collections_upsert.htm
   */
  public function upsertCollection(
    string|SObject $sobject,
    string $externalIdFieldName,
    array $records,
    bool $allOrNone = false,
  ): array;

  /**
   * @param list<string|Record> $records
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_composite_sobjects_collections_delete.htm
   */
  public function deleteCollection(array $records, bool $allOrNone = false): array;
}
