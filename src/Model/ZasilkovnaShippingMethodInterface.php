<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model;

use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfigInterface;

interface ZasilkovnaShippingMethodInterface
{
	public function getZasilkovnaConfig(): ?ZasilkovnaConfigInterface;

	public function setZasilkovnaConfig(?ZasilkovnaConfigInterface $zasilkovnaConfig): void;
}
