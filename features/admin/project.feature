@admin
Feature: Products

  Background:
    Given I am connected as "admin"

  Scenario: Seeing index of all products
    Given I am on "/admin/project/"
    Then I should be on "/admin/project/"
    And I should see "Galasphere"
    And I should see "Bebop"