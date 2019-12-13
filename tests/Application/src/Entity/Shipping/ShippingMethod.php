<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Application\src\Entity\Shipping;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Table;
use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodTrait;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;

/**
 * @MappedSuperclass
 * @Table(name="sylius_shipping_method")
 */
class ShippingMethod extends BaseShippingMethod implements ZasilkovnaShippingMethodInterface
{
	use ZasilkovnaShippingMethodTrait;
}
