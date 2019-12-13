<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\Zasilkovna;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfig;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Repository\ZasilkovnaRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;

final class ShippingMethodContext implements Context
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	/**
	 * @var SharedStorageInterface
	 */
	private $sharedStorage;
	/**
	 * @var ZasilkovnaRepositoryInterface
	 */
	private $zasilkovnaRepository;

	public function __construct(
		EntityManagerInterface $entityManager,
		SharedStorageInterface $sharedStorage,
		ZasilkovnaRepositoryInterface $zasilkovnaRepository
	) {
		$this->entityManager = $entityManager;
		$this->sharedStorage = $sharedStorage;
		$this->zasilkovnaRepository = $zasilkovnaRepository;
	}

	/**
	 * @Given /^(this shipping method) has Zásilkovna api key$/
	 */
	public function thisPaymentMethodHasZone(ShippingMethodInterface $shippingMethod)
	{
		assert($shippingMethod instanceof ZasilkovnaShippingMethodInterface);

		$zasilkovnaConfig = new ZasilkovnaConfig();
		$zasilkovnaConfig->setApiKey('zasilkovnaApiKeyFolder');

		$shippingMethod->setZasilkovnaConfig($zasilkovnaConfig);

		$this->entityManager->persist($shippingMethod);
		$this->entityManager->flush();
	}

	/**
	 * @Given the store has Zásilkovna ":zasilkovnaName" with ID ":zasilkovnaId"
	 */
	public function theStoreHasZasilkovnaWithID(string $zasilkovnaName, int $zasilkovnaId)
	{
		$zasilkovna = new Zasilkovna();
		$zasilkovna->setId($zasilkovnaId);
		$zasilkovna->setName($zasilkovnaName);

		$this->entityManager->persist($zasilkovna);
		$this->entityManager->flush();
	}

	/**
	 * @Given the store has Zásilkovna ":zasilkovnaName" with ID ":zasilkovnaId" and country code ":countryCode"
	 */
	public function theStoreHasZasilkovnaWithIDAndCountry(string $zasilkovnaName, int $zasilkovnaId, string $countryCode)
	{
		$zasilkovna = new Zasilkovna();
		$zasilkovna->setId($zasilkovnaId);
		$zasilkovna->setName($zasilkovnaName);
		$zasilkovna->setCountry($countryCode);

		$this->entityManager->persist($zasilkovna);
		$this->entityManager->flush();
	}

	/**
	 * @Given choose Zásilkovna branch ":zasilkovnaName"
	 */
	public function chooseZasilkovnaBranch(string $zasilkovnaName)
	{
		$zasilkovna = $this->zasilkovnaRepository->findOneBy(['name' => $zasilkovnaName]);
		assert($zasilkovna instanceof ZasilkovnaInterface);

		$order = $this->sharedStorage->get('order');
		assert($order instanceof OrderInterface);

		$shipment = $order->getShipments()->last();
		assert($shipment instanceof ZasilkovnaShipmentInterface);
		$shipment->setZasilkovna($zasilkovna);

		$this->entityManager->persist($order);
		$this->entityManager->flush();
	}
}
