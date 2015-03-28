@organization
Feature: update organisation

  Background:
    Given I am connected as "admin"

  Scenario: update a organisation
    Given I am on "/organization/ikimea/update"
    When I fill in "Name" with "foo Bar"
    And I press "Save"

    Then I should see "Iki"