<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Security\Security;
use UserManagement\Extension\ViewableuserInfoExtension;

/**
 * Class ViewableuserInfoExtensionTest
 *
 * @package user-management
 */
class ViewableuserInfoExtensionTest extends FunctionalTest
{

    public function testget_template_global_variables()
    {
        $data = ViewableuserInfoExtension::get_template_global_variables();
        $this->assertEquals("getlogoutLink", $data["LoginLink"], "Login page exists");
    }

    public function testgetlogoutLink()
    {
        $data = ViewableuserInfoExtension::getlogoutLink();
        $this->assertNotTrue($data, "Login page exists");
    }
}