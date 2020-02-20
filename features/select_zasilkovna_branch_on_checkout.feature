@select_zasilkovna_branch_on_checkout
Feature: Select Zásilkovna branch in checkout
	In order to select Zásilkovna shipping method and Zásilkovna branch
	As a Customer
	I want to select Zásilkovna shipping method and Zásilkovna branch and see it in final checkout step

	Background:
		Given the store operates on a channel named "manGoweb Channel"
		And the store operates in "Czechia"
		And the store also has a zone "EU" with code "EU"
		And this zone has the "Czechia" country member
		And the store has a product "PHP T-Shirt" priced at "$19.99"
		And the store has "DHL" shipping method with "$1.99" fee within the "EU" zone
		And the store has "Zasilkovna" shipping method with "$0.99" fee within the "EU" zone
		And this shipping method has Zásilkovna api key
		And the store allows paying with "CSOB"
		And I am a logged in customer

	@ui
	Scenario: Complete order with non Zásilkovna shipping method
		Given I have product "PHP T-Shirt" in the cart
		And I specified the shipping address as "Ankh Morpork", "Frost Alley", "90210", "Czechia" for "Jon Snow"
		And I select "DHL" shipping method
		And I complete the shipping step
		And I select "CSOB" payment method
		And I complete the payment step
		And address to "Jon Snow" should be used for both shipping and billing of my order
		When I confirm my order
		Then I should see the thank you page

	@ui
	Scenario: Unable to complete shipping step with Zásilkovna shipping methods without selecting the Zásilkovna branch
		Given I have product "PHP T-Shirt" in the cart
		And I specified the shipping address as "Ankh Morpork", "Frost Alley", "90210", "Czechia" for "Jon Snow"
		When I select "Zasilkovna" shipping method
		Then I should not be able to go to the payment step again

	@ui
	Scenario: Complete order with Zásilkovna shipping method
		Given I have product "PHP T-Shirt" in the cart
		And I specified the shipping address as "Ankh Morpork", "Frost Alley", "90210", "Czechia" for "Jon Snow"
		And I select "Zasilkovna" shipping method
		And I select "ZasilkovnaCZ" Zásilkovna branch
		And I complete the shipping step
		And I select "CSOB" payment method
		And I complete the payment step
		And I see Zásilkovna branch instead of shipping address
		But my order's billing address should be to "Jon Snow"
		And I confirm my order
		And I should see the thank you page

