<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Entity;

interface ZasilkovnaConfigInterface
{
	public function getId(): ?int;

	public function setId(?int $id): void;

	public function getApiKey(): ?String;

	public function setApiKey(?String $apiKey): void;

	public function getSenderLabel(): ?string;

	public function setSenderLabel(?string $senderLabel): void;

	public function getCarrierPickupPoint(): ?string;

	public function setCarrierPickupPoint(?string $carrierPickupPoint): void;
}
