@javascript
@room
Feature: create room
    Background:
        Given I am connected as "john.doe"

    Scenario: create a room
        Given I am on route "room_list"
        Then I follow "create-room"
        And I fill in "room_name" with "Dentless"
        Then I should see "The room has been created successfuly"
        Then I should see "Dentless"
