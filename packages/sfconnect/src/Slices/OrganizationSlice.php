<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

use Averay\SfConnect\Objects\Limit;

/**
 * @internal
 * @psalm-require-extends OrganizationInterface
 */
trait OrganizationSlice
{
  public function getLimits(): array
  {
    return array_map(static fn(array $data): Limit => new Limit($data), $this->getResponse('GET', '/limits/'));
  }
}
