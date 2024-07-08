Feature: Contact  with Webform
  In order to subscribe to events
  As a user
  I need to fill out the webform

  Scenario: Subscribing to an event
    Given I am on "/form/contact"
    When I fill in "Your Name" with "John Doe"
    And I fill in "Your Email" with "john.doe@example.com"
    And I fill in "Subject" with "Subject"
    And I fill in "Message" with "Message"
    And I press "Send message"
    Then I should see "Your message has been sent."
