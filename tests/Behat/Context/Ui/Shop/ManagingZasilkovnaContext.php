<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Repository\ZasilkovnaRepositoryInterface;
use Sylius\Behat\Context\Ui\Shop\Checkout\CheckoutShippingContext;
use Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Page\Shop\Zasilkovna\ZasilkovnaPagesInterface;
use Webmozart\Assert\Assert;

final class ManagingZasilkovnaContext implements Context
{
	/**
	 * @var ZasilkovnaPagesInterface
	 */
	private $zasilkovnaPages;
	/**
	 * @var CheckoutShippingContext
	 */
	private $checkoutShippingContext;
	/**
	 * @var ZasilkovnaRepositoryInterface
	 */
	private $zasilkovnaRepository;

	public function __construct(
		ZasilkovnaPagesInterface $zasilkovnaPages,
		CheckoutShippingContext $checkoutShippingContext,
		ZasilkovnaRepositoryInterface $zasilkovnaRepository
	) {
		$this->zasilkovnaPages = $zasilkovnaPages;
		$this->checkoutShippingContext = $checkoutShippingContext;
		$this->zasilkovnaRepository = $zasilkovnaRepository;
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
		$zasilkovna = $this->zasilkovnaRepository->findOneBy(['name' => $zasilkovnaName]);

		assert($zasilkovna instanceof ZasilkovnaInterface);

		$this->zasilkovnaPages->selectZasilkovnaBranch($zasilkovna);
	}

	/**
	 * @Then I can not see :zasilkovnaName Zásilkovna branch in the list of Zásilkovna branches
	 */
	public function iCanNotSeeZasilkovnaBranchInTheListOfZasilkovnaBranches(string $zasilkovnaName)
	{
		$zasilkovna = $this->zasilkovnaRepository->findOneBy(['name' => $zasilkovnaName]);

		assert($zasilkovna instanceof ZasilkovnaInterface);

		Assert::throws(function () use ($zasilkovna) {
			$this->zasilkovnaPages->selectZasilkovnaBranch($zasilkovna);
		}, ElementNotFoundException::class);
	}

	/**
	 * @Given I see Zásilkovna branch instead of shipping address
	 */
	public function iSeeZasilkovnaBranchInsteadOfShippingAddress()
	{
		Assert::true($this->zasilkovnaPages->iSeeZasilkovnaBranchInsteadOfShippingAddress());
	}
}
