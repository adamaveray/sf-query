<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Objects\QueryHandle;
use Averay\SfConnect\Querying\QueryInterface;

/** @psalm-require-extends \Averay\SfConnect\ClientInterface */
interface QueryingInterface
{
  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_query.htm
   */
  public function query(string|QueryInterface $query): QueryHandle;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_query_more_results.htm
   */
  public function queryMore(string|QueryHandle $queryLocator): QueryHandle;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_queryall.htm
   */
  public function queryAll(string|QueryInterface $query): QueryHandle;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_queryall_more_results.htm
   */
  public function queryAllMore(string|QueryHandle $queryLocator): QueryHandle;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_query_performance_feedback.htm
   */
  public function queryPerformance(string|QueryInterface $query): array;
}
