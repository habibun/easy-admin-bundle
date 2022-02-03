<?php

namespace App\Entity\Order;

use App\Entity\Order;
use App\Entity\Product as OriginalProduct;
use App\Repository\Order\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'order_product')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: OriginalProduct::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $original;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private $order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginal(): ?Product
    {
        return $this->original;
    }

    public function setOriginal(?Product $original): self
    {
        $this->original = $original;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $orderM): self
    {
        $this->order = $orderM;

        return $this;
    }
}
