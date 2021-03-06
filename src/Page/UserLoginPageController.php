<?php
namespace UserManagement\Page;

use PageController;
use SilverStripe\Security\Security;
use SilverStripe\Security\MemberAuthenticator\MemberAuthenticator;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class UserLoginPageController
 *
 * @package user-management
 */
class UserLoginPageController extends PageController
{
    /**
     * @var string
     */
    private static $url_segment = 'user-login';

    public function init()
    {
        parent::init();
        $member = Security::getCurrentUser();
        if ($member && $member->exists()) {
            $config = SiteConfig::current_site_config();
            if ($config->LoginCallBackUrl()->URLSegment) {
                return $this->redirect($config->LoginCallBackUrl()->URLSegment);
            }
        }
    }
}
