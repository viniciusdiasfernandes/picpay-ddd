<?php

namespace Payment\Domain;

enum StatusEnum: string
{
    case Started = "started";
    case InProgress = "in_progress";
    case Cancelled = "canceled";
    case Completed = "completed";
}
