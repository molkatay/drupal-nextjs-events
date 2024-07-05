Feature: Article Management
  In order to manage content
  As an authenticated user
  I need to add, edit, and delete articles

  Background:
    Given I am logged in as a user with the "content_editor" role

  Scenario: Adding a new article
    Given I am on "/node/add/article"
    When I fill in "Title" with "New Article"
    And I fill in "Body" with "This is the body of the new article."
    And I press "Save"
    Then I should see "Article New Article has been created."

  Scenario: Editing an article
    Given I am on the "New Article" article page
    When I press "Edit"
    And I fill in "Body" with "This is the updated body of the article."
    And I press "Save"
    Then I should see "Article New Article has been updated."

  Scenario: Deleting an article
    Given I am on the "New Article" article page
    When I press "Delete"
    And I press "Confirm"
    Then I should not see "New Article"
    And I should see "The article has been deleted."
