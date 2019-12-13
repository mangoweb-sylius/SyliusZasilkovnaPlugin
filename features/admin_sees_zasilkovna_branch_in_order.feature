@admin_sees_zasilkovna_branch_in_order
Feature: Admin can see Zásilkovna branch in order detail in admin panel
	In order to see a Zásilkovna branch in order detail in admin panel
	As an Administrator
	I want to see Zásilkovna branch in order detail in admin panel

	Background:
		Given the store operates on a single channel in "United States"
		And the store has a product "Angel T-Shirt"
		And the store ships everywhere for free
		And the store also allows shipping with "Zasilkovna" identified by "Zasilkovna"
		And this shipping method has Zásilkovna api key
		And the store has Zásilkovna "ZasilkovnaCZ" with ID "1"
		And the store allows paying with "Cash on Delivery"

	@ui
	Scenario: Displaying basic information about an order which is not sent using Zásilkovna
		And there is a customer "lucy@teamlucifer.com" that placed an order "#00000666"
		And the customer bought a single "Angel T-Shirt"
		And the customer "Lucifer Morningstar" addressed it to "Seaside Fwy", "90802" "Los Angeles" in the "United States"
		And for the billing address of "Mazikeen Lilim" in the "Pacific Coast Hwy", "90806" "Los Angeles", "United States"
		And the customer chose "Free" shipping method with "Cash on Delivery" payment
		And I am logged in as an administrator
		When I view the summary of the order "#00000666"
		Then it should have been placed by the customer "lucy@teamlucifer.com"
		And it should be shipped to "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States"
		And it should be billed to "Mazikeen Lilim", "Pacific Coast Hwy", "90806", "Los Angeles", "United States"
		And it should be shipped via the "Free" shipping method
		And it should be paid with "Cash on Delivery"

	@ui
	Scenario: Displaying basic information about an order which is sent using Zásilkovna
		And there is a customer "lucy@teamlucifer.com" that placed an order "#00000666"
		And the customer bought a single "Angel T-Shirt"
		And the customer "Lucifer Morningstar" addressed it to "Seaside Fwy", "90802" "Los Angeles" in the "United States"
		And for the billing address of "Mazikeen Lilim" in the "Pacific Coast Hwy", "90806" "Los Angeles", "United States"
		And the customer chose "Zasilkovna" shipping method with "Cash on Delivery" payment
		And choose Zásilkovna branch "ZasilkovnaCZ"
		And I am logged in as an administrator
		When I view the summary of the order "#00000666"
		Then it should have been placed by the customer "lucy@teamlucifer.com"
		And it should be shipped to Zásilkovna branch
		And it should be billed to "Mazikeen Lilim", "Pacific Coast Hwy", "90806", "Los Angeles", "United States"
		And it should be shipped via the "Zasilkovna" shipping method
		And it should be paid with "Cash on Delivery"
