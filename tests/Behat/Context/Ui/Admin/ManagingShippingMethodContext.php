<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ElementNotFoundException;
use Sylius\Behat\NotificationType;
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
	 * @Then action download and update zasilkovna branches is not available
	 */
	public function actionDownloadAndUpdateZasilkovnaBranchesIsDisabled()
	{
		Assert::throws(function () {
			$this->updatePage->zasilkovnaDownloadButtonIsOnPage();
		}, ElementNotFoundException::class);
	}

	/**
	 * @Then action download and update zasilkovna branches is available
	 */
	public function actionDownloadAndUpdateZasilkovnaBranchesIsEnabled()
	{
		Assert::notNull($this->updatePage->zasilkovnaDownloadButtonIsOnPage());
	}

	/**
	 * @Then click to action download and update zasilkovna branches
	 */
	public function clickToActionDownloadAndUpdateZasilkovnaBranches()
	{
		$this->updatePage->clickToZasilkovnaDownloadButton();
	}

	/**
	 * @Then I should be notified that Zásilkovna branches has been successfully updated
	 */
	public function iShouldBeNotifiedThatZasilkovnaBranchesHasBeenSuccessfullyUpdated()
	{
		$this->notificationChecker->checkNotification('Zásilkovna branches synchronization was successful.', NotificationType::success());
	}

	/**
	 * @Then it should be shipped to Zásilkovna branch
	 */
	public function itShouldBeShippedToZasilkovnaBranch()
	{
		Assert::true($this->updatePage->iSeeZasilkovnaBranchInsteadOfShippingAddress());
	}
}
