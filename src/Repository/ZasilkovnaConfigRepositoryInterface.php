<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Repository;

use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfigInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ZasilkovnaConfigRepositoryInterface extends RepositoryInterface
{
	public function findOneEnabled(): ?ZasilkovnaConfigInterface;
}
