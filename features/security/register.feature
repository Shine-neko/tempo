@register
Feature: register

  Scenario: Signing up
    When I am on "/register?token=c7f59c75b88da6104422ff94658cbfd32e70463c"
    And I fill in the following:
      | Username     | landru |
      | Password     | landru |
      | Verification | landru |
      | Email | landru@ikimea.com |
    And I press "Sign up"
    Then I should see "You have been registered successfuly"