@room
Feature: Manipule room

  Background:
    Given I am connected as "john.doe"

  Scenario: room list

    Given I am on route "room_list"
    Then I should see "Room1"
    And I should see "Room2"
    And I should see "Room3"
    And I should see "Room4"
    And I should see "Room5"
