<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Page\Shop\Zasilkovna;

use Sylius\Behat\Page\Admin\Channel\UpdatePageInterface as BaseUpdatePageInterface;

interface ZasilkovnaPagesInterface extends BaseUpdatePageInterface
{
	public function selectZasilkovnaBranch(array $zasilkovna): void;

	public function iSeeZasilkovnaBranchInsteadOfShippingAddress(): bool;
}
