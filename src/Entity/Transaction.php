<?php

namespace App\Entity;

use App\Model\SplittedTransactionInterface;
use App\Model\TransactionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'app_transaction')]
class Transaction implements TransactionInterface
{
    const TYPE_CREDIT = 'credit';
    const TYPE_DEBIT = 'debit';

    #[Id]
    #[Column(name: 'id', type: 'integer')]
    #[GeneratedValue]
    private $id;

    #[Column(name: 'type', type: 'string', length: 30)]
    private string $type;

    #[Column(name: 'price', type: 'integer')]
    private int $price;

    #[Column(name: 'datetime', type: 'datetime')]
    private \DateTimeInterface $dateTime;

    #[Column(name: 'slices', type: 'integer', nullable: true)]
    private ?int $slices;

    /**
     * @var Collection|SplittedTransactionInterface[]
     */
    #[OneToMany(targetEntity: SplittedTransaction::class, mappedBy: 'transaction')]
    private $splittedTransaction;

    public function __construct()
    {
        $this->splittedTransaction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDate(): \DateTime
    {
        return $this->dateTime;
    }

    public function getSlices(): ?int
    {
        return $this->slices;
    }

    /**
     * @return SplittedTransactionInterface[]|array
     */
    public function getSplittedTransaction(): array
    {
        return $this->splittedTransaction;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function setSlices(?int $slices): self
    {
        $this->slices = $slices;

        return $this;
    }

    /**
     * @param SplittedTransactionInterface[]|Collection $splittedTransaction
     */
    public function setSplittedTransaction(Collection $splittedTransaction): self
    {
        $this->splittedTransaction = $splittedTransaction;

        return $this;
    }
}
