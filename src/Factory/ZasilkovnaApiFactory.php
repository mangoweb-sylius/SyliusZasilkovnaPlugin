<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Factory;

use Doctrine\ORM\EntityManagerInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaConfigInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Model\Api\DownloaderInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Model\Api\ZasilkovnaApi;
use MangoSylius\SyliusZasilkovnaPlugin\Model\Api\ZasilkovnaApiInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Repository\ZasilkovnaConfigRepository;
use MangoSylius\SyliusZasilkovnaPlugin\Repository\ZasilkovnaRepository;

class ZasilkovnaApiFactory
{
	/**
	 * @var DownloaderInterface
	 */
	private $downloader;
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	/**
	 * @var ZasilkovnaRepository
	 */
	private $zasilkovnaRepository;
	/**
	 * @var ZasilkovnaConfigRepository
	 */
	private $zasilkovnaConfigRepository;
	/**
	 * @var string
	 */
	private $apiUrl;

	public function __construct(
		DownloaderInterface $downloader,
		EntityManagerInterface $entityManager,
		ZasilkovnaRepository $zasilkovnaRepository,
		ZasilkovnaConfigRepository $zasilkovnaConfigRepository,
		string $apiUrl
	) {
		$this->downloader = $downloader;
		$this->entityManager = $entityManager;
		$this->zasilkovnaRepository = $zasilkovnaRepository;
		$this->zasilkovnaConfigRepository = $zasilkovnaConfigRepository;
		$this->apiUrl = $apiUrl;
	}

	public function getZasilkovnaApi(): ?ZasilkovnaApiInterface
	{
		$config = $this->zasilkovnaConfigRepository->findOneEnabled();
		if ($config === null) {
			return null;
		}

		return $this->createForZasilkovnaConfig($config);
	}

	public function createForZasilkovnaConfig(ZasilkovnaConfigInterface $zasilkovnaConfig): ?ZasilkovnaApiInterface
	{
		if ($zasilkovnaConfig->getApiKey() === null) {
			return null;
		}

		return new ZasilkovnaApi(
			$this->downloader,
			$this->entityManager,
			$this->zasilkovnaRepository,
			$this->apiUrl,
			$zasilkovnaConfig->getApiKey()
		);
	}
}
