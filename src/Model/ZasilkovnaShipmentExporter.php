<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model;

use MangoSylius\ShipmentExportPlugin\Model\ShipmentExporterInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Model\ShipmentInterface;

class ZasilkovnaShipmentExporter implements ShipmentExporterInterface
{
	/**
	 * @var string[]
	 */
	private $shippingMethodsCodes;

	public function __construct(
		array $shippingMethodsCodes
	) {
		$this->shippingMethodsCodes = $shippingMethodsCodes;
	}

	public function getShippingMethodsCodes(): array
	{
		return $this->shippingMethodsCodes;
	}

	public function getRow(ShipmentInterface $shipment, array $questionsArray): array
	{
		assert($shipment instanceof ZasilkovnaShipmentInterface);

		$order = $shipment->getOrder();
		assert($order !== null);
		$channel = $order->getChannel();
		assert($channel !== null);
		$address = $order->getShippingAddress();
		assert($address !== null);
		$customer = $order->getCustomer();
		assert($customer !== null);

		$shippingMethod = $shipment->getMethod();
		assert($shippingMethod !== null);
		$payment = $order->getPayments()->first();
		assert($payment instanceof PaymentInterface);
		$paymentMethod = $payment->getMethod();
		assert($paymentMethod instanceof PaymentMethodInterface);
		assert($paymentMethod->getGatewayConfig() !== null);

		$isCashOnDelivery = $paymentMethod->getGatewayConfig()->getFactoryName() === 'offline';

		$currencyCode = $order->getCurrencyCode();
		assert($currencyCode !== null);
		$totalAmount = number_format(
			$order->getTotal() / 100,
			0,
			',',
			''
		);

		$weight = 0;
		foreach ($order->getItems() as $item) {
			/** @var OrderItemInterface $item */
			$variant = $item->getVariant();
			if ($variant !== null) {
				$weight += $variant->getWeight();
			}
		}

		$zasilkovnaId = $shipment->getZasilkovna() !== null ? $shipment->getZasilkovna()->getId() : null;

		return [
			/* 1 - version 5 */
			'',

			/* 2 - Číslo obj.* */
			$order->getNumber(),

			/* 3 - Jméno* */
			$address->getFirstName(),

			/* 4 - Příjmení* */
			$address->getLastName(),

			/* 5 - Firma */
			$address->getCompany(),

			/* 6 - E-mail** */
			$customer->getEmail(),

			/* 7 - Mobil** */
			$address->getPhoneNumber(),

			/* 8 - Dobírka */
			$isCashOnDelivery ? $totalAmount : '',

			/* 9 - Měna */
			$currencyCode,

			/* 10 - Hodnota **/
			$totalAmount,

			/* 11 - Hmotnost */
			$weight,

			/* 12 - Cílová pobočka* */
			$zasilkovnaId ?? '',

			/* 13 - Doména e-shopu*** */
			$channel->getHostname(),

			/* 14 - Obsah 18+ */
			'',

			/* 15 - Plánovaný výdej */
			'',

			/* 16 - Ulice */
			$zasilkovnaId ? '' : $address->getStreet(),

			/* 17 - Č. domu */
			'',

			/* 18 - Obec */
			$zasilkovnaId ? '' : $address->getCity(),

			/* 19 - PSČ */
			$zasilkovnaId ? '' : $address->getPostcode(),
		];
	}

	public function getDelimiter(): string
	{
		return ',';
	}

	public function getQuestionsArray(): ?array
	{
		return null;
	}
}
