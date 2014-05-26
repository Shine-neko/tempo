Feature: dashboard project

  Background:
    Given I am connected as "admin"

  Scenario: Viewing the dashboard project
    When I am on "project/luciole"

    And I should see "Project services"
    And I follow "Github"

