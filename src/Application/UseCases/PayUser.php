<?php

namespace App\Application\UseCases;

use App\Application\Repository\PaymentRepository;
use App\Application\Repository\UserRepository;
use App\Application\UseCases\DTO\ProcessPaymentInput;
use App\Application\UseCases\DTO\PayUserInput;
use App\Application\UseCases\DTO\PayUserOutput;
use App\Domain\Payment\Payment;
use App\Infra\Gateway\PaymentGateway;
use Exception;

readonly class PayUser
{
    public function __construct(
        public UserRepository    $userRepository,
        public PaymentRepository $paymentRepository,
        public PaymentGateway    $paymentGateway
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(PayUserInput $input): PayUserOutput
    {
        $sender = $this->userRepository->get($input->senderId);
        if (!$sender) throw new Exception("Sender do not exists.");
        if (!$sender->isUserAllowedToTransfer()) throw new Exception("Just common users can do transfers.");
        $receiver = $this->userRepository->get($input->receiverId);
        if (!$receiver) throw new Exception("Receiver do not exists.");
        if ($sender->id === $receiver->id) throw new Exception("You can not send money to yourself.");
        if (!$sender->isBalanceGreaterThenAmountToTransfer($input->amount)) throw new Exception("You can not do this transfer. No balance enough");
        $payment = Payment::create($input->amount, $sender->id, $receiver->id);
        $paymentId = $this->paymentRepository->save($payment);
        $payment = Payment::restore($payment->amount, $payment->senderId, $payment->receiverId, $payment->timestamp, $payment->status->value, $paymentId);
        $sender->decreaseBalance($input->amount);
        $paymentResponse = $this->paymentGateway->process(new ProcessPaymentInput());
        if (!$paymentResponse->success) {
            $payment->cancel();
            $this->paymentRepository->update($payment);
            $sender->increaseBalance($input->amount);
            $this->userRepository->update($sender);
            return new PayUserOutput(amount: $input->amount, senderId: $input->senderId, receiverId: $input->receiverId, timestamp: time());
        }
        $payment->finish();
        $receiver->increaseBalance($input->amount);
        $this->paymentRepository->update($payment);
        $this->userRepository->update($sender);
        $this->userRepository->update($receiver);
        return new PayUserOutput(amount: $input->amount, senderId: $input->senderId, receiverId: $input->receiverId, timestamp: time());


    }
}