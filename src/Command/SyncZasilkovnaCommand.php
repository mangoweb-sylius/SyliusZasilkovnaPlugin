<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Command;

use MangoSylius\SyliusZasilkovnaPlugin\Factory\ZasilkovnaApiFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SyncZasilkovnaCommand extends Command
{
	/**
	 * @var ZasilkovnaApiFactory
	 */
	private $zasilkovnaApiFactory;

	public function __construct(
		ZasilkovnaApiFactory $zasilkovnaApiFactory
	) {
		parent::__construct();
		$this->zasilkovnaApiFactory = $zasilkovnaApiFactory;
	}

	protected function configure(): void
	{
		$this->setName('mango:zasilkovna:sync');
	}

	protected function execute(InputInterface $input, OutputInterface $output): void
	{
		$io = new SymfonyStyle($input, $output);
		$io->title($this->getName() . ' started at ' . date('Y-m-d H:i:s'));

		$api = $this->zasilkovnaApiFactory->getZasilkovnaApi();
		if ($api === null) {
			$io->error('Non Zásilkovna API found.');

			return;
		}
		$api->syncBranches();

		$io->success($this->getName() . ' end at ' . date('Y-m-d H:i:s'));
	}
}
