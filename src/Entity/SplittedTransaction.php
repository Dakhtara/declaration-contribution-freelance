<?php

namespace App\Entity;

use App\Model\SplittedTransactionInterface;
use App\Model\TransactionInterface;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'splitted_transaction')]
class SplittedTransaction implements SplittedTransactionInterface
{
    #[Id]
    #[Column(name: 'id', type: 'integer')]
    #[GeneratedValue]
    private $id;

    #[Column(name: 'date', type: 'datetime')]
    private \DateTimeInterface $date;

    #[Column(name: 'amount', type: 'integer')]
    private int $amount;

    #[ManyToOne(targetEntity: Transaction::class, inversedBy: 'splittedTransaction')]
    #[JoinColumn(name: 'app_transaction', nullable: false)]
    private TransactionInterface $transaction;

    #[Column(name: 'counted', type: 'boolean', nullable: true)]
    private ?bool $isCounted;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setDate(\DateTimeInterface $dateTime): self
    {
        $this->date = $dateTime;

        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function setTransaction(TransactionInterface $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function setIsCounted(?bool $isCounted): self
    {
        $this->isCounted = $isCounted;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function isCounted(): bool
    {
        return $this->isCounted ?? false;
    }

    public function getTransaction(): TransactionInterface
    {
        return $this->transaction;
    }
}
