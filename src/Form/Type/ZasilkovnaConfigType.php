<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ZasilkovnaConfigType extends AbstractResourceType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('apiKey', TextType::class, [
				'label' => 'mangoweb.admin.zasilkovna.form.apiKey',
				'required' => false,
			])
			->add('senderLabel', TextType::class, [
				'label' => 'mangoweb.admin.zasilkovna.form.senderLabel',
				'required' => false,
			])
			->add('carrierPickupPoint', TextType::class, [
				'label' => 'mangoweb.admin.zasilkovna.form.carrierPickupPoint',
				'required' => false,
			])
		;
	}

	public function getBlockPrefix(): string
	{
		return 'mango_zasilkovna_plugin';
	}
}
