@admin
Feature: Users management
  In order to manager users
  As a manager
  I want to be able to list registered users

  Background:
    Given I am connected as "admin"

  Scenario: Seeing index of unconfirmed users
    Given I am on "/admin/users"
    When I follow "Unconfirmed accounts"
    And I should see "Beck"
    And I should see "Gregory"

  Scenario: Creating user
    Given I am on "/admin/users/new"
    When I fill in the following:
      | Username   | munio.murai          |
      | First Name | Kunio                |
      | Last Name  | Murai                |
      | Password   | Password             |
      | E-Mail     | munio.murai@gto.com |
    And I press "Create"
    And I should see "User has been successfully created."

  Scenario: Updating the user
    Given I am on "/admin/users/4/edit"
    When I fill in "E-Mail" with "jack.gill@gto.com"
    And I press "Save changes"
    And I should see "jack.gill@gto.com"

  Scenario: Deleting user
    Given I am on "/admin/users/16/edit"
    When I press "delete"
    And I should see "User has been successfully deleted."