<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Form\Extension;

use MangoSylius\SyliusZasilkovnaPlugin\Form\Type\ZasilkovnaConfigType;
use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method iterable getExtendedTypes()
 */
class AdminZasilkovnaShippingMethodExtension extends AbstractTypeExtension
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('zasilkovnaConfig', ZasilkovnaConfigType::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtendedType()
	{
		return ShippingMethodType::class;
	}
}
