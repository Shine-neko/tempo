@account
Feature: User account profile edition
  Background:
    Given I am connected as "john.doe"

  Scenario: Viewing my personal information page
    Given I am on "/profile/edit"
    When I should see "Edit profile"
    And I fill in the following:
      | First Name   | Doe        |
      | Last Name    | John       |
      | Company      | Castor inc |
      | Job title    | amnesic    |
    And I press "Save changes"
    Then I am on "/profile/edit"
    Then the "Company" field should contain "Castor inc"
    Then the "First Name" field should contain "Doe"
    Then the "Last Name" field should contain "John"
    Then the "Company" field should contain "Castor inc"
    Then the "Job title" field should contain "amnesic"
