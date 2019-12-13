<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model;

use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaInterface;

interface ZasilkovnaShipmentInterface
{
	public function getZasilkovna(): ?ZasilkovnaInterface;

	public function setZasilkovna(?ZasilkovnaInterface $zasilkovna): void;
}
