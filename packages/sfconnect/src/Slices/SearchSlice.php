<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Client;
use Averay\SfConnect\Objects\Record;
use Averay\SfConnect\Querying\QueryInterface;
use Averay\SfConnect\Querying\SearchInterface as QueryingSearchInterface;
use function Averay\SfConnect\getQuery;

/**
 * @internal
 * @psalm-require-extends SearchInterface
 */
trait SearchSlice
{
  public function search(string|QueryingSearchInterface $search): array
  {
    $result = $this->getResponse('GET', '/search/', [
      'query' => ['q' => self::flattenSearch($search)],
    ]);
    return array_map(static fn(array $record): Record => new Record($record), $result['searchRecords']);
  }

  public function parameterizedSearch(string $string, array $params = []): array
  {
    $result = $this->getResponse('GET', '/parameterizedSearch/', [
      'query' => ['q' => $string] + $params,
    ]);
    return array_map(static fn(array $record): Record => new Record($record), $result['searchRecords']);
  }

  private static function flattenSearch(string|QueryingSearchInterface $search): string
  {
    return $search instanceof QueryingSearchInterface ? $search->getSosl() : $search;
  }
}
