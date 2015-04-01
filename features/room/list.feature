@room
Feature: Manipule room
  Scenario: room list
    Given I am connected as "john.doe"
    And I am on "/"

    Then I should see "Room1"
    And I should see "Room2"
    And I should see "Room3"
    And I should see "Room4"
    And I should see "Room5"
