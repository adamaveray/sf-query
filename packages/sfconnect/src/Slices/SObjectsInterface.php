<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Objects\SObject;
use Averay\SfConnect\Objects\SObjectDescribed;

/** @psalm-require-extends \Averay\SfConnect\ClientInterface */
interface SObjectsInterface
{
  /**
   * @return array<string,SObject>
   *
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/dome_describeGlobal.htm
   */
  public function getSObjects(): array;

  /**
   * @param bool $described Whether to load the full described data for the object.
   *
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_describeGlobal.htm
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_describeGlobal.htm
   */
  public function getSObject(string $name, bool $described = false): SObject|SObjectDescribed;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_getdeleted.htm
   */
  public function getSObjectDeleted(string|SObject $sobject, \DateTimeInterface $start, \DateTimeInterface $end): array;

  /**
   * @see https://developer.salesforce.com/docs/atlas.en-us.api_rest.meta/api_rest/resources_getupdated.htm
   */
  public function getSObjectUpdated(string|SObject $sobject, \DateTimeInterface $start, \DateTimeInterface $end): array;
}
