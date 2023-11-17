<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Objects\SObject;
use function Averay\SfConnect\formatUrl;
use function Averay\SfConnect\getSObjectName;

/**
 * @internal
 * @psalm-require-extends CollectionsInterface
 */
trait CollectionsSlice
{
  public function getCollection(string|SObject $sobject, array $records, array $fields): array
  {
    return $this->getResponse(
      'GET',
      formatUrl('/composite/sobjects/{sobject}', [
        'sobject' => getSObjectName($sobject),
      ]),
      [
        'query' => [
          'ids' => implode(',', array_map(getRecordId(...), $records)),
          'fields' => implode(',', $fields),
        ],
      ],
    );
  }

  public function createCollection(array $records, bool $allOrNone = false): array
  {
    return $this->getResponse('POST', '/composite/sobjects/', [
      'json' => [
        'allOrNone' => $allOrNone,
        'records' => $records,
      ],
    ]);
  }

  public function createCollectionOfType(string|SObject $sobject, array $records, bool $allOrNone = false): array
  {
    return $this->createCollection(self::addTypeToRecords($sobject, $records), $allOrNone);
  }

  public function updateCollection(array $records, bool $allOrNone = false): array
  {
    return $this->getResponse('PATCH', '/composite/sobjects/', [
      'json' => [
        'allOrNone' => $allOrNone,
        'records' => $records,
      ],
    ]);
  }

  public function updateCollectionOfType(string|SObject $sobject, array $records, bool $allOrNone = false): array
  {
    return $this->updateCollection(self::addTypeToRecords($sobject, self::insertIdsFromKeys($records)), $allOrNone);
  }

  public function upsertCollection(
    string|SObject $sobject,
    string $externalIdFieldName,
    array $records,
    bool $allOrNone = false,
  ): array {
    return $this->getResponse(
      'PATCH',
      formatUrl('/composite/sobjects/{sobject}/{externalField}/', [
        'sobject' => getSObjectName($sobject),
        'externalField' => $externalIdFieldName,
      ]),
      [
        'json' => [
          'allOrNone' => $allOrNone,
          'records' => self::addTypeToRecords($sobject, $records),
        ],
      ],
    );
  }

  public function deleteCollection(array $records, bool $allOrNone = false): array
  {
    return $this->getResponse('DELETE', '/composite/sobjects/', [
      'query' => [
        'ids' => implode(',', array_map(getRecordId(...), $records)),
        'allOrNone' => $allOrNone ? 'true' : 'false',
      ],
    ]);
  }

  /**
   * @psalm-template TRecord of array
   * @param string|SObject $sobject
   * @param list<TRecord> $records
   * @return list<TRecord & array{ attributes: array{ type: string } }>
   */
  private static function addTypeToRecords(string|SObject $sobject, array $records): array
  {
    $name = getSObjectName($sobject);
    return array_map(
      static fn(array $record): array => array_merge_recursive(['attributes' => ['type' => $name]], $record),
      $records,
    );
  }

  /**
   * @psalm-template TRecord of array
   * @param array<string,TRecord> $records
   * @return list<TRecord & array{ id: string }>
   */
  private static function insertIdsFromKeys(array $records): array
  {
    $formatted = [];
    foreach ($records as $id => $record) {
      $record['id'] = $id;
      $formatted[] = $record;
    }
    return $formatted;
  }
}
