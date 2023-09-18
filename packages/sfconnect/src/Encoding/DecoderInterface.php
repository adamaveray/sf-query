<?php
declare(strict_types=1);

namespace Averay\SfConnect\Encoding;

use Averay\SfConnect\Objects\Record;
use Averay\SfConnect\Objects\SObjectDescribed;

interface DecoderInterface
{
  public function decode(SObjectDescribed $sobject, array|Record $encoded): array;
}
