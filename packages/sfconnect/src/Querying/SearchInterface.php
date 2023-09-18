<?php
declare(strict_types=1);

namespace Averay\SfConnect\Querying;

interface SearchInterface
{
  /**
   * @return string The compiled SOSL for the query
   */
  public function getSosl(): string;
}
