Feature: Validate timesheet
    Background:
        Given I am connected as "admin"

    Scenario:
        When I am on "/timesheet/validation"
        Given the following timesheet exist:
            | User          | Date              | Time spent |
            | Olivia PACE   | August 18, 2014   | 5h         |
