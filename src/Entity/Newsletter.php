<?php

namespace VladFilimon\MultiNewsletterPlugin\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\User\ShopUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Entity(repositoryClass=VladFilimon\MultiNewsletterPlugin\Repository\NewsletterRepository::class)
 * @ORM\Table(name="newsletter")
 */
#[ApiResource]
class Newsletter implements ResourceInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\ManyToMany(targetEntity=ShopUser::class, mappedBy="newsletters")
     * @ORM\JoinTable(name="newsletter_shopuser")
     */
    private $shopUsers;

    public function __construct()
    {
        $this->shopUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return ShopUser[]
     */
    public function getShopUsers(): Collection
    {
        return $this->shopUsers;
    }

    public function addShopUser(ShopUser $shopUser): self
    {
        if (!$this->shopUsers->contains($shopUser)) {
            $this->shopUsers[] = $shopUser;
        }

        return $this;
    }

    public function removeShopUser(ShopUser $shopUser): self
    {
        $this->shopUsers->removeElement($shopUser);

        return $this;
    }
}
