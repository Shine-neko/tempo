Feature: dashboard timesheet

  Background:
    Given I am connected as "olivia.pace"

  Scenario: Viewing projects on dasboard timesheet
    When I am on route "timesheet" with query "week=12&year=2014"

    And I should see "Bebop"
    And I should see "Galasphere"
    And I should see "Messie"
    And I should see "Prometheus"
    And I should see "Spartacus"
    And I should see "Gothlauth"


  Scenario: list days:
    When I am on route "timesheet" with query "week=12&year=2014"

    And I should see "Monday 17"
    And I should see "Tuesday 18"
    And I should see "Wednesday 19"
    And I should see "Thursday 20"
    And I should see "Friday 21"
    And I should see "Saturday 22"
    And I should see "Sunday 23"