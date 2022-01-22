<?php

namespace VladFilimon\MultiNewsletterPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use VladFilimon\MultiNewsletterPlugin\Entity\Newsletter;

/**
 * @method Newsletter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Newsletter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Newsletter[]    findAll()
 * @method Newsletter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterRepository extends EntityRepository
{
    public function findByShopUser($shopUser): array
    {
        return $this
            ->createQueryBuilder('nl')
            ->where(':shopUser MEMBER OF nl.shopUsers')
            ->setParameter('shopUser', $shopUser)
            ->andWhere('nl.enabled = true')
            ->getQuery()
            ->getResult()
            ;
    }
}
