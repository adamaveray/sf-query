<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Client;
use Averay\SfConnect\Objects\Record;
use Averay\SfConnect\Objects\SObject;
use Averay\SfConnect\Objects\SObjectField;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;
use function Averay\SfConnect\formatUrl;
use function Averay\SfConnect\getRecordId;
use function Averay\SfConnect\getSObjectName;

/**
 * @internal
 * @psalm-require-extends RecordsInterface
 */
trait RecordsSlice
{
  public function getRecord(string|SObject $sobject, string|Record $record, array $fields): Record
  {
    $response = $this->getResponse(
      'GET',
      formatUrl('/sobjects/{sobject}/{id}', [
        'sobject' => getSObjectName($sobject),
        'id' => getRecordId($record),
      ]),
      ['query' => ['fields' => implode(',', self::normaliseFields($fields))]],
    );
    return new Record($response);
  }

  public function createRecord(string|SObject $sobject, array $values): string
  {
    $result = $this->getResponse('POST', formatUrl('/sobjects/{sobject}', ['sobject' => getSObjectName($sobject)]), [
      'json' => $values,
    ]);
    if (!$result['success']) {
      throw new \RuntimeException(
        'Failed creating record (' . json_encode($result['errors'], \JSON_THROW_ON_ERROR) . ')',
      ); // TODO: Custom error types
    }
    return $result['id'];
  }

  public function updateRecord(string|SObject $sobject, string|Record $record, array $values): void
  {
    $this->makeRequest(
      'PATCH',
      formatUrl('/sobjects/{sobject}/{id}', [
        'sobject' => getSObjectName($sobject),
        'id' => getRecordId($record),
      ]),
      ['json' => $values],
    );
  }

  public function deleteRecord(string|SObject $sobject, string|Record $record): void
  {
    $this->makeRequest(
      'DELETE',
      formatUrl('/sobjects/{sobject}/{id}', [
        'sobject' => getSObjectName($sobject),
        'id' => getRecordId($record),
      ]),
    );
  }

  public function getRecordByExternalId(
    string|SObject $sobject,
    string $idField,
    string $externalId,
    array $fields,
  ): array {
    return $this->getResponse(
      'GET',
      formatUrl('/sobjects/{sobject}/{field}/{id}', [
        'sobject' => getSObjectName($sobject),
        'field' => $idField,
        'id' => $externalId,
      ]),
      ['query' => ['fields' => implode(',', self::normaliseFields($fields))]],
    );
  }

  public function updateRecordByExternalId(
    string|SObject $sobject,
    string $idField,
    string $externalId,
    array $values,
  ): void {
    $this->makeRequest(
      'PATCH',
      formatUrl('/sobjects/{sobject}/{field}/{id}', [
        'sobject' => getSObjectName($sobject),
        'field' => $idField,
        'id' => $externalId,
      ]),
      ['json' => $values],
    );
  }

  public function deleteRecordByExternalId(string|SObject $sobject, string $idField, string $externalId): void
  {
    $this->makeRequest(
      'DELETE',
      formatUrl('/sobjects/{sobject}/{field}/{id}', [
        'sobject' => getSObjectName($sobject),
        'field' => $idField,
        'id' => $externalId,
      ]),
    );
  }

  public function getRecordBlob(string|SObject $sobject, string|Record $record, string $blobField): string
  {
    return $this->makeRawRequest(
      'GET',
      formatUrl('/sobjects/{sobject}/{id}/{blobField}', [
        'sobject' => getSObjectName($sobject),
        'id' => getRecordId($record),
        'blobField' => $blobField,
      ]),
    )->getContent();
  }

  /**
   * @return array{ headers: string[][], stream: ResponseStreamInterface }
   */
  public function streamRecordBlob(string|SObject $sobject, string|Record $record, string $blobField): array
  {
    $response = $this->makeRawRequest(
      'GET',
      formatUrl('/sobjects/{sobject}/{id}/{blobField}', [
        'sobject' => getSObjectName($sobject),
        'id' => getRecordId($record),
        'blobField' => $blobField,
      ]),
    );
    return [
      'headers' => $response->getHeaders(),
      'stream' => $this->httpClient->stream($response),
    ];
  }

  /**
   * @param list<SObjectField|string> $fields
   * @return list<string>
   */
  private static function normaliseFields(array $fields): array
  {
    return array_map(
      static fn(string|SObjectField $field): string => \is_string($field) ? $field : $field->name,
      $fields,
    );
  }
}
