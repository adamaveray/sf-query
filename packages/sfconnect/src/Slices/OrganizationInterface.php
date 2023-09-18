<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Objects\Limit;

/** @psalm-require-extends \Averay\SfConnect\ClientInterface */
interface OrganizationInterface
{
  /**
   * @return array<string,Limit>
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_limits.htm
   */
  public function getLimits(): array;
}
