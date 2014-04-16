Feature: show timesheet
  Background:
    Given I am connected as "olivia.pace"

  Scenario: view in modale
    When I am on route "timesheet_show" with query "date=2014-04-13"