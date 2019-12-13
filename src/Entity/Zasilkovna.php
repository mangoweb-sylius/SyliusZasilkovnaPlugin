<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Table(name="mango_zasilkovna")
 * @ORM\Entity
 */
class Zasilkovna implements ResourceInterface, ZasilkovnaInterface
{
	/**
	 * @var int|null
	 * @ORM\Id
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected $id;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $name;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $nameStreet;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $place;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $street;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $city;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $zip;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $country;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $currency;

	/**
	 * @var bool|null
	 *
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $wheelchairAccessible;

	/**
	 * @var float|null
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $latitude;

	/**
	 * @var float|null
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $longitude;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $url;

	/**
	 * @var bool|null
	 *
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $dressingRoom;

	/**
	 * @var bool|null
	 *
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $claimAssistant;

	/**
	 * @var bool|null
	 *
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $packetConsignment;

	/**
	 * @var int|null
	 *
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $maxWeight;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $region;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $district;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $labelRouting;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $labelName;

	/**
	 * @var array
	 *
	 * @ORM\Column(type="json_array", nullable=true)
	 */
	protected $photos;

	/**
	 * @var \stdClass
	 *
	 * @ORM\Column(type="json_array", nullable=true)
	 */
	protected $openingHours;

	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $createdAt;

	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $updateAt;

	/**
	 * @var \DateTime|null
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $disabledAt;

	public function __toString(): string
	{
		return $this->getNameStreet() . ' (' . $this->getPlace() . ')';
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(?string $name): void
	{
		$this->name = $name;
	}

	public function getNameStreet(): ?string
	{
		return $this->nameStreet;
	}

	public function setNameStreet(?string $nameStreet): void
	{
		$this->nameStreet = $nameStreet;
	}

	public function getPlace(): ?string
	{
		return $this->place;
	}

	public function setPlace(?string $place): void
	{
		$this->place = $place;
	}

	public function getStreet(): ?string
	{
		return $this->street;
	}

	public function setStreet(?string $street): void
	{
		$this->street = $street;
	}

	public function getCity(): ?string
	{
		return $this->city;
	}

	public function setCity(?string $city): void
	{
		$this->city = $city;
	}

	public function getZip(): ?string
	{
		return $this->zip;
	}

	public function setZip(?string $zip): void
	{
		$this->zip = $zip;
	}

	public function getCountry(): ?string
	{
		return $this->country;
	}

	public function setCountry(?string $country): void
	{
		$this->country = $country;
	}

	public function getCurrency(): ?string
	{
		return $this->currency;
	}

	public function setCurrency(?string $currency): void
	{
		$this->currency = $currency;
	}

	public function getWheelchairAccessible(): ?bool
	{
		return $this->wheelchairAccessible;
	}

	public function setWheelchairAccessible(?bool $wheelchairAccessible): void
	{
		$this->wheelchairAccessible = $wheelchairAccessible;
	}

	public function getLatitude(): ?float
	{
		return $this->latitude;
	}

	public function setLatitude(?float $latitude): void
	{
		$this->latitude = $latitude;
	}

	public function getLongitude(): ?float
	{
		return $this->longitude;
	}

	public function setLongitude(?float $longitude): void
	{
		$this->longitude = $longitude;
	}

	public function getUrl(): ?string
	{
		return $this->url;
	}

	public function setUrl(?string $url): void
	{
		$this->url = $url;
	}

	public function getDressingRoom(): ?bool
	{
		return $this->dressingRoom;
	}

	public function setDressingRoom(?bool $dressingRoom): void
	{
		$this->dressingRoom = $dressingRoom;
	}

	public function getClaimAssistant(): ?bool
	{
		return $this->claimAssistant;
	}

	public function setClaimAssistant(?bool $claimAssistant): void
	{
		$this->claimAssistant = $claimAssistant;
	}

	public function getPacketConsignment(): ?bool
	{
		return $this->packetConsignment;
	}

	public function setPacketConsignment(?bool $packetConsignment): void
	{
		$this->packetConsignment = $packetConsignment;
	}

	public function getMaxWeight(): ?int
	{
		return $this->maxWeight;
	}

	public function setMaxWeight(?int $maxWeight): void
	{
		$this->maxWeight = $maxWeight;
	}

	public function getRegion(): ?string
	{
		return $this->region;
	}

	public function setRegion(?string $region): void
	{
		$this->region = $region;
	}

	public function getDistrict(): ?string
	{
		return $this->district;
	}

	public function setDistrict(?string $district): void
	{
		$this->district = $district;
	}

	public function getLabelRouting(): ?string
	{
		return $this->labelRouting;
	}

	public function setLabelRouting(?string $labelRouting): void
	{
		$this->labelRouting = $labelRouting;
	}

	public function getLabelName(): ?string
	{
		return $this->labelName;
	}

	public function setLabelName(?string $labelName): void
	{
		$this->labelName = $labelName;
	}

	public function getPhotos(): array
	{
		return $this->photos;
	}

	public function setPhotos(array $photos): void
	{
		$this->photos = $photos;
	}

	public function getOpeningHours(): \stdClass
	{
		return $this->openingHours;
	}

	public function setOpeningHours(\stdClass $openingHours): void
	{
		$this->openingHours = $openingHours;
	}

	public function getCreatedAt(): ?\DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?\DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}

	public function getUpdateAt(): ?\DateTime
	{
		return $this->updateAt;
	}

	public function setUpdateAt(?\DateTime $updateAt): void
	{
		$this->updateAt = $updateAt;
	}

	public function getDisabledAt(): ?\DateTime
	{
		return $this->disabledAt;
	}

	public function setDisabledAt(?\DateTime $disabledAt): void
	{
		$this->disabledAt = $disabledAt;
	}
}
