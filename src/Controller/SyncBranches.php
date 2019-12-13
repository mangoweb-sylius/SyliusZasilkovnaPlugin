<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Controller;

use Liip\ImagineBundle\Exception\Config\Filter\NotFoundException;
use MangoSylius\SyliusZasilkovnaPlugin\Factory\ZasilkovnaApiFactory;
use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class SyncBranches
{
	/**
	 * @var RouterInterface
	 */
	private $router;
	/**
	 * @var FlashBagInterface
	 */
	private $flashBag;
	/**
	 * @var TranslatorInterface
	 */
	private $translator;
	/**
	 * @var ShippingMethodRepositoryInterface
	 */
	private $shippingMethodRepository;
	/**
	 * @var ZasilkovnaApiFactory
	 */
	private $zasilkovnaApiFactory;

	public function __construct(
		TranslatorInterface $translator,
		FlashBagInterface $flashBag,
		RouterInterface $router,
		ShippingMethodRepositoryInterface $shippingMethodRepository,
		ZasilkovnaApiFactory $zasilkovnaApiFactory
	) {
		$this->router = $router;
		$this->flashBag = $flashBag;
		$this->translator = $translator;
		$this->shippingMethodRepository = $shippingMethodRepository;
		$this->zasilkovnaApiFactory = $zasilkovnaApiFactory;
	}

	public function __invoke(int $id): RedirectResponse
	{
		$shippingMethod = $this->shippingMethodRepository->find($id);
		if ($shippingMethod === null) {
			throw new NotFoundException();
		}

		assert($shippingMethod instanceof ZasilkovnaShippingMethodInterface);
		$zasilkovnaConfig = $shippingMethod->getZasilkovnaConfig();

		if ($zasilkovnaConfig === null) {
			throw new NotFoundException();
		}

		$zasilkovnaApi = $this->zasilkovnaApiFactory->createForZasilkovnaConfig($zasilkovnaConfig);
		if ($zasilkovnaApi === null) {
			throw new NotFoundException();
		}

		$zasilkovnaApi->syncBranches();

		$message = $this->translator->trans('mangoweb.admin.zasilkovna.success.import');
		$this->flashBag->add('success', $message);

		return new RedirectResponse($this->router->generate('sylius_admin_shipping_method_update', ['id' => $id]));
	}
}
