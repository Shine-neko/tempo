@account
Feature: User account profile edition
  Background:
    Given I am connected as "john.doe"

  Scenario: Viewing my personal information page
    Given I am on "/profile/edit"
    When I should see "Edit profile"
    And I fill in the following:
      | First name   | Doe        |
      | Last name    | John       |
      | Phone        | 0100000000 |
      | Mobile phone | 0600000000 |
      | Company      | Castor inc |
      | Job title    | amnesic    |
    And I press "Save changes"
    Then I am on "/profile/edit"
    Then the "Company" field should contain "Castor inc"
    Then the "First name" field should contain "Doe"
    Then the "Last name" field should contain "John"
    Then the "Phone" field should contain "0100000000"
    Then the "Mobile phone" field should contain "0600000000"
    Then the "Company" field should contain "Castor inc"
    Then the "Job title" field should contain "amnesic"
