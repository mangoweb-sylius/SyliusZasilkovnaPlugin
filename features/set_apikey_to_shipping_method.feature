@set_apikey_to_shipping_method
Feature: Set Zásilkovna api key to shipping method
	In order to add a Zásilkovna API key to shipping method settings in admin panel
	As an Administrator
	I want to add Zásilkovna API key to the shipping method

	Background:
		Given the store operates on a single channel in "United States"
		And the store allows shipping with "Zásilkovna" identified by "zasilkovna"
		And I am logged in as an administrator

	@ui
	Scenario: Set Zásilkovna api key to shipping method
		Given I want to modify a shipping method "Zásilkovna"
		When I change Zásilkovna api key to "RANDOM_API_KEY"
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Zásilkovna api key for this shipping method should be "RANDOM_API_KEY"

	@ui
	Scenario: Remove Zásilkovna api key from shipping method
		Given I want to modify a shipping method "Zásilkovna"
		When I change Zásilkovna api key to ""
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Zásilkovna api key for this shipping method should be ""

	@ui
	Scenario: Set Zásilkovna Sender label to shipping method
		Given I want to modify a shipping method "Zásilkovna"
		When I change Zásilkovna Sender label to "RANDOM_TEXT_1"
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Zásilkovna Sender label for this shipping method should be "RANDOM_TEXT_1"

	@ui
	Scenario: Remove Zásilkovna Sender label from shipping method
		Given I want to modify a shipping method "Zásilkovna"
		When I change Zásilkovna Sender label to ""
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Zásilkovna Sender label for this shipping method should be ""

	@ui
	Scenario: Set Zásilkovna Carrier pickup point to shipping method
		Given I want to modify a shipping method "Zásilkovna"
		When I change Zásilkovna Carrier pickup point to "RANDOM_TEXT_2"
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Zásilkovna Carrier pickup point for this shipping method should be "RANDOM_TEXT_2"

	@ui
	Scenario: Remove Zásilkovna Carrier pickup point from shipping method
		Given I want to modify a shipping method "Zásilkovna"
		When I change Zásilkovna Carrier pickup point to ""
		And I save my changes
		Then I should be notified that it has been successfully edited
		And the Zásilkovna Carrier pickup point for this shipping method should be ""
