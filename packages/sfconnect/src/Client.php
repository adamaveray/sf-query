<?php
declare(strict_types=1);

namespace Averay\SfConnect;

use Averay\SfConnect\Authentication\Credentials\CredentialsInterface;
use Averay\SfConnect\Config\InstanceInterface;
use Symfony\Component\HttpClient\Exception as HttpException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Client implements ClientInterface
{
  use Slices\MetaSlice;
  use Slices\OrganizationSlice;
  use Slices\QueryingSlice;
  use Slices\RecordsSlice;
  use Slices\SearchSlice;
  use Slices\SObjectsSlice;

  private readonly HttpClientInterface $httpClient;
  private readonly string $baseUrl;

  public function __construct(
    public readonly InstanceInterface $instance,
    private readonly CredentialsInterface $credentials,
    ?HttpClientInterface $httpClient = null,
  ) {
    $this->httpClient = $httpClient ?? HttpClient::create();
    $this->baseUrl =
      'https://' . $this->instance->getHostname() . '/services/data/' . urlencode('v' . $this->instance->getVersion());
  }

  public function makeRequest(string $method, string $endpoint, array $options = []): ResponseInterface
  {
    $options['headers'] ??= [];
    $options['headers']['accept'] ??= 'application/json';
    $response = $this->makeRawRequest($method, $endpoint, $options);
    self::validateResponse($response);
    return $response;
  }

  /** @param "GET"|"POST"|"PUT"|"PATCH"|"DELETE" $method */
  private function makeRawRequest(string $method, string $endpoint, array $options = []): ResponseInterface
  {
    $url = $this->baseUrl . $endpoint;
    $options['headers'] = ($options['headers'] ?? []) + $this->credentials->getAuthHeaders();
    return $this->httpClient->request($method, $url, $options);
  }

  protected function getResponse(string $method, string $endpoint, array $options = []): array
  {
    return $this->makeRequest($method, $endpoint, $options)->toArray();
  }

  private static function validateResponse(ResponseInterface $response): void
  {
    $code = $response->getStatusCode();
    if ($code >= 500) {
      throw new HttpException\ServerException($response);
    }
    if ($code >= 400) {
      throw new HttpException\ClientException($response);
    }
    if ($code >= 300) {
      throw new HttpException\RedirectionException($response);
    }
  }
}
