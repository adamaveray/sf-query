<?php
declare(strict_types=1);

namespace Averay\SfConnect\Slices;

/**
 * @internal
 * @psalm-require-extends MetaInterface
 */
trait MetaSlice
{
  public function getResources(): array
  {
    return $this->getResponse('GET', '/');
  }
}
