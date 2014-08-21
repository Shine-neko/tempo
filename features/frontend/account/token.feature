Feature: generate a new token project

  Background:
    Given I am connected as "admin"

  Scenario: show a project
    When I go to "profile/edit/settings"
    And I press "Generate token"