<?php
declare(strict_types=1);

namespace Averay\SfConnect\Authentication\Credentials;

interface CredentialsInterface
{
  public function getDateExpires(): ?\DateTimeInterface;

  /** @return list<string> */
  public function getAuthHeaders(): array;
}
