<?php
declare(strict_types=1);

namespace Averay\SfConnect\Authentication\Agent;

use Averay\SfConnect\Authentication\Credentials\SessionCredentials;
use Averay\SfConnect\Config\Instance;
use Averay\SfConnect\Config\InstanceInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class SoapAuthAgent implements AuthAgentInterface
{
  private const LOGIN_URL = 'https://login.salesforce.com';

  private HttpClientInterface $httpClient;
  private string $endpointUrl;

  public function __construct(string $version, ?HttpClientInterface $httpClient = null)
  {
    $this->httpClient = $httpClient ?? HttpClient::create();
    $this->endpointUrl = self::LOGIN_URL . '/services/Soap/u/' . urlencode($version);
  }

  /** @return array{ instance: InstanceInterface, credentials: SessionCredentials } */
  public function login(
    string $username,
    #[\SensitiveParameter] string $password,
    #[\SensitiveParameter] ?string $securityToken = null,
  ): array {
    $payload = self::buildSoapEnvelope(
      null,
      self::buildXml(
        <<<'XML'
        <login xmlns="urn:partner.soap.sforce.com">
          <username>{{username}}</username>
          <password>{{password}}</password>
        </login>
        XML
        ,
        [
          'username' => $username,
          'password' => $password . ($securityToken ?? ''),
        ],
      ),
    );

    $response = $this->makeRequest($payload);
    $now = new \DateTimeImmutable();
    $authData = $response['soapenv_Body']['loginResponse']['result'];

    return [
      'instance' => new Instance($authData['serverUrl'], self::convertValue($authData['sandbox'], false)),
      'credentials' => new SessionCredentials(
        sessionId: $authData['sessionId'],
        userId: $authData['userId'],
        userInfo: array_map(static fn(mixed $value): mixed => self::convertValue($value), $authData['userInfo']),
        passwordExpired: self::convertValue($authData['passwordExpired'], false),
        dateCreated: $now,
      ),
    ];
  }

  public function logout(SessionCredentials $credentials): void
  {
    $payload = self::buildSoapEnvelope(
      null,
      self::buildXml(
        <<<'XML'
        <SessionHeader xmlns="urn:partner.soap.sforce.com">
          <sessionId>{{token}}</sessionId>
        </SessionHeader>
        XML
        ,
        ['sessionId' => $credentials->sessionId],
      ),
    );

    $this->makeRequest($payload);
  }

  private function makeRequest(string $requestBody): array
  {
    $response = $this->httpClient->request('POST', $this->endpointUrl, [
      'headers' => [
        'Content-Type' => 'text/xml',
        'SOAPAction' => '""',
      ],
      'body' => $requestBody,
    ]);
    $responseBody = $response->getContent();
    return self::parseXml($responseBody);
  }

  private static function buildSoapEnvelope(?string $header, string $body): string
  {
    return <<<XML
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
      <soapenv:Header>{$header}</soapenv:Header>
      <soapenv:Body>{$body}</soapenv:Body>
    </soapenv:Envelope>
    XML;
  }

  private static function buildXml(string $xml, array $tokens): string
  {
    return preg_replace_callback(
      '~\{\{(\w+)}}~',
      static function (array $matches) use ($tokens): string {
        $key = $matches[1];
        if (!\array_key_exists($key, $tokens)) {
          throw new \OutOfBoundsException('Undefined parameter "' . $key . '"');
        }
        return htmlspecialchars($tokens[$key], \ENT_QUOTES);
      },
      $xml,
    );
  }

  private static function parseXml(string $xml): array|string
  {
    $xml = preg_replace('~<(/?\w+):(\w+)~', '<$1_$2', $xml);
    return \json_decode(
      \json_encode(new \SimpleXMLElement($xml), \JSON_THROW_ON_ERROR),
      true,
      512,
      \JSON_THROW_ON_ERROR,
    );
  }

  private static function convertValue(mixed $value, mixed $default = null): mixed
  {
    return match ($value) {
      'true' => true,
      'false' => false,
      default => $default ?? $value,
    };
  }
}
