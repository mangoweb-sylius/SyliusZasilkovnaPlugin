<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException;
use Sylius\Behat\Context\Ui\Shop\Checkout\CheckoutShippingContext;
use Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Page\Shop\Zasilkovna\ZasilkovnaPagesInterface;
use Webmozart\Assert\Assert;

final class ManagingZasilkovnaContext implements Context
{
	/** @var ZasilkovnaPagesInterface */
	private $zasilkovnaPages;

	/** @var CheckoutShippingContext */
	private $checkoutShippingContext;

	public function __construct(
		ZasilkovnaPagesInterface $zasilkovnaPages,
		CheckoutShippingContext $checkoutShippingContext
	) {
		$this->zasilkovnaPages = $zasilkovnaPages;
		$this->checkoutShippingContext = $checkoutShippingContext;
	}

	/**
	 * @Then I should not be able to go to the payment step again
	 */
	public function iShouldNotBeAbleToGoToThePaymentStepAgain()
	{
		Assert::throws(function () {
			$this->checkoutShippingContext->iShouldBeAbleToGoToThePaymentStepAgain();
		}, UnexpectedPageException::class);
	}

	/**
	 * @Then I select :zasilkovnaName Zásilkovna branch
	 */
	public function iSelectZasilkovnaBranch(string $zasilkovnaName)
	{
		$this->zasilkovnaPages->selectZasilkovnaBranch(['id' => 1, 'place' => $zasilkovnaName]);
	}

	/**
	 * @Given I see Zásilkovna branch instead of shipping address
	 */
	public function iSeeZasilkovnaBranchInsteadOfShippingAddress()
	{
		Assert::true($this->zasilkovnaPages->iSeeZasilkovnaBranchInsteadOfShippingAddress());
	}
}
