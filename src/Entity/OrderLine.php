<?php

namespace App\Entity;

use App\Repository\OrderLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderLineRepository::class)
 */
class OrderLine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id",referencedColumnName="id")
     */
    private $product;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $count;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $totalPrice;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $discount;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $payablePrice;

    /**
     * @Assert\Type(type="App\Entity\Order")
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderLines")
     * ORM\JoinColumn(name="order_id",referencedColumnName="id")
     */
    private $orders;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getPayablePrice(): ?int
    {
        return $this->payablePrice;
    }

    public function setPayablePrice(int $payablePrice): self
    {
        $this->payablePrice = $payablePrice;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

}
