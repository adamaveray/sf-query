<?php
declare(strict_types=1);

namespace Averay\SfConnect\Config;

interface InstanceInterface
{
  public function getHostname(): string;
  public function getVersion(): string;
  public function getIsSandbox(): bool;
}
