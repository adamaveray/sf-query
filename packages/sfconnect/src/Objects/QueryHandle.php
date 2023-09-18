<?php
declare(strict_types=1);

namespace Averay\SfConnect\Objects;

use Averay\SfConnect\ClientInterface;
use Traversable;

readonly class QueryHandle implements \IteratorAggregate
{
  /** @param list<Record> $records */
  public function __construct(
    public array $records,
    public int $totalSize,
    public bool $done,
    public ?string $nextRecordsUrl,
    private ClientInterface $client,
  ) {
  }

  public function getIterator(): Traversable
  {
    return new \ArrayIterator($this->records);
  }

  public function extractQueryLocator(): string
  {
    if ($this->nextRecordsUrl === null) {
      throw new \BadMethodCallException('No more records');
    }
    if (!preg_match('~^/services/data/v\d+\.\d+/query/([\w-]+)$~', $this->nextRecordsUrl, $matches)) {
      throw new \UnexpectedValueException('Invalid next records URL "' . $this->nextRecordsUrl . '"');
    }
    return $matches[1];
  }

  public static function createFromData(array $data, string $recordClass, ClientInterface $client): self
  {
    $records = array_map(static fn(array $record): Record => new $recordClass($record), $data['records']);
    return new QueryHandle($records, $data['totalSize'], $data['done'], $data['nextRecordsUrl'] ?? null, $client);
  }
}
