@javascript
@room
Feature: create room
    Background:
        Given I am connected as "john.doe"

    Scenario: create a room
        Given I am on route "room_list"
        Then I follow "Create room"
        And I fill in "name" with "Dentless"
        And I press "Save"
        Then I should see a flash message "Room has been created successfuly."
        Then I should see "Dentless"
