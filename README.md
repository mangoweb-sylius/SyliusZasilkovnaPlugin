<p align="center">
    <a href="https://www.mangoweb.cz/en/" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/38423357?s=200&v=4"/>
    </a>
</p>
<h1 align="center">
    Zásilkovna Plugin
    <br />
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-zasilkovna-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/mangoweb-sylius/sylius-zasilkovna-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-zasilkovna-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/mangoweb-sylius/sylius-zasilkovna-plugin.svg" />
    </a>
    <a href="https://travis-ci.org/mangoweb-sylius/SyliusZasilkovnaPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/mangoweb-sylius/SyliusZasilkovnaPlugin/master.svg" />
    </a>
</h1>

<p align="center">
	<a href="https://www.zasilkovna.cz"><img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusZasilkovnaPlugin/master/doc/logo.png" alt="Zásilkovna / Zásielkovňa / Csomagküldő / Przesyłkownia / Coletăria"/></a>
</p>

## Features

 - Adds shipment type *Zásilkovna* [<a href="https://www.zasilkovna.cz">cz</a>] [<a href="https://www.przesylkownia.pl">pl</a>] [<a href="https://www.zasielkovna.sk">sk</a>] [<a href="https://www.csomagkuldo.hu">hu</a>] [<a href="https://www.coletaria.ro">ro</a>] branch which allows sending ordered products to selected Zásilkovna branch.
 - The user can choose the Zásilkovna branch during checkout in the Shipment step.
 - Zásilkovna branches are displayed according to the zone of the shipment.
 - See Zásilkovna branch in final checkout step and also in the admin panel.
 - Export CSV with the Zásilkovna shipments and import it easily into Zásilkovna's system.

<p align="center">
	<img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusZasilkovnaPlugin/master/doc/admin_order_detail.png"/>
</p>
<p align="center">
	<img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusZasilkovnaPlugin/master/doc/admin_shipping_method_edit.png"/>
</p>
<p align="center">
	<img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusZasilkovnaPlugin/master/doc/shop_shipment_step.png"/>
</p>
<p align="center">
	<img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusZasilkovnaPlugin/master/doc/shop_checkout_complete.png"/>
</p>

## Installation

1. Run `$ composer require mangoweb-sylius/sylius-zasilkovna-plugin`.
1. Add plugin classes to your `config/bundles.php`:
 
   ```php
   return [
      ...
      MangoSylius\ShipmentExportPlugin\MangoSyliusShipmentExportPlugin::class => ['all' => true],
      MangoSylius\SyliusZasilkovnaPlugin\MangoSyliusZasilkovnaPlugin::class => ['all' => true],
   ];
   ```
  
1. Add resource to `config/packeges/_sylius.yaml`

    ```yaml
    imports:
         ...
         ...
         - { resource: "@MangoSyliusZasilkovnaPlugin/Resources/config/resources.yml" }
    ```
   
1. Add routing to `config/_routes.yaml`

    ```yaml
    mango_sylius_zasilkovna_plugin:
        resource: '@MangoSyliusZasilkovnaPlugin/Resources/config/routing.yml'
        prefix: /admin
   
    mango_sylius_shipment_export_plugin:
        resource: '@MangoSyliusShipmentExportPlugin/Resources/config/routing.yml'
        prefix: /admin
    ```
   
1. Your Entity `Shipment` has to implement `\MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface`. 
   You can use the trait `\MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentTrait`.
 
   ```php
   <?php 
   
   declare(strict_types=1);
   
   namespace App\Entity\Shipping;
   
   use Doctrine\ORM\Mapping as ORM;
   use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface;
   use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentTrait;
   use Sylius\Component\Core\Model\Shipment as BaseShipment;
   
   /**
    * @ORM\Entity
    * @ORM\Table(name="sylius_shipment")
    */
   class Shipment extends BaseShipment implements ZasilkovnaShipmentInterface
   {
       use ZasilkovnaShipmentTrait;
   }
   ```
   
1. Your Entity `ShippingMethod` has to implement `\MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface`. 
   You can use the trait `\MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentTrait`.
 
   ```php
   <?php 
   
   declare(strict_types=1);
   
   namespace App\Entity\Shipping;
   
   use Doctrine\ORM\Mapping as ORM;
   use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;
   use MangoSylius\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodTrait;
   use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
   
   /**
    * @ORM\Entity
    * @ORM\Table(name="sylius_shipping_method")
    */
   class ShippingMethod extends BaseShippingMethod implements ZasilkovnaShippingMethodInterface
   {
       use ZasilkovnaShippingMethodTrait;
   }
   ```

