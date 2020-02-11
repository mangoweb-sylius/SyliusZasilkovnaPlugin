<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model;

use MangoSylius\ShipmentExportPlugin\Model\ShipmentExporterInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Currency\Converter\CurrencyConverter;

class ZasilkovnaShipmentExporter implements ShipmentExporterInterface
{
	/**
	 * @var string[]
	 */
	private $shippingMethodsCodes;

	/**
	 * @var CurrencyConverter
	 */
	private $currencyConverter;

	public function __construct(
		CurrencyConverter $currencyConverter,
		array $shippingMethodsCodes
	) {
		$this->shippingMethodsCodes = $shippingMethodsCodes;
		$this->currencyConverter = $currencyConverter;
	}

	private function convert(int $amount, string $sourceCurrencyCode, string $targetCurrencyCode): int
	{
		return $this->currencyConverter->convert($amount, $sourceCurrencyCode, $targetCurrencyCode);
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

		$targetCurrencyCode = null;
		$decimals = 0;
		if ($shipment->getZasilkovna() !== null && $shipment->getZasilkovna()->getCurrency() !== null) {
			$targetCurrencyCode = $shipment->getZasilkovna()->getCurrency();
			$totalAmount = $this->convert($order->getTotal(), $currencyCode, $targetCurrencyCode);
		} else {
			if ($address->getCountryCode() === 'CZ') {
				$targetCurrencyCode = 'CZK';
				$totalAmount = $this->convert($order->getTotal(), $currencyCode, $targetCurrencyCode);
			} elseif ($address->getCountryCode() === 'SK') {
				$targetCurrencyCode = 'EUR';
				$totalAmount = $this->convert($order->getTotal(), $currencyCode, $targetCurrencyCode);
				$decimals = 2;
			} elseif ($address->getCountryCode() === 'PL') {
				$targetCurrencyCode = 'PLN';
				$totalAmount = $this->convert($order->getTotal(), $currencyCode, $targetCurrencyCode);
			} elseif ($address->getCountryCode() === 'HU') {
				$targetCurrencyCode = 'HUF';
				$totalAmount = $this->convert($order->getTotal(), $currencyCode, $targetCurrencyCode);
			} elseif ($address->getCountryCode() === 'RO') {
				$targetCurrencyCode = 'RON';
				$totalAmount = $this->convert($order->getTotal(), $currencyCode, $targetCurrencyCode);
			} else {
				$totalAmount = null;
			}
		}

		if ($totalAmount !== null) {
			$totalAmount = number_format(
				$totalAmount / 100,
				$decimals,
				'.',
				''
			);
		}

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
			$targetCurrencyCode,

			/* 10 - Hodnota **/
			$totalAmount,

			/* 11 - Hmotnost */
			$weight,

			/* 12 - Cílová pobočka* */
			$zasilkovnaId ?? '',

			/* 13 - Doména e-shopu*** */
			'',

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

	public function getHeaders(): ?array
	{
		return [
			['version 5'],
			[''],
		];
	}
}
