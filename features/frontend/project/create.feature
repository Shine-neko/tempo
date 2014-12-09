Feature: Create Project
  In order to get access to project sections
  A user with ability to create a project
  Should be able to create a new one

  Background:
    Given I am connected as "admin"

  Scenario: User create a project
    When I go to "organization/ikimea"
    And I follow "Add new project"
    And I fill in the following:
      | Name | Tempo |
      | Code | k2k7g9 |
    And I press "Create"

  Scenario: Creating sub project
    When I go to "project/selenium/luciole"
    And I follow "Sub project"
    And I fill in the following:
      | Name | Too |
      | Code | k9k7g9 |
    And I press "Create"


  Scenario: Submitting empty parameter
    When I go to "organization/ikimea"
    And I follow "Add new project"
    When I fill in "Name" with ""
    And I press "Create"
    And I should see "This value should not be blank."