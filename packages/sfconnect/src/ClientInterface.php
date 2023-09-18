<?php
declare(strict_types=1);

namespace Averay\SfConnect;

use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ClientInterface extends
  Slices\MetaInterface,
  Slices\OrganizationInterface,
  Slices\QueryingInterface,
  Slices\RecordsInterface,
  Slices\SearchInterface,
  Slices\SObjectsInterface
{
  /**
   * @param "GET"|"POST"|"PUT"|"PATCH"|"DELETE" $method
   * @param string $endpoint The request URL suffix (e.g. for `/services/data/vXX.X/example`, the $endpoint would be `/example`)
   * @param array<string,mixed> $options Options passed to the HttpClientInterface instance
   * @throws ExceptionInterface
   */
  public function makeRequest(string $method, string $endpoint, array $options = []): ResponseInterface;
}
