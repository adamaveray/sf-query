<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

/** @psalm-require-extends \Averay\SfConnect\ClientInterface */
interface SearchInterface
{
  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_search.htm
   */
  public function search(string|\Averay\SfConnect\Querying\SearchInterface $query): array;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_search_parameterized_get.htm
   */
  public function parameterizedSearch(string $string, array $params = []): array;
}
