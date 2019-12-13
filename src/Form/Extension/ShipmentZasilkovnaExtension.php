<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Form\Extension;

use Doctrine\ORM\EntityRepository;
use MangoSylius\SyliusZasilkovnaPlugin\Entity\Zasilkovna;
use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Repository\ZasilkovnaRepositoryInterface;
use Sylius\Bundle\CoreBundle\Form\Type\Checkout\ShipmentType;
use Sylius\Component\Addressing\Model\ZoneInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Shipping\Resolver\ShippingMethodsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method iterable getExtendedTypes()
 */
class ShipmentZasilkovnaExtension extends AbstractTypeExtension
{
	/**
	 * @var RepositoryInterface
	 */
	private $zoneRepository;
	/**
	 * @var ShippingMethodsResolverInterface
	 */
	private $shippingMethodsResolver;
	/**
	 * @var ShippingMethodRepositoryInterface
	 */
	private $shippingMethodRepository;

	/**
	 * @var string[];
	 */
	private $zasilkovnaMethodsCodes = [];
	/**
	 * @var ZasilkovnaRepositoryInterface
	 */
	private $zasilkovnaRepository;

	public function __construct(
		RepositoryInterface $zoneRepository,
		ShippingMethodsResolverInterface $shippingMethodsResolver,
		ShippingMethodRepositoryInterface $shippingMethodRepository,
		ZasilkovnaRepositoryInterface $zasilkovnaRepository
	) {
		$this->zoneRepository = $zoneRepository;
		$this->shippingMethodsResolver = $shippingMethodsResolver;
		$this->shippingMethodRepository = $shippingMethodRepository;
		$this->zasilkovnaRepository = $zasilkovnaRepository;
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
				if (array_key_exists('zasilkovna_' . $orderData['method'], $orderData) && in_array($orderData['method'], $this->zasilkovnaMethodsCodes, true)) {
					$zasilkovnaId = (int) $orderData['zasilkovna_' . $orderData['method']];
					$orderData['zasilkovna'] = $this->zasilkovnaRepository->find($zasilkovnaId);
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

				foreach ($shippingMethods as $method) {
					assert($method instanceof ShippingMethodInterface);
					assert($method instanceof ZasilkovnaShippingMethodInterface);

					$zasilkovnaConfig = $method->getZasilkovnaConfig();
					if ($zasilkovnaConfig && $zasilkovnaConfig->getApiKey()) {
						assert($method->getCode() !== null);
						$zone = $method->getZone();
						assert($zone !== null);

						$this->zasilkovnaMethodsCodes[] = $method->getCode();
						$form
							->add('zasilkovna_' . $method->getCode(), EntityType::class, [
								'required' => false,
								'mapped' => false,
								'empty_data' => null,
								'placeholder' => 'mangoweb.shop.checkout.shippingStep.chooseZasilkovnaBranch',
								'class' => Zasilkovna::class,
								'query_builder' => function (EntityRepository $er) use ($zone) {
									return $er->createQueryBuilder('z')
										->where('z.disabledAt IS NULL')
										->andWhere('z.country in (:countries)')
										->setParameter('countries', $this->getCountries($zone))
										->orderBy('z.nameStreet');
								},
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

	/**
	 * {@inheritdoc}
	 */
	public function getExtendedType()
	{
		return ShipmentType::class;
	}

	private function getZoneByCode(string $code): ZoneInterface
	{
		$zone = $this->zoneRepository->findOneBy(['code' => $code]);
		assert($zone instanceof ZoneInterface);

		return $zone;
	}

	private function getCountries(ZoneInterface $zone): array
	{
		$countries = [];
		if ($zone->getType() === ZoneInterface::TYPE_COUNTRY) {
			foreach ($zone->getMembers() as $countryMember) {
				$countries[] = $countryMember->getCode();
			}
		} elseif ($zone->getType() === ZoneInterface::TYPE_ZONE) {
			foreach ($zone->getMembers() as $zoneMember) {
				assert($zoneMember->getCode() !== null);
				$countries = array_merge($this->getCountries($this->getZoneByCode($zoneMember->getCode())));
			}
		}

		return $countries;
	}
}
