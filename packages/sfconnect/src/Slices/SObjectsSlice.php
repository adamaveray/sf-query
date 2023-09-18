<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Client;
use Averay\SfConnect\Objects\SObject;
use Averay\SfConnect\Objects\SObjectDescribed;
use function Averay\SfConnect\formatUrl;
use function Averay\SfConnect\getSObjectName;

/**
 * @internal
 * @psalm-require-extends SObjectsInterface
 */
trait SObjectsSlice
{
  public function getSObjects(): array
  {
    $data = $this->getResponse('GET', '/sobjects/');
    $objects = [];
    foreach ($data['sobjects'] as $item) {
      $object = new SObject($item, $this);
      $objects[$object->name] = $object;
    }
    return $objects;
  }

  public function getSObject(string $name, bool $described = false): SObject|SObjectDescribed
  {
    $data = $this->getResponse(
      'GET',
      formatUrl('/sobjects/{sobject}/' . ($described ? 'describe/' : ''), ['sobject' => $name]),
    );
    return $described ? new SObjectDescribed($data, $this) : new SObject($data['objectDescribe'], $this);
  }

  public function getSObjectDeleted(string|SObject $sobject, \DateTimeInterface $start, \DateTimeInterface $end): array
  {
    return $this->getResponse(
      'GET',
      formatUrl('/sobjects/{sobject}/deleted/', ['sobject' => getSObjectName($sobject)]),
      [
        'query' => [
          'start' => $start->format('c'),
          'end' => $end->format('c'),
        ],
      ],
    );
  }

  public function getSObjectUpdated(string|SObject $sobject, \DateTimeInterface $start, \DateTimeInterface $end): array
  {
    return $this->getResponse(
      'GET',
      formatUrl('/sobjects/{sobject}/updated/', ['sobject' => getSObjectName($sobject)]),
      [
        'query' => [
          'start' => $start->format('c'),
          'end' => $end->format('c'),
        ],
      ],
    );
  }
}
