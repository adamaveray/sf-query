<?php
declare(strict_types=1);

namespace Averay\SfConnect\Config;

use Averay\SfConnect\Authentication\Credentials\CredentialsInterface;
use Averay\SfConnect\Client;
use Averay\SfConnect\ClientInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class Instance implements InstanceInterface
{
  private string $hostname;
  private string $version;

  public function __construct(string $serverUrl, private bool $isSandbox = false)
  {
    if (!preg_match('~^https?://([^/]+)/.*?/(\d+\.\d+)/~', $serverUrl, $matches)) {
      throw new \RuntimeException('Invalid server URL');
    }
    $this->hostname = $matches[1];
    $this->version = $matches[2];
  }

  public function getHostname(): string
  {
    return $this->hostname;
  }

  public function getVersion(): string
  {
    return $this->version;
  }

  public function getIsSandbox(): bool
  {
    return $this->isSandbox;
  }

  public function connect(CredentialsInterface $credentials, ?HttpClientInterface $httpClient = null): ClientInterface
  {
    return new Client($this, $credentials, $httpClient);
  }
}
