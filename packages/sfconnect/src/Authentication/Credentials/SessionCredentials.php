<?php
declare(strict_types=1);

namespace Averay\SfConnect\Authentication\Credentials;

final readonly class SessionCredentials implements CredentialsInterface
{
  public function __construct(
    #[\SensitiveParameter] public string $sessionId,
    public string $userId,
    public array $userInfo,
    public bool $passwordExpired,
    public \DateTimeInterface $dateCreated,
  ) {}

  public function getDateExpires(): ?\DateTimeInterface
  {
    $seconds = $this->userInfo['sessionSecondsValid'] ?? null;
    if ($seconds === null) {
      return null;
    }
    return \DateTimeImmutable::createFromInterface($this->dateCreated)->add(new \DateInterval('PT' . $seconds . 'S'));
  }

  public function getAuthHeaders(): array
  {
    return ['Authorization: Bearer ' . $this->sessionId];
  }
}
