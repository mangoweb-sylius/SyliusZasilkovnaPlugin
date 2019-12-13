<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model;

use Doctrine\ORM\Mapping as ORM;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaInterface;

trait ZasilkovnaShipmentTrait
{
	/**
	 * @var ZasilkovnaInterface|null
	 * @ORM\ManyToOne(targetEntity="MangoSylius\SyliusZasilkovnaPlugin\Entity\Zasilkovna")
	 */
	private $zasilkovna;

	public function getZasilkovna(): ?ZasilkovnaInterface
	{
		return $this->zasilkovna;
	}

	public function setZasilkovna(?ZasilkovnaInterface $zasilkovna): void
	{
		$this->zasilkovna = $zasilkovna;
	}
}
