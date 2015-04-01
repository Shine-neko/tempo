@account
Feature: Check login

  Scenario: Check login page when not connected
    When I am on route "user_login"
    Then the response status code should be 200

  Scenario: Check user login page when connected
    When I fill in "Username" with "john.does"
    And I fill in "Password" with "john.does"
    And I press "Login"

  Scenario: Log in with bad credentials
    When I am on route "user_login"
    When I fill in the following:
      | Username    | bar |
      | Password | bar         |
    And I press "Login"
    And I should see "Invalid credentials"
