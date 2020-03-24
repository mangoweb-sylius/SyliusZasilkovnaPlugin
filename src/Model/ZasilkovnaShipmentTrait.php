<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait ZasilkovnaShipmentTrait
{
	/**
	 * @var array<mixed>|null
	 *
	 * @ORM\Column(type="json", nullable=true)
	 */
	private $zasilkovna;

	/**
	 * @return array<mixed>|null
	 */
	public function getZasilkovna(): ?array
	{
		return $this->zasilkovna;
	}

	/**
	 * @param array<mixed>|null $zasilkovna
	 */
	public function setZasilkovna(?array $zasilkovna): void
	{
		$this->zasilkovna = $zasilkovna;
	}
}
