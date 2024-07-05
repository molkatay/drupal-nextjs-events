<?php

use Behat\Behat\Context\Context;
use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Mink\Exception\ExpectationException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements Context {

  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct() {
  }

  /**
   * @Given I am logged in as a user with the :role role
   */
  public function iAmLoggedInAsAUserWithTheRole($role) {
    // Create and login user with the specified role.
    $user = $this->createUser([], $role);
    $this->login($user);
  }

  /**
   * Create a user with given roles.
   */
  protected function createUser(array $permissions = [], $role = '') {
    $user = $this->getDriver('drupal')->userCreate(['name' => 'test_user_' . uniqid(), 'pass' => 'password'], $permissions);
    if ($role) {
      $this->getDriver('drupal')->userAddRole($user, $role);
    }
    return $user;
  }

  /**
   * Login a user.
   */
  public function login($user) {
    $this->getSession()->visit($this->locatePath('/user/login'));
    $page = $this->getSession()->getPage();
    $page->fillField('Username', $user->name);
    $page->fillField('Password', $user->pass);
    $page->pressButton('Log in');
  }

  /**
   * @Then the :field field should contain :value
   */
  public function theFieldShouldContain($field, $value) {
    $page = $this->getSession()->getPage();
    $fieldElement = $page->findField($field);
    if ($fieldElement === null) {
      throw new ExpectationException(sprintf('Field "%s" not found on the page.', $field), $this->getSession()->getDriver());
    }
    $fieldValue = $fieldElement->getValue();
    if ($fieldValue !== $value) {
      throw new ExpectationException(sprintf('Expected field "%s" to contain "%s", but found "%s".', $field, $value, $fieldValue), $this->getSession()->getDriver());
    }
  }

  /**
   * @Then the :field field should be empty
   */
  public function theFieldShouldBeEmpty($field) {
    $page = $this->getSession()->getPage();
    $fieldElement = $page->findField($field);
    if ($fieldElement === null) {
      throw new ExpectationException(sprintf('Field "%s" not found on the page.', $field), $this->getSession()->getDriver());
    }
    $fieldValue = $fieldElement->getValue();
    if (!empty($fieldValue)) {
      throw new ExpectationException(sprintf('Expected field "%s" to be empty, but found "%s".', $field, $fieldValue), $this->getSession()->getDriver());
    }
  }
}
