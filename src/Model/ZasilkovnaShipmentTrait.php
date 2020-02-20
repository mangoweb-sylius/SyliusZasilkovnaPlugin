<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait ZasilkovnaShipmentTrait
{
	/**
	 * @var array|null
	 *
	 * @ORM\Column(type="json", nullable=true)
	 */
	private $zasilkovna;

	public function getZasilkovna(): ?array
	{
		return $this->zasilkovna;
	}

	public function setZasilkovna(?array $zasilkovna): void
	{
		$this->zasilkovna = $zasilkovna;
	}
}
