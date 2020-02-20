<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Page\Admin\ShippingMethod;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Channel\UpdatePageInterface as BaseUpdatePageInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface
{
	public function isSingleResourceOnPage(string $elementName);

	public function changeApiKey(?string $apiKey): void;

	public function changeInput(string $elementName, ?string $value): void;

	public function zasilkovnaDownloadButtonIsOnPage(): NodeElement;

	public function iSeeZasilkovnaBranchInsteadOfShippingAddress(): bool;
}
