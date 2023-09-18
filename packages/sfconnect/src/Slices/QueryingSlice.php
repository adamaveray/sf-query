<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Client;
use Averay\SfConnect\Objects\QueryHandle;
use Averay\SfConnect\Objects\Record;
use Averay\SfConnect\Querying\QueryInterface;
use function Averay\SfConnect\formatUrl;

/**
 * @internal
 * @psalm-require-extends QueryingInterface
 */
trait QueryingSlice
{
  public const QUERY_BATCH_SIZE_MINIMUM = 200;
  public const QUERY_BATCH_SIZE_MAXIMUM = 2000;

  public function query(string|QueryInterface $query, ?int $batchSize = null): QueryHandle
  {
    $result = $this->getResponse('GET', '/query', [
      'query' => ['q' => self::flattenQuery($query)],
      'headers' => self::buildQueryOptionsHeaders($batchSize),
    ]);
    return QueryHandle::createFromData($result, Record::class, $this);
  }

  public function queryMore(string|QueryHandle $queryLocator, ?int $batchSize = null): QueryHandle
  {
    $queryLocator = $queryLocator instanceof QueryHandle ? $queryLocator->extractQueryLocator() : $queryLocator;
    $result = $this->getResponse('GET', formatUrl('/query/{queryLocator}', ['queryLocator' => $queryLocator]), [
      'headers' => self::buildQueryOptionsHeaders($batchSize),
    ]);
    return QueryHandle::createFromData($result, Record::class, $this);
  }

  public function queryAll(string|QueryInterface $query, ?int $batchSize = null): QueryHandle
  {
    $result = $this->getResponse('GET', '/queryAll', [
      'query' => ['q' => self::flattenQuery($query)],
      'headers' => self::buildQueryOptionsHeaders($batchSize),
    ]);
    return QueryHandle::createFromData($result, Record::class, $this);
  }

  public function queryAllMore(string|QueryHandle $queryLocator, ?int $batchSize = null): QueryHandle
  {
    $queryLocator = $queryLocator instanceof QueryHandle ? $queryLocator->extractQueryLocator() : $queryLocator;
    $result = $this->getResponse('GET', formatUrl('/queryAll/{queryLocator}', ['queryLocator' => $queryLocator]), [
      'headers' => self::buildQueryOptionsHeaders($batchSize),
    ]);
    return QueryHandle::createFromData($result, Record::class, $this);
  }

  public function queryPerformance(string|QueryInterface $query): array
  {
    $result = $this->getResponse('GET', '/query', [
      'query' => ['explain' => self::flattenQuery($query)],
    ]);
    return $result['plans'];
  }

  /**
   * @param int|null $batchSize
   * @return array<string,string> Additional headers to be sent with the query request
   * @see https://developer.salesforce.com/docs/atlas.en-us.244.0.api_rest.meta/api_rest/headers_queryoptions.htm Rest API Query Options Header documentation
   */
  private static function buildQueryOptionsHeaders(?int $batchSize): array
  {
    /** @var array<string,string|int|float> $options */
    $options = [];
    if ($batchSize !== null) {
      if ($batchSize < self::QUERY_BATCH_SIZE_MINIMUM) {
        throw new \OutOfRangeException('Batch size cannot be less than ' . self::QUERY_BATCH_SIZE_MINIMUM);
      }
      if ($batchSize > self::QUERY_BATCH_SIZE_MAXIMUM) {
        throw new \OutOfRangeException('Batch size cannot be greater than ' . self::QUERY_BATCH_SIZE_MAXIMUM);
      }
      $options['batchSize'] = $batchSize;
    }

    return ['Sforce-Query-Options' => $options === [] ? null : http_build_query($options)];
  }

  private static function flattenQuery(string|QueryInterface $query): string
  {
    return $query instanceof QueryInterface ? $query->getSoql() : $query;
  }
}
