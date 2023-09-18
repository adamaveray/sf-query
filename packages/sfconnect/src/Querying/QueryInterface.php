<?php
declare(strict_types=1);

namespace Averay\SfConnect\Querying;

interface QueryInterface
{
  /**
   * @return string The compiled SOQL for the query
   */
  public function getSoql(): string;
}
