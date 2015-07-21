@room
Feature: delete a room

  Background:
      Given I am connected as "john.doe"

  Scenario: delete a room
      Given I am on route "room_list"
      Then I follow "delete-Room5"
      And I should see "The room has been deleted successfuly"