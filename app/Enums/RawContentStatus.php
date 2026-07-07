<?php

namespace App\Enums;

enum RawContentStatus:string
{
    case Pending = 'pending';
    case Processed = 'processed';
    case Completed = 'completed';
    case Failed = 'failed';
}
