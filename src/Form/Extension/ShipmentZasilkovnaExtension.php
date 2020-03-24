<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Form\Extension;

use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;
use Sylius\Bundle\CoreBundle\Form\Type\Checkout\ShipmentType;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Sylius\Component\Shipping\Resolver\ShippingMethodsResolverInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ShipmentZasilkovnaExtension extends AbstractTypeExtension
{
	/** @var ShippingMethodsResolverInterface */
	private $shippingMethodsResolver;

	/** @var ShippingMethodRepositoryInterface */
	private $shippingMethodRepository;

	/** @var string[]; */
	private $zasilkovnaMethodsCodes = [];

	public function __construct(
		ShippingMethodsResolverInterface $shippingMethodsResolver,
		ShippingMethodRepositoryInterface $shippingMethodRepository
	) {
		$this->shippingMethodsResolver = $shippingMethodsResolver;
		$this->shippingMethodRepository = $shippingMethodRepository;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('zasilkovna', HiddenType::class)
			->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {
				$orderData = $event->getData();

				assert(array_key_exists('zasilkovna', $orderData));
				assert(array_key_exists('method', $orderData));

				$orderData['zasilkovna'] = null;
				if (
					array_key_exists('zasilkovna_' . $orderData['method'], $orderData)
					&& in_array($orderData['method'], $this->zasilkovnaMethodsCodes, true)
					&& $orderData['zasilkovna_' . $orderData['method']] !== ''
				) {
					$orderData['zasilkovna'] = $orderData['zasilkovna_' . $orderData['method']];
				}

				$event->setData($orderData);
			})
			->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
				$form = $event->getForm();
				$shipment = $event->getData();

				if ($shipment && $this->shippingMethodsResolver->supports($shipment)) {
					$shippingMethods = $this->shippingMethodsResolver->getSupportedMethods($shipment);
				} else {
					$shippingMethods = $this->shippingMethodRepository->findAll();
				}

				$selectedMethodCode = $shipment !== null && $shipment->getMethod() !== null ? $shipment->getMethod()->getCode() : null;

				foreach ($shippingMethods as $method) {
					assert($method instanceof ShippingMethodInterface);
					assert($method instanceof ZasilkovnaShippingMethodInterface);

					$zasilkovnaConfig = $method->getZasilkovnaConfig();
					if ($zasilkovnaConfig && $zasilkovnaConfig->getApiKey()) {
						assert($method->getCode() !== null);
						$zone = $method->getZone();
						assert($zone !== null);

						$data = null;
						$dataLabel = null;
						if ($selectedMethodCode !== null && $selectedMethodCode === $method->getCode() && $shipment->getZasilkovna() !== null) {
							$data = json_encode($shipment->getZasilkovna());
							$dataLabel = $this->getZasilkovnaName($shipment->getZasilkovna());
						}

						$this->zasilkovnaMethodsCodes[] = $method->getCode();
						$form
							->add('zasilkovna_' . $method->getCode(), HiddenType::class, [
								'attr' => [
									'data-api-key' => $zasilkovnaConfig->getApiKey(),
									'data-country' => $zasilkovnaConfig->getOptionCountry(),
									'data-label' => $dataLabel,
								],
								'data' => $data,
								'required' => false,
								'mapped' => false,
								'empty_data' => null,
								'constraints' => [
									new NotBlank([
										'groups' => ['zasilkovna_' . $method->getCode()],
										'message' => 'mangoweb.shop.checkout.zasilkovnaBranch',
									]),
								],
							]);
					}
				}
			});

		$builder
			->get('zasilkovna')
			->addModelTransformer(new CallbackTransformer(
				function ($zasilkovnaAsArray) {
					return null;
				},
				function ($zasilkovnaAsString) {
					if ($zasilkovnaAsString === null) {
						return null;
					}

					return json_decode($zasilkovnaAsString, true);
				}
			));
	}

	private function getZasilkovnaName(array $zasilkovna): string
	{
		$arrayName = [];
		if (array_key_exists('place', $zasilkovna)) {
			$arrayName[] = $zasilkovna['place'];
		}
		if (array_key_exists('nameStreet', $zasilkovna)) {
			$arrayName[] = $zasilkovna['nameStreet'];
		} elseif (array_key_exists('name', $zasilkovna)) {
			$arrayName[] = $zasilkovna['name'];
		}

		return implode(', ', $arrayName);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		parent::configureOptions($resolver);

		$validationGroups = $resolver->resolve()['validation_groups'];

		$resolver->setDefaults([
			'validation_groups' => function (FormInterface $form) use ($validationGroups) {
				$entity = $form->getData();
				assert($entity instanceof ShipmentInterface);

				$shippingMethod = $entity->getMethod();

				if ($shippingMethod !== null) {
					assert($shippingMethod instanceof ZasilkovnaShippingMethodInterface);
					$zasilkovnaConfig = $shippingMethod->getZasilkovnaConfig();
					if ($zasilkovnaConfig && $zasilkovnaConfig->getApiKey()) {
						$validationGroups = array_merge($validationGroups ?? [], ['zasilkovna_' . $shippingMethod->getCode()]);
					}
				}

				return $validationGroups;
			},
		]);
	}

	/** @return array<string> */
	public static function getExtendedTypes(): array
	{
		return [
			ShipmentType::class,
		];
	}
}
