<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Page\Shop\Zasilkovna;

use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaInterface;
use Sylius\Behat\Page\Admin\Channel\UpdatePageInterface as BaseUpdatePageInterface;

interface ZasilkovnaPagesInterface extends BaseUpdatePageInterface
{
	public function selectZasilkovnaBranch(ZasilkovnaInterface $zasilkovna): void;

	public function iSeeZasilkovnaBranchInsteadOfShippingAddress(): bool;
}
