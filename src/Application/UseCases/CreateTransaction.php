<?php

namespace App\Application\UseCases;

use App\Application\Repository\TransactionRepository;
use App\Application\UseCases\DTO\MailerSendInput;
use App\Application\UseCases\DTO\ProcessTransactionInput;
use App\Application\UseCases\DTO\TransactionInput;
use App\Application\UseCases\DTO\TransactionOutput;
use App\Domain\Transaction\Transaction;
use App\Infra\DI\Registry;
use App\Infra\Gateway\MailerGateway;
use App\Infra\Gateway\TransactionGateway;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateTransaction
{
    public function __construct(
        public TransactionRepository $transactionRepository,
        public TransactionGateway    $transactionGateway,
        public MailerGateway    $mailerGateway
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(TransactionInput $input): TransactionOutput
    {
        $sender = Registry::getInstance()->get("accountRepository")->get($input->senderId);
        if (!$sender) throw new BadRequestException("Sender does not exists", 400);
        if (!$sender->isUserAllowedToTransfer()) throw new BadRequestException("Just common users can do transfers.", 400);
        $receiver = Registry::getInstance()->get("accountRepository")->get($input->receiverId);
        if (!$receiver) throw new BadRequestException("Receiver do not exists", 400);
        if ($sender->id === $receiver->id) throw new BadRequestException("You can not send money to yourself", 400);
        if (!$sender->isBalanceGreaterThenAmountToTransfer($input->amount)) throw new BadRequestException("You can not do this transfer. No balance enough", 400);
        $transaction = Transaction::create($input->amount, $sender->id, $receiver->id);
        $transactionId = $this->transactionRepository->save($transaction);
        $transaction = Transaction::restore($transaction->amount, $transaction->senderId, $transaction->receiverId, $transaction->timestamp, $transaction->status->value, $transactionId);
        $sender->decreaseBalance($input->amount);
        $transactionResponse = $this->transactionGateway->process(new ProcessTransactionInput());
        if (!$transactionResponse->success) {
            $transaction->cancel();
            $this->transactionRepository->update($transaction);
            $sender->increaseBalance($input->amount);
            Registry::getInstance()->get("accountRepository")->update($sender);
            return new TransactionOutput(amount: $input->amount, senderId: $input->senderId, receiverId: $input->receiverId, timestamp: time());
        }
        $transaction->finish();
        $receiver->increaseBalance($input->amount);
        $this->transactionRepository->update($transaction);
        Registry::getInstance()->get("accountRepository")->update($sender);
        Registry::getInstance()->get("accountRepository")->update($receiver);
        $this->mailerGateway->send(new MailerSendInput(
            "vinidiax@gmail.com",
            "test",
            "test"
        ));
        return new TransactionOutput(amount: $input->amount, senderId: $input->senderId, receiverId: $input->receiverId, timestamp: time());


    }
}