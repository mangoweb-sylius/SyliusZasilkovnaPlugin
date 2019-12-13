@update_zasilkovna_branches
Feature: Download the list of current Zásilkovna branches
	In order to update local list of Zásilkovna branches with live list of Zasilkovna branches
	As an Administrator
	Download current Zásilkovna branches and update it

	Background:
		Given the store operates on a single channel in "United States"
		And the store allows shipping with "DHL"
		And the store allows shipping with "Zásilkovna"
		And this shipping method has Zásilkovna api key
		And the store has Zásilkovna "Test1" with ID "1"
		And the store has Zásilkovna "Test2" with ID "2"
		And I am logged in as an administrator

	@ui
	Scenario: Run the command and download and create Zásilkovna branches
		Given I update zasilkovna branches
		Then the store should has Zásilkovna "Zasilkovna3" with ID "3"

	@ui
	Scenario: Run the command and download and update Zásilkovna branches
		Given I update zasilkovna branches
		Then the store should has Zásilkovna "Zasilkovna1" with ID "1"

	@ui
	Scenario: Run the command and download and disable Zásilkovna branches
		Given I update zasilkovna branches
		Then the store should has disabled Zásilkovna with ID "2"

	@ui
	Scenario: Action download and update Zásilkovna branches is disabled
		Given I want to modify a shipping method "DHL"
		Then action download and update zasilkovna branches is not available

	@ui
	Scenario: Run action download and update Zásilkovna branches from shipping method edit form in the admin panel
		Given I want to modify a shipping method "Zásilkovna"
		Then action download and update zasilkovna branches is available
		And click to action download and update zasilkovna branches
		Then I should be notified that Zásilkovna branches has been successfully updated
		And the store should has Zásilkovna "Zasilkovna1" with ID "1"

