<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Page\Admin\ShippingMethod\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingShippingMethodContext implements Context
{
	/**
	 * @var UpdatePageInterface
	 */
	private $updatePage;
	/**
	 * @var NotificationCheckerInterface
	 */
	private $notificationChecker;

	public function __construct(
		UpdatePageInterface $updatePage,
		NotificationCheckerInterface $notificationChecker
	) {
		$this->updatePage = $updatePage;
		$this->notificationChecker = $notificationChecker;
	}

	/**
	 * @When I change Zásilkovna Sender label to :arg1
	 */
	public function iChangeZasilkovnaSenderLabelTo($arg1)
	{
		$this->updatePage->changeInput('senderLabel', $arg1);
	}

	/**
	 * @Then the Zásilkovna Sender label for this shipping method should be :arg1
	 */
	public function theZasilkovnaSenderLabelForThisShippingMethodShouldBe($arg1)
	{
		Assert::eq($this->updatePage->isSingleResourceOnPage('senderLabel'), $arg1);
	}

	/**
	 * @When I change Zásilkovna Carrier pickup point to :arg1
	 */
	public function iChangeZasilkovnaCarrierIdTo($arg1)
	{
		$this->updatePage->changeInput('carrierId', $arg1);
	}

	/**
	 * @Then the Zásilkovna Carrier pickup point for this shipping method should be :arg1
	 */
	public function theZasilkovnaCarrierIdForThisShippingMethodShouldBe($arg1)
	{
		Assert::eq($this->updatePage->isSingleResourceOnPage('carrierId'), $arg1);
	}

	/**
	 * @When I change Zásilkovna api key to :apiKey
	 */
	public function iChangeZasilkovnaApiKeyTo(string $apiKey)
	{
		$this->updatePage->changeApiKey($apiKey);
	}

	/**
	 * @Then the Zásilkovna api key for this shipping method should be :apiKey
	 */
	public function theZasilkovnaApiKeyForThisShippingMethodShouldBe(string $apiKey)
	{
		Assert::eq($this->updatePage->isSingleResourceOnPage('apiKey'), $apiKey);
	}

	/**
	 * @Then it should be shipped to Zásilkovna branch
	 */
	public function itShouldBeShippedToZasilkovnaBranch()
	{
		Assert::true($this->updatePage->iSeeZasilkovnaBranchInsteadOfShippingAddress());
	}
}
