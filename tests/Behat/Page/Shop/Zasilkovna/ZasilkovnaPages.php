<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Page\Shop\Zasilkovna;

use Sylius\Behat\Page\Admin\Channel\UpdatePage as BaseUpdatePage;

final class ZasilkovnaPages extends BaseUpdatePage implements ZasilkovnaPagesInterface
{
	public function selectZasilkovnaBranch(array $zasilkovna): void
	{
		$zasilkovnaSelect = $this->getElement('zasilkovna_hidden_input');
		$zasilkovnaSelect->setValue(json_encode($zasilkovna));
	}

	public function iSeeZasilkovnaBranchInsteadOfShippingAddress(): bool
	{
		$shippingAddress = $this->getElement('shippingAddress')->getText();

		return false !== strpos($shippingAddress, 'Zásilkovna branch');
	}

	protected function getDefinedElements(): array
	{
		return array_merge(parent::getDefinedElements(), [
			'zasilkovna_hidden_input' => 'input[type="hidden"][name^="sylius_checkout_select_shipping[shipments][0][zasilkovna_"]',
			'shippingAddress' => '#sylius-shipping-address',
		]);
	}
}
