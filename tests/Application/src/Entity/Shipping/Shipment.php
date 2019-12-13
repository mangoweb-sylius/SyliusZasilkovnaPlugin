<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusZasilkovnaPlugin\Application\src\Entity\Shipping;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Table;
use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface;
use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentTrait;
use Sylius\Component\Core\Model\Shipment as BaseShipment;

/**
 * @MappedSuperclass
 * @Table(name="sylius_shipment")
 */
class Shipment extends BaseShipment implements ZasilkovnaShipmentInterface
{
	use ZasilkovnaShipmentTrait;
}