1. Include `MangoSyliusZasilkovnaPlugin:Admin/ShippingMethod:_zasilkovnaForm.html.twig` into `@SyliusAdmin/ShippingMethod/_form.html.twig`.
 
    ```twig
    ...	
   {{ include('MangoSyliusZasilkovnaPlugin:Admin/ShippingMethod:_zasilkovnaForm.html.twig') }}
    ...
    ```
   
1. Include `MangoSyliusZasilkovnaPlugin:Shop/Checkout/SelectShipping:_zasilkovnaChoice.html.twig` into `@SyliusShop/Checkout/SelectShipping/_choice.html.twig`.
 
    ```twig
    ...
    ...
   {{ include('MangoSyliusZasilkovnaPlugin:Shop/Checkout/SelectShipping:_zasilkovnaChoice.html.twig') }}
    ```
   
1. Replace `{% include '@SyliusShop/Common/_address.html.twig' with {'address': order.shippingAddress} %}` with `{{ include('MangoSyliusZasilkovnaPlugin:Shop/Common/Order:_zasilkovnaChoice.html.twig') }}` in `@SyliusShop/Common/Order/_addresses.html.twig`

1. Replace `{% include '@SyliusAdmin/Common/_address.html.twig' with {'address': order.shippingAddress} %}` with `{{ include('MangoSyliusZasilkovnaPlugin:Admin/Common/Order:_addresses.html.twig') }}` in `@SyliusAdmin/Common/Order/_addresses.html.twig`

1. Override the template in `MangoSyliusShipmentExportPlugin::_row.html.twig`
    ```twig
   {% extends 'MangoSyliusShipmentExportPlugin::_row.html.twig' %}
   
   {% block address %}
   	{% if row.zasilkovna %}
   		{{ 'mangoweb.admin.zasilkovna.export.toZasilkovnaBranch'|trans }}: {{ row.zasilkovna }}
   	{% else %}
   		{{ 'mangoweb.admin.zasilkovna.export.toAddress'|trans }}:
   		{% if row.order.shippingAddress.company %}
   			{{ row.order.shippingAddress.company }},
   		{% endif %}
   		{{ row.order.shippingAddress.firstName }}
   		{{ row.order.shippingAddress.lastName }},
   		{{ row.order.shippingAddress.street }},
   		{{ row.order.shippingAddress.postcode }}
   		{{ row.order.shippingAddress.city }},
   		{{ row.order.shippingAddress.countryCode }}
   	{% endif %}
   {% endblock %}
    ```
   
1. Create and run doctrine database migrations.

For the guide how to use your own entity see [Sylius docs - Customizing Models](https://docs.sylius.com/en/1.6/customization/model.html)

## Usage

* Create new shipping method in the admin panel and set `Zásilkovna api key`, save it and click `Sync Zásilkovna branches` button to load the list of branches into the current database.
* Zásilkovna CSV export will be generated for shipping method which has the code 'zasilkovna', you can change this in parameters, it is an array (therefore can contain more codes, e.g. if you need to have different prices for different countries, you will need more shipping methods; it is okay to use always the same API key) 
  ```yaml
  parameters:
      shippingMethodsCodes: ['zasilkovna']
  ```
* You need to select the appripriate countries for the zone where Zásilkovna has some branches
* Zásilkovna branches are updated on their servers daily between 0:00 - 1:00 CET. Just call this command (via `cron`) once a day, ideally during the night after 1:00. Details here: https://www.zasilkovna.cz/eshopy/implementace/xml

  ```bash
  mango:zasilkovna:sync
  ```
* Packeta API documentation: https://docs.packetery.com/03-creating-packets/01-csv-import.html


## Development

### Usage

- Develop your plugin in `/src`
- See `bin/` for useful commands

### Testing


After your changes you must ensure that the tests are still passing.

```bash
$ composer install
$ bin/console doctrine:schema:create -e test
$ bin/behat
$ bin/phpstan.sh
$ bin/ecs.sh
```

License
-------
This library is under the MIT license.

Credits
-------
Developed by [manGoweb](https://www.mangoweb.eu/).
