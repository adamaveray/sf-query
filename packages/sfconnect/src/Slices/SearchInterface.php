<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Objects\Record;

/** @psalm-require-extends \Averay\SfConnect\ClientInterface */
interface SearchInterface
{
  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_search.htm
   * @return list<Record>
   */
  public function search(string|\Averay\SfConnect\Querying\SearchInterface $query): array;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_search_parameterized_get.htm
   * @return list<Record>
   */
  public function parameterizedSearch(string $string, array $params = []): array;
}
