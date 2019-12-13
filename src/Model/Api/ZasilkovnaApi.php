<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Model\Api;

use Doctrine\ORM\EntityManagerInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\Zasilkovna;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\ZasilkovnaInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Repository\ZasilkovnaRepository;

class ZasilkovnaApi implements ZasilkovnaApiInterface
{
	/**
	 * @var string
	 */
	protected $apiUrl;
	/**
	 * @var string
	 */
	protected $apiKey;
	/**
	 * @var DownloaderInterface
	 */
	protected $downloader;
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	/**
	 * @var ZasilkovnaRepository
	 */
	private $zasilkovnaRepository;

	public function __construct(
		DownloaderInterface $downloader,
		EntityManagerInterface $entityManager,
		ZasilkovnaRepository $zasilkovnaRepository,
		string $apiUrl,
		string $apiKey
	) {
		$this->downloader = $downloader;
		$this->entityManager = $entityManager;
		$this->zasilkovnaRepository = $zasilkovnaRepository;
		$this->apiKey = $apiKey;
		$this->apiUrl = $apiUrl;
	}

	public function syncBranches(): void
	{
		$branches = $this->downloader->downloadBranches($this->composeApiUrl());

		$this->updateBranches($branches);
		$this->disableBranches($branches);
	}

	/**
	 * @param \stdClass[] $branches
	 */
	protected function updateBranches(array $branches): void
	{
		foreach ($branches as $branch) {
			if ($branch->id === null || trim($branch->id) === '') {
				continue;
			}

			$zasilkovnaId = (int) $branch->id;
			$zasilkovna = $this->zasilkovnaRepository->findOneBy(['id' => $zasilkovnaId]);
			if ($zasilkovna === null) {
				$zasilkovna = new Zasilkovna();
				$zasilkovna->setId($zasilkovnaId);
				$zasilkovna->setCreatedAt(new \DateTime());
			} else {
				assert($zasilkovna instanceof ZasilkovnaInterface);
				$zasilkovna->setUpdateAt(new \DateTime());
			}
			assert($zasilkovna instanceof ZasilkovnaInterface);

			$zasilkovna->setName(is_string($branch->name) ? $branch->name : null);
			$zasilkovna->setNameStreet(is_string($branch->nameStreet) ? $branch->nameStreet : null);
			$zasilkovna->setPlace(is_string($branch->place) ? $branch->place : null);
			$zasilkovna->setStreet(is_string($branch->street) ? $branch->street : null);
			$zasilkovna->setCity(is_string($branch->city) ? $branch->city : null);
			$zasilkovna->setZip(is_string($branch->zip) ? $branch->zip : null);
			$zasilkovna->setCountry(is_string($branch->country) ? strtoupper($branch->country) : null);
			$zasilkovna->setCurrency(is_string($branch->currency) ? $branch->currency : null);
			$zasilkovna->setWheelchairAccessible($branch->wheelchairAccessible === 'yes');
			$zasilkovna->setLatitude((float) $branch->latitude);
			$zasilkovna->setLongitude((float) $branch->longitude);
			$zasilkovna->setUrl(is_string($branch->url) ? $branch->url : null);
			$zasilkovna->setDressingRoom($branch->dressingRoom === '1');
			$zasilkovna->setClaimAssistant($branch->claimAssistant === '1');
			$zasilkovna->setPacketConsignment($branch->packetConsignment === '1');
			$zasilkovna->setMaxWeight((int) $branch->maxWeight);
			$zasilkovna->setRegion(is_string($branch->region) ? $branch->region : null);
			$zasilkovna->setDistrict(is_string($branch->district) ? $branch->district : null);
			$zasilkovna->setLabelRouting(is_string($branch->labelRouting) ? $branch->labelRouting : null);
			$zasilkovna->setLabelName(is_string($branch->labelName) ? $branch->labelName : null);
			$zasilkovna->setPhotos($branch->photos);
			$zasilkovna->setOpeningHours($branch->openingHours);

			$zasilkovna->setDisabledAt(null);

			$this->entityManager->persist($zasilkovna);
		}
		$this->entityManager->flush();
	}

	/**
	 * @param \stdClass[] $branches
	 */
	protected function disableBranches(array $branches): void
	{
		if (count($branches) === 0) {
			return;
		}

		$ids = [];
		foreach ($branches as $branch) {
			$ids[] = (string) $branch->id;
		}

		$this->entityManager->createQueryBuilder()
			->update(Zasilkovna::class, 'e')
			->set('e.disabledAt', ':now')
			->where('e.disabledAt IS NULL')
			->andWhere('e.id NOT IN (:ids)')
			->setParameter('now', new \DateTime())
			->setParameter('ids', $ids)
			->getQuery()
			->execute();

		$this->entityManager->flush();
	}

	private function composeApiUrl(): string
	{
		return $this->apiUrl . $this->apiKey;
	}
}
