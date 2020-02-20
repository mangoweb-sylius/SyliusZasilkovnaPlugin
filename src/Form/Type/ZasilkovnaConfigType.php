<?php

declare(strict_types=1);

namespace MangoSylius\SyliusZasilkovnaPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ZasilkovnaConfigType extends AbstractResourceType
{
	/**
	 * @var array
	 */
	private $countryChoices;

	public function __construct(
		array $countryChoices,
		string $dataClass,
		array $validationGroups = []
	) {
		parent::__construct($dataClass, $validationGroups);

		$this->countryChoices = $countryChoices;
	}

	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('apiKey', TextType::class, [
				'label' => 'mangoweb.admin.zasilkovna.form.apiKey',
				'required' => false,
			])
			->add('optionCountry', ChoiceType::class, [
				'label' => 'mangoweb.admin.zasilkovna.form.optionCountry',
				'required' => false,
				'choices' => array_combine($this->countryChoices, $this->countryChoices),
				'multiple' => false,
				'expanded' => false,
			])
			->add('senderLabel', TextType::class, [
				'label' => 'mangoweb.admin.zasilkovna.form.senderLabel',
				'required' => false,
			])
			->add('carrierId', TextType::class, [
				'label' => 'mangoweb.admin.zasilkovna.form.carrierId',
				'required' => false,
			])
		;
	}

	public function getBlockPrefix(): string
	{
		return 'mango_zasilkovna_plugin';
	}
}
