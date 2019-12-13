<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model;

use Doctrine\ORM\Mapping as ORM;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfigInterface;

trait ZasilkovnaShippingMethodTrait
{
	/**
	 * @var ZasilkovnaConfigInterface|null
	 * @ORM\OneToOne(targetEntity="MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfig", cascade={"persist"}, fetch="EAGER")
	 */
	private $zasilkovnaConfig;

	public function getZasilkovnaConfig(): ?ZasilkovnaConfigInterface
	{
		return $this->zasilkovnaConfig;
	}

	public function setZasilkovnaConfig(?ZasilkovnaConfigInterface $zasilkovnaConfig): void
	{
		$this->zasilkovnaConfig = $zasilkovnaConfig;
	}
}
