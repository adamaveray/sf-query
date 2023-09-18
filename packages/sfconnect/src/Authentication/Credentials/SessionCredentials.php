<?php
declare(strict_types=1);

namespace Averay\SfConnect\Authentication\Credentials;

readonly final class SessionCredentials implements CredentialsInterface
{
  public function __construct(
    #[\SensitiveParameter] public string $sessionId,
    public string $userId,
    public array $userInfo,
    public bool $passwordExpired,
  ) {
  }

  public function getAuthHeaders(): array
  {
    return ['Authorization: Bearer ' . $this->sessionId];
  }
}
