Feature: forgot your password

    Background:
        Given I am on "user/resetting"

    Scenario: forgot password
        When I fill in "username" with "chase.hoffman"
        And I press "Send"
        And I should see "An email with instructions on how to retrieve your password has been sent"

    Scenario: forgot password and username
        When I fill in "username" with "chase.hoffman@tempo-project.org"
        And I press "Send"
        Then I should see "An email with instructions on how to retrieve your password has been sent"

    Scenario: bad request
        When I follow "Already have login and password? Sign in"
        Then I should be on login page

    Scenario: forgot password within 24 hours
        When I fill in "username" with "chase.hoffman"
        And I press "Send"
        And I should see "The password for this user has already been requested within the last 24 hours."
