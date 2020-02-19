<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model;

interface ZasilkovnaShipmentInterface
{
	public function getZasilkovna(): ?array;

	public function setZasilkovna(?array $zasilkovna): void;
}
