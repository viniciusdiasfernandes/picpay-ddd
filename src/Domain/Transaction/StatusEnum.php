<?php

namespace App\Domain\Transaction;

enum StatusEnum: string
{
    case Started = "started";
    case InProgress = "in_progress";
    case Cancelled = "cancelled";
    case Completed = "completed";
}
