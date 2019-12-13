<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Page\Shop\Zasilkovna;

use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaInterface;
use Sylius\Behat\Page\Admin\Channel\UpdatePage as BaseUpdatePage;

final class ZasilkovnaPages extends BaseUpdatePage implements ZasilkovnaPagesInterface
{
	public function selectZasilkovnaBranch(ZasilkovnaInterface $zasilkovna): void
	{
		$zasilkovnaSelect = $this->getElement('zasilkovna_select');
		$zasilkovnaSelect->selectOption($zasilkovna->getId());
	}

	public function iSeeZasilkovnaBranchInsteadOfShippingAddress(): bool
	{
		$shippingAddress = $this->getElement('shippingAddress')->getText();

		return false !== strpos($shippingAddress, 'Zásilkovna branch');
	}

	protected function getDefinedElements(): array
	{
		return array_merge(parent::getDefinedElements(), [
			'zasilkovna_select' => '.zasilkovnaSelectDiv select',
			'shippingAddress' => '#sylius-shipping-address',
		]);
	}
}
