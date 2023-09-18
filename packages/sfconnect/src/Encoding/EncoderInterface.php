<?php
declare(strict_types=1);

namespace Averay\SfConnect\Encoding;

use Averay\SfConnect\Objects\SObjectDescribed;

interface EncoderInterface
{
  public function encode(SObjectDescribed $sobject, array $decoded): array;
}
