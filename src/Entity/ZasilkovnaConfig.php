<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Table(name="mango_zasilkovna_config")
 * @ORM\Entity
 */
class ZasilkovnaConfig implements ResourceInterface, ZasilkovnaConfigInterface
{
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected $id;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $apiKey;

	/**
	 * @var string|null
	 * @ORM\Column(nullable=true, type="string")
	 */
	private $senderLabel;

	/**
	 * @var string|null
	 * @ORM\Column(nullable=true, type="string")
	 */
	private $carrierId;

	/**
	 * @var string|null
	 * @ORM\Column(nullable=true, type="string")
	 */
	private $optionCountry;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getOptionCountry(): ?string
	{
		return $this->optionCountry;
	}

	public function setOptionCountry(?string $optionCountry): void
	{
		$this->optionCountry = $optionCountry;
	}

	public function getApiKey(): ?String
	{
		return $this->apiKey;
	}

	public function setApiKey(?String $apiKey): void
	{
		$this->apiKey = $apiKey;
	}

	public function getSenderLabel(): ?string
	{
		return $this->senderLabel;
	}

	public function setSenderLabel(?string $senderLabel): void
	{
		$this->senderLabel = $senderLabel;
	}

	public function getCarrierId(): ?string
	{
		return $this->carrierId;
	}

	public function setCarrierId(?string $carrierId): void
	{
		$this->carrierId = $carrierId;
	}
}
