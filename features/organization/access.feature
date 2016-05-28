@organization
Feature: Organisation team

  Background:
    Given I am connected as "admin"

  Scenario: Add member
    When I am on "organization/ikimea"
    And I should not see "Warren Spencer"
    When I follow "Add member"
    And I fill in "Login" with "warren.spencer"
    And I press "Save"
    And I should see "Warren SPENCER"

  Scenario: Remove member
    When I am on "organization/ikimea"
    And I follow "Remove Warren SPENCER"
    Then I should not see "Warren spencer"
