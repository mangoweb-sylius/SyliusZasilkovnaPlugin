<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Form\Extension;

use MangoSylius\SyliusZasilkovnaPlugin\Form\Type\ZasilkovnaConfigType;
use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class AdminZasilkovnaShippingMethodExtension extends AbstractTypeExtension
{
	/** @param array<mixed> $options */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder->add('zasilkovnaConfig', ZasilkovnaConfigType::class);
	}

	/** @return array<string> */
	public static function getExtendedTypes(): array
	{
		return [
			ShippingMethodType::class,
		];
	}
}
