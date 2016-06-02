@register
Feature: register

  Scenario: Check register page when signup is not enable
    When I am on route "user_register"
    Then the response status code should be 404

  Scenario: Signing up with invitation
    When I am on "/register?token=c7f59c75b88da6104422ff94658cbfd32e70463c"
    And the "Email" field should contain "EsterBBerry@jourrapide.com"
    And I fill in the following:
      | Username     | EsterBBerry |
      | Password     | EsterBBerry |
      | Verification | EsterBBerry |
    And I press "Sign up"
    Then I should see "You have been registered successfuly"

  Scenario: Signing up
    Given I am connected as "admin"
    Then I go to "/admin/settings/"
    When I check "Signup enable"
    And I press "submit"
    And I go to "/logout"
    Then I go to "/register"
    And I fill in the following:
      | Username     | landru |
      | Password     | landru |
      | Verification | landru |
      | Email | landru@tempo-project.com |
    And I press "Sign up"
    Then I should see "You have been registered successfuly"
