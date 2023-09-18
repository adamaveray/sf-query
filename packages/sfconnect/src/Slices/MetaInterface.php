<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

/** @psalm-require-extends \Averay\SfConnect\ClientInterface */
interface MetaInterface
{
  /**
   * @return array<string,string>
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/dome_discoveryresource.htm
   */
  public function getResources(): array;
}
