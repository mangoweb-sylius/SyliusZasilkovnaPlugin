<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Entity;

interface ZasilkovnaInterface
{
	public function __toString(): string;

	public function getId(): ?int;

	public function setId(?int $id): void;

	public function getName(): ?string;

	public function setName(?string $name): void;

	public function getNameStreet(): ?string;

	public function setNameStreet(?string $nameStreet): void;

	public function getPlace(): ?string;

	public function setPlace(?string $place): void;

	public function getStreet(): ?string;

	public function setStreet(?string $street): void;

	public function getCity(): ?string;

	public function setCity(?string $city): void;

	public function getZip(): ?string;

	public function setZip(?string $zip): void;

	public function getCountry(): ?string;

	public function setCountry(?string $country): void;

	public function getCurrency(): ?string;

	public function setCurrency(?string $currency): void;

	public function getWheelchairAccessible(): ?bool;

	public function setWheelchairAccessible(?bool $wheelchairAccessible): void;

	public function getLatitude(): ?float;

	public function setLatitude(?float $latitude): void;

	public function getLongitude(): ?float;

	public function setLongitude(?float $longitude): void;

	public function getUrl(): ?string;

	public function setUrl(?string $url): void;

	public function getDressingRoom(): ?bool;

	public function setDressingRoom(?bool $dressingRoom): void;

	public function getClaimAssistant(): ?bool;

	public function setClaimAssistant(?bool $claimAssistant): void;

	public function getPacketConsignment(): ?bool;

	public function setPacketConsignment(?bool $packetConsignment): void;

	public function getMaxWeight(): ?int;

	public function setMaxWeight(?int $maxWeight): void;

	public function getRegion(): ?string;

	public function setRegion(?string $region): void;

	public function getDistrict(): ?string;

	public function setDistrict(?string $district): void;

	public function getLabelRouting(): ?string;

	public function setLabelRouting(?string $labelRouting): void;

	public function getLabelName(): ?string;

	public function setLabelName(?string $labelName): void;

	public function getPhotos(): array;

	public function setPhotos(array $photos): void;

	public function getOpeningHours(): \stdClass;

	public function setOpeningHours(\stdClass $openingHours): void;

	public function getCreatedAt(): ?\DateTime;

	public function setCreatedAt(?\DateTime $createdAt): void;

	public function getUpdateAt(): ?\DateTime;

	public function setUpdateAt(?\DateTime $updateAt): void;

	public function getDisabledAt(): ?\DateTime;

	public function setDisabledAt(?\DateTime $disabledAt): void;
}
