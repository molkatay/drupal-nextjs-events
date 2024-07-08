<?php

use Behat\Behat\Context\Context;
use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Mink\Exception\ExpectationException;
use Drupal\user\Entity\User;
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements Context {

  private $createdUsers = [];


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
     * @Given I am logged in as a user with the role :role
     */
    public function iAmLoggedInAsAUserWithTheRole($role) {
      $user = $this->createUser([], $role);
      $this->login($user);
    }


    /**
     * Create a user with given roles.
     */
    protected function createUser(array $permissions = [], $role = '') {
      // Generate a unique username
      $username = 'test_user_' . uniqid();
      $user = $this->getDriver('drupal')->userCreate(['name' => $username, 'pass' => 'password'], $permissions);
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
   * @When I attach the media file :filePath to :field
   */
  public function iAttachTheMediaFileTo($filePath, $field) {
    $fieldElement = $this->getSession()->getPage()->findField($field);
    if ($fieldElement === null) {
      throw new \Exception(sprintf('Field "%s" not found on the page.', $field));
    }
    $fieldElement->attachFile($filePath);
  }

  /**
   * @Then I should see an image with alt text :altText
   */
  public function iShouldSeeAnImageWithAltText($altText) {
    $page = $this->getSession()->getPage();
    $image = $page->find('css', 'img[alt="' . $altText . '"]');
    if ($image === null) {
      throw new ExpectationException(sprintf('No image found with alt text "%s".', $altText), $this->getSession()->getDriver());
    }
  }
    /**
     * @AfterScenario
     */
    public function cleanUp() {
      // Delete created users
      foreach ($this->createdUsers as $uid) {
        $user = User::load($uid);
        if ($user) {
          $user->delete();
        }
      }
    }
}
