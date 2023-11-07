<?php

namespace Payment\Application\UserCase;

use Account\Application\Repository\UserRepository;
use Exception;
use Payment\Application\DTO\StartPaymentInput;
use Payment\Application\DTO\StartPaymentOutput;
use Payment\Domain\Payment;

class StartPayment
{
    public function __construct(readonly UserRepository $userRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function execute(StartPaymentInput $input): StartPaymentOutput
    {
        $sender = $this->userRepository->get($input->senderId);
        if(!$sender) throw new Exception("Sender do not exists.");
        if(!$sender->isUserAllowedToTransfer()) throw new Exception("Just common users can do transfers.");
        $receiver = $this->userRepository->get($input->receiverId);
        if(!$receiver) throw new Exception("Receiver do not exists.");
        if($sender->id === $receiver->id) throw new Exception("You can not send money to yourself.");
        if(!$sender->isBalanceGreaterThenAmountToTransfer($input->amount)) throw new Exception("You can not do this transfer. No balance enough");
        $transference = Payment::create($input->amount, $sender, $receiver);
        var_dump($transference);
        exit();
        return new StartPaymentOutput(amount:$input->amount,senderId: $input->senderId, receiverId: $input->receiverId, timestamp:time());
    }
}