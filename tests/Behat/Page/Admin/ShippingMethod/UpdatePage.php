<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Page\Admin\ShippingMethod;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Channel\UpdatePage as BaseUpdatePage;

final class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
	public function changeApiKey(?string $apiKey): void
	{
		$this->getElement('apiKey')->setValue($apiKey);
	}

	public function isSingleResourceOnPage(string $elementName)
	{
		return $this->getElement($elementName)->getValue();
	}

	public function zasilkovnaDownloadButtonIsOnPage(): NodeElement
	{
		return $this->getElement('zasilkovnaDownloadButton');
	}

	public function clickToZasilkovnaDownloadButton(): void
	{
		$this->getElement('zasilkovnaDownloadButton')->click();
	}

	public function iSeeZasilkovnaBranchInsteadOfShippingAddress(): bool
	{
		$shippingAddress = $this->getElement('shippingAddress')->getText();

		return false !== strpos($shippingAddress, 'Zásilkovna branch');
	}

	protected function getDefinedElements(): array
	{
		return array_merge(parent::getDefinedElements(), [
			'apiKey' => '#sylius_shipping_method_zasilkovnaConfig_apiKey',
			'zasilkovnaDownloadButton' => '#zasilkovnaDownloadButton',
			'shippingAddress' => '#shipping-address',
		]);
	}
}
