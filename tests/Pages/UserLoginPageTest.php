<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;

/**
 * Class UserLoginPageTest
 *
 * @package user-management
 */
class UserLoginPageTest extends FunctionalTest
{
    
    /**
     * Login page link test
     */
    public function testfindlink()
    {
        $page = $this->get("user-login/");  // attempt to access the user login Page
        $this->assertEquals(200, $page->getStatusCode(), "a page should load");
        $this->assertEquals(UserLoginPage::find_link(false), "user-login", "User Login page exists");
    }
}
