<?php

namespace Payment\Domain;

class StatusFactory
{
    public static function crete(Payment $payment, StatusEnum $status)
    {
        if($status === StatusEnum::InProgress) {
            return new InProgressStatus($payment);
        }
        if($status === StatusEnum::Cancelled) {
            return new CancelledStatus($payment);
        }
        if($status === StatusEnum::Completed) {
            return new CompletedStatus($payment);
        }
    }
}