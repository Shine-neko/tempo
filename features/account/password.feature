@account
Feature: User account password change
  In order to enhance the security of my account
  As a logged user
  I want to be able to change
  And login with the new password

  Background:
    Given I am connected as "brian.lester"

  Scenario: Changing my password with a wrong current password
    Given I am on route "user_profile_password"
    When I fill in "Current password" with "brian.lester"
      And I fill in "New password" with "newpassword"
      And I fill in "Verification" with "newpassword"
      And I press "Update"
    Then I am on route "user_profile_password"
    And I am on route "user_logout"
    Then I am connected as "brian.lester" with password "newpassword"