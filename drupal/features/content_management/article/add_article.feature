Feature: Add Article with Image
  In order to manage content with images
  As an authenticated user
  I need to add articles with images

  Background:
    Given I am logged in as a user with the role "content_editor"

  Scenario: Adding a new article with an image
    Given I am on "/node/add/article"
    When I fill in "Title" with "New Article with Image"
    And I fill in "Body" with "This is the body of the new article with an image."
    And I attach the media file "image.jpg" to "edit-field-media-image-selection"    And I press "Save"
    Then I should see "Article New Article with Image has been created."
    And I should see an image with alt text "Image"
