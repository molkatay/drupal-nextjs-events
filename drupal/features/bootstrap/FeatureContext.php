<?php

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ExpectationException;
use Drupal\DrupalExtension\Context\RawDrupalContext;
use Drupal\user\Entity\User;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements Context {

  /**
   * Created users array.
   *
   * @var array
   */
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
   * I am logged in as a user with the role.
   *
   * @param string $role
   *   The role name.
   *
   * @Given I am logged in as a user with the role :role  *
   */
  public function iAmLoggedInAsAUserWithRole($role) {
    $user = $this->createUser([], $role);
    $this->login($user);
  }

  /**
   * Create a user with given roles.
   *
   * @param array $permissions
   *   Array of permissions.
   * @param string $role
   *   Role name.
   *
   * @return \Drupal\user\Entity\User
   *   The created user object.
   */
  protected function createUser(array $permissions = [], $role = '') {
    // Generate a unique username.
    $username = 'test_user_' . uniqid();
    $user = $this->getDriver('drupal')->userCreate(['name' => $username, 'pass' => 'password'], $permissions);
    if ($role) {
      $this->getDriver('drupal')->userAddRole($user, $role);
    }
    return $user;
  }

  /**
   * Login a user.
   *
   * @param \Drupal\user\Entity\User $user
   *   The user object to log in.
   */
  public function login($user) {
    $this->getSession()->visit($this->locatePath('/user/login'));
    $page = $this->getSession()->getPage();
    $page->fillField('Username', $user->name);
    $page->fillField('Password', $user->pass);
    $page->pressButton('Log in');
  }

  /**
   * Attach the media file to a field.
   *
   * @param string $filePath
   *   The file path of the media.
   * @param string $field
   *   The name of the field to attach the media file to.
   *
   * @When I attach the media file :filePath to :field.
   *
   * @throws Exception
   */
  public function iAttachTheMediaFileTo($filePath, $field) {
    $fieldElement = $this->getSession()->getPage()->findField($field);
    if ($fieldElement === NULL) {
      throw new \Exception(sprintf('Field "%s" not found on the page.', $field));
    }
    $fieldElement->attachFile($filePath);
  }

  /**
   * Check if an image with alt text is present on the page.
   *
   * @param string $altText
   *   The alt text of the image to look for.
   *
   * @Then I should see an image with alt text :altText
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function iShouldSeeAnImageWithAltText($altText) {
    $page = $this->getSession()->getPage();
    $image = $page->find('css', 'img[alt="' . $altText . '"]');
    if ($image === NULL) {
      throw new ExpectationException(sprintf('No image found with alt text "%s".', $altText), $this->getSession()->getDriver());
    }
  }

  /**
   * Clean up function to delete created users after each scenario.
   *
   * @AfterScenario
   */
  public function cleanUp() {
    // Delete created users.
    foreach ($this->createdUsers as $uid) {
      $user = User::load($uid);
      if ($user) {
        $user->delete();
      }
    }
  }

}
