@timesheet
Feature: dashboard timesheet

  Background:
    Given I am connected as "olivia.pace"

  Scenario: Viewing projects on dasboard timesheet
    When I am on "/timesheet/?week=12&year=2014"

    And I should see "Bebop"
    And I should see "Galasphere"
    And I should see "Messie"
    And I should see "Prometheus"
    And I should see "Spartacus"
    And I should see "Gothlauth"

  Scenario: list days:
    When I am on "/timesheet/?week=12&year=2014"

    And I should see "Monday 17"
    And I should see "Tuesday 18"
    And I should see "Wednesday 19"
    And I should see "Thursday 20"
    And I should see "Friday 21"
    And I should see "Saturday 22"
    And I should see "Sunday 23"

  Scenario: Create a new activity
    When I am on "/timesheet/"
    And I created cra:
      | workedTime   | 5   |
      | description  | Lorem Ipsum is simply dummy text.  |
    And I am on "/timesheet/"
    And I should see "total 1 5:00"

