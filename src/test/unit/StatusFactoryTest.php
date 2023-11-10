<?php

namespace Tests\unit;

use App\Domain\Transaction\CancelledStatus;
use App\Domain\Transaction\StatusEnum;
use App\Domain\Transaction\StatusFactory;
use App\Domain\Transaction\Transaction;
use Exception;
use PHPUnit\Framework\TestCase;

class StatusFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testStart()
    {
        $transaction = Transaction::create(amount: 100,senderId: 1,receiverId: 2);
        $status = StatusFactory::create($transaction, StatusEnum::InProgress);
        $this->assertEquals($status->value, StatusEnum::InProgress->value);
    }

    public function testFinish()
    {
        $transaction = Transaction::create(amount: 100,senderId: 1,receiverId: 2);
        $status = StatusFactory::create($transaction, StatusEnum::Completed);
        $this->assertEquals($status->value, StatusEnum::Completed->value);
    }

    public function testCancel()
    {
        $transaction = Transaction::create(amount: 100,senderId: 1,receiverId: 2);
        $status = StatusFactory::create($transaction, StatusEnum::Cancelled);
        $this->assertEquals($status->value, StatusEnum::Cancelled->value);
    }
}