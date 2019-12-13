<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Behat\Context\Domain;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Repository\ZasilkovnaRepositoryInterface;
use Sylius\Bundle\CoreBundle\Command\InstallSampleDataCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

final class CommandContext implements Context
{
	/**
	 * @var KernelInterface
	 */
	private $kernel;
	/**
	 * @var ZasilkovnaRepositoryInterface
	 */
	private $zasilkovnaRepository;
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function __construct(
		KernelInterface $kernel,
		ZasilkovnaRepositoryInterface $zasilkovnaRepository,
		EntityManagerInterface $entityManager
	) {
		$this->kernel = $kernel;
		$this->zasilkovnaRepository = $zasilkovnaRepository;
		$this->entityManager = $entityManager;
	}

	/**
	 * @Given I update zasilkovna branches
	 */
	public function iUpdateProductPricesOnChannelsAnd()
	{
		$application = new Application($this->kernel);
		$application->add(new InstallSampleDataCommand());
		$command = $application->find('mango:zasilkovna:sync');
		$tester = new CommandTester($command);
		$tester->execute([]);
	}

	/**
	 * @Given the store should has Zásilkovna ":zasilkovnaName" with ID ":zasilkovnaId"
	 */
	public function theStoreShouldHasZasilkovnaWithId(string $zasilkovnaName, int $zasilkovnaId): void
	{
		$zasilkovna = $this->zasilkovnaRepository->find($zasilkovnaId);
		assert($zasilkovna instanceof ZasilkovnaInterface);
		$this->entityManager->refresh($zasilkovna);

		Assert::eq($zasilkovna->getName(), $zasilkovnaName);
		Assert::null($zasilkovna->getDisabledAt());
	}

	/**
	 * @Given the store should has disabled Zásilkovna with ID ":zasilkovnaId"
	 */
	public function theStoreShouldHasDisabledZasilkovnaWithId(int $zasilkovnaId): void
	{
		$zasilkovna = $this->zasilkovnaRepository->find($zasilkovnaId);
		assert($zasilkovna instanceof ZasilkovnaInterface);
		$this->entityManager->refresh($zasilkovna);

		Assert::notNull($zasilkovna->getDisabledAt());
	}
}
