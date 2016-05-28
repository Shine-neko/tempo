@organization
@javascript
Feature: Create organisation

  Background:
    Given I am connected as "admin"

  Scenario: Create an organisation
    Given I am on "/project/"
    When I follow "New organization"
    And I fill in "Name" with "foo Bar"
    And I press "Save"
