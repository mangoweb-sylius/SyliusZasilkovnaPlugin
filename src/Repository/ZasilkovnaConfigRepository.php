<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Repository;

use Doctrine\ORM\NoResultException;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfigInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ShippingMethodInterface;

class ZasilkovnaConfigRepository extends EntityRepository implements ZasilkovnaConfigRepositoryInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function findOneEnabled(): ?ZasilkovnaConfigInterface
	{
		$queryBuilder = $this->createQueryBuilder('e')
			->from(ShippingMethodInterface::class, 'sm')
			->innerJoin('sm.zasilkovnaConfig', 'c')
			->andWhere('c = e')
			->andWhere('sm.enabled = true')
			->andWhere('c.apiKey IS NOT NULL')
			->setMaxResults(1)
		;

		try {
			return $queryBuilder->getQuery()->getSingleResult();
		} catch (NoResultException $e) {
			return null;
		}
	}
}
