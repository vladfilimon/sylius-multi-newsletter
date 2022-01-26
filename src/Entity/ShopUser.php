<?php

declare(strict_types=1);

namespace VladFilimon\MultiNewsletterPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ShopUser as BaseShopUser;
use Sylius\Component\Core\Model\ShopUserInterface;
use VladFilimon\MultiNewsletterPlugin\Entity\Newsletter;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_shop_user")
 */

class ShopUser extends BaseShopUser implements ShopUserInterface
{
    /**
     * @ORM\ManyToMany(targetEntity="VladFilimon\MultiNewsletterPlugin\Entity\Newsletter", mappedBy="shopUsers" , fetch="LAZY", cascade={"persist"})
     * @ORM\JoinTable(name="newsletter_shopuser")
     */
    private $newsletters;

    public function __construct()
    {
        parent::__construct();

        $this->newsletters = new ArrayCollection();
    }


    public function addNewsletter(Newsletter $newsletter)
    {
        if (!$this->newsletters->contains($newsletter)) {
            $this->newsletters->add($newsletter);
        }
    }

    public function removeNewsletter(Newsletter $newsletter)
    {
        $this->newsletters->remove($newsletter);
    }


    /**
     * @return ArrayCollection|Newsletter[]
     */
    public function getNewsletters()
    {
        return $this->newsletters;
    }


}
