Feature:

  Background:
    Given I am connected as "admin"

  Scenario: Add member
    When I am on "organization/ikimea/show"
    And I should not see "Warren Spencer"
    When I follow "Add membre"
    And I fill in "Username" with "warren.spencer"
    And I press "Save"
    And I should see "Warren Spencer"


  Scenario: remove member
    When I am on "organization/ikimea/show"
    And I follow "Remove Olivia PACE"
    And I should not see "remove Olivia PACE"
