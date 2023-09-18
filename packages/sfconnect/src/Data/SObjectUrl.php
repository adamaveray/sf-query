<?php
declare(strict_types=1);

namespace Averay\SfConnect\Data;

enum SObjectUrl: string
{
  case SObject = 'sobject';
  case Describe = 'describe';
  case RowTemplate = 'rowTemplate';
  case Layouts = 'layouts';
  case CompactLayouts = 'compactLayouts';
}
