Feature: show a project

  Background:
    Given I am connected as "admin"

  Scenario: show a product
    When I go to "project/selenium/luciole"

    And I should see "Project"
    And I should see "Sub-Projects"
    And I should see "Activity"
    And I should see "Settings"

  Scenario: browsing sub projects
    When I go to "project/selenium/luciole"
    And I click on the element with css selector "a[href='#project']"
    And I should see "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression."

  Scenario: browsing project setting
    When I go to "project/selenium/luciole"
    And I should see "Web hook"
    And I should see "Service hooks"

