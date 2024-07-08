Feature: User Registration
  In order to access the site
  As a visitor
  I need to register an account

  Scenario: Registering a new user
    Given I am on "/user/register"
    When I fill in "Username" with "test_user"
    And I fill in "Email address" with "test_user@example.com"
    And I fill in "Password" with "passwordA12345*"
    And I fill in "Confirm password" with "passwordA12345*"
    And I press "Create new account"
    Then I should see "A welcome message with further instructions has been sent to your email address."
