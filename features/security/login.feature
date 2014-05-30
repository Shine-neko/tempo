@account
Feature: Check login

  Scenario: Check login page when not connected
    When I am on route "fos_user_security_login"
    Then the response status code should be 200
    And I should see "Login"

  Scenario: Check user login page when connected
    When I fill in "Username" with "john.does"
    And I fill in "Password" with "john.does"
    And I press "Login"

  Scenario: Log in with bad credentials
    When I am on route "fos_user_security_login"
    When I fill in the following:
      | Username    | bar |
      | Password | bar         |
    And I press "Login"
    #Then I should be on login page
    And I should see "Bad credentials"