@room
Feature: Manipule room

  Background:
    Given I am connected as "john.doe"

  Scenario: room list

    Given I am on route "room_list"
    Then I should see the table "#room-list"
      | Name   | Users | Messages |
      | Room1  | 1     | 0        |
      | Room2  | 1     | 0        |
      | Room3  | 1     | 0        |
      | Room4  | 1     | 0        |
