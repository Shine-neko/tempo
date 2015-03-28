@organization
Feature: Display an organization

  Background:
    Given I am connected as "admin"

  Scenario: Viewing the dashboard project
    When I am on "organization/ikimea"

    And I should see "0 Open"
    And I should see "1 close"
