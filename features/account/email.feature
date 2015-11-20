@account
Feature: 

  Background:
    Given I am connected as "brian.lester"

  Scenario: Adding an email adress
    Given I am on route "user_email_edit"
    And I fill in "user_email_email" with "brian.lester@tempo-project.com"
    And I press "Add"
    Then I should see "Your profile has been updated."
   
  Scenario: Deleting an adress
    Given I am on route "user_email_edit"
    And I follow "remove brian.lester@tempo-project.com"
    Then I should see "Your profile has been updated."
    And I should not see "brian.lester@tempo-project.com"