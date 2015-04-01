@organization
Feature: Create Organisation

  Background:
    Given I am connected as "admin"

  Scenario: Create a organisation
    Given I am on "/project/"
    When I follow "New organization"
    And I fill in "Name" with "foo Bar"
    And I press "Save"