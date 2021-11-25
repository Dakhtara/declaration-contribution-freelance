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
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity]
#[Table(name: 'app_transaction')]
class Transaction implements TransactionInterface
{
    public const TYPE_CREDIT = 'credit';
    public const TYPE_DEBIT = 'debit';

    #[Id]
    #[Column(name: 'id', type: 'integer')]
    #[GeneratedValue]
    #[Groups('read:transaction')]
    private $id;

    #[Column(name: 'type', type: 'string', length: 30)]
    #[Groups('read:transaction')]
    private string $type;

    #[Column(name: 'label', type: 'string', length: 255)]
    #[Groups('read:transaction')]
    private string $label;

    #[Column(name: 'price', type: 'integer')]
    #[Groups('read:transaction')]
    private int $price;

    #[Column(name: 'datetime', type: 'datetime')]
    #[Groups('read:transaction')]
    private \DateTimeInterface $dateTime;

    #[Column(name: 'slices', type: 'integer', nullable: true)]
    #[Groups('read:transaction')]
    private ?int $slices = null;

    /**
     * @var Collection|SplittedTransactionInterface[]
     */
    #[OneToMany(mappedBy: 'transaction', targetEntity: SplittedTransaction::class, cascade: ['persist'], orphanRemoval: true)]
    #[OrderBy(['date' => 'ASC'])]
    #[Groups('read:transaction')]
    private Collection $splittedTransaction;

    #[ManyToMany(targetEntity: User::class, mappedBy: 'transactions')]
    private $user;

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

    public function getDate(): \DateTimeInterface
    {
        return $this->dateTime;
    }

    public function getDateTime(): \DateTimeInterface
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
    public function getSplittedTransaction(): Collection
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

    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function addSplittedTransaction(SplittedTransactionInterface $splittedTransaction): self
    {
        if (!$this->splittedTransaction->contains($splittedTransaction)) {
            $this->splittedTransaction->add($splittedTransaction);
            $splittedTransaction->setTransaction($this);
        }

        return $this;
    }

    public function removeSplittedTransaction(SplittedTransactionInterface $splittedTransaction): self
    {
        if ($this->splittedTransaction->contains($splittedTransaction)) {
            $this->splittedTransaction->removeElement($splittedTransaction);
            $splittedTransaction->setTransaction(null);
        }

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
