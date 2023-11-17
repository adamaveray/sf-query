<?php
declare(strict_types=1);

namespace Averay\SfConnect;

use Averay\SfConnect\Objects\Record;
use Averay\SfConnect\Objects\SObject;

/**
 * @internal
 * @pure
 */
function getSObjectName(string|SObject $sobject): string
{
  return $sobject instanceof SObject ? $sobject->name : $sobject;
}

/**
 * @internal
 * @pure
 */
function getRecordId(string|Record $record): string
{
  return $record instanceof Record ? $record->Id : $record;
}

/**
 * @param string $url A URL fragment with tokens to be injected as `{tokenName}`
 * @param array<string,mixed> $tokens Keys should match tokens within $url (without surrounding braces), and values must be string-convertable values
 * @return string The original $url with tokens replaced with their URL-encoded equivalents from $tokens
 *
 * @internal
 * @pure
 * @example buildUrlPath('/path/{token}/?q={query}', ['token' => $token, 'query' => $query])
 */
function formatUrl(string $url, array $tokens): string
{
  return preg_replace_callback(
    '~\{([\w-]+?)}~',
    static fn(array $matches): string => urlencode((string) $tokens[$matches[1]]),
    $url,
  );
}

/**
 * @param string $string The raw string for use in a SOQL statement
 * @return string The escaped string safe to insert directly into a SOQL statement
 */
function escapeForSoql(string $string): string
{
  static $reservedChars = '\'\\';

  return "'" . addcslashes($string, $reservedChars) . "'";
}

/**
 * @param string $string The raw string for use in a SOSL statement
 * @return string The escaped string safe to insert directly into a SOSL statement
 */
function escapeForSosl(string $string): string
{
  static $reservedChars = '?&|!{}[]()^~*:\\"\'+-';
  static $quotedPhrasesPattern = '~\b(?:and|or)\b~i';

  $string = addcslashes($string, $reservedChars);

  if (str_contains($string, ' ') || preg_match($quotedPhrasesPattern, $string)) {
    // Must quote entire string
    $string = '"' . $string . '"';
  }

  return $string;
}

/** @return list<string> */
function unserializePicklist(string $string): array
{
  return $string === '' ? [] : explode(';', $string);
}

/** @param list<string> $entries */
function serializePicklist(array $entries): string
{
  return implode(';', $entries);
}
