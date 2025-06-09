<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Objects\Record;
use Averay\SfConnect\Objects\SObject;
use Averay\SfConnect\Objects\SObjectField;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

/** @psalm-require-extends \Averay\SfConnect\ClientInterface */
interface RecordsInterface
{
  /**
   * @param list<SObjectField|string> $fields
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_retrieve_get.htm
   */
  public function getRecord(string|SObject $sobject, string|Record $record, array $fields): Record;

  /**
   * @param array<string,mixed> $values
   * @return string The ID of the created record
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_basic_info_post.htm
   */
  public function createRecord(string|SObject $sobject, array $values): string;

  /**
   * @param array<string,mixed> $values
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_retrieve_patch.htm
   */
  public function updateRecord(string|SObject $sobject, string|Record $record, array $values): void;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_retrieve_delete.htm
   */
  public function deleteRecord(string|SObject $sobject, string|Record $record): void;

  /**
   * @param list<SObjectField|string> $fields
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_upsert_get.htm
   */
  public function getRecordByExternalId(
    string|SObject $sobject,
    string $idField,
    string $externalId,
    array $fields,
  ): array;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_upsert_patch.htm
   */
  public function updateRecordByExternalId(
    string|SObject $sobject,
    string $idField,
    string $externalId,
    array $values,
  ): void;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_upsert_delete.htm
   */
  public function deleteRecordByExternalId(string|SObject $sobject, string $idField, string $externalId): void;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_blob_retrieve.htm
   */
  public function getRecordBlob(string|SObject $sobject, string|Record $record, string $blobField): string;

  /**
   * @return array{ headers: string[][], stream: ResponseStreamInterface }
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_sobject_blob_retrieve.htm
   */
  public function streamRecordBlob(string|SObject $sobject, string|Record $record, string $blobField): array;

  /**
   * @param string|resource $blob
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/dome_sobject_insert_update_blob.htm
   */
  public function uploadRecordBlob(string $blobField, mixed $blob): array;
}
