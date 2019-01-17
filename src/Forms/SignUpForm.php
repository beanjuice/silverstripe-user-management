<?php
namespace UserManagement\Forms;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\ConfirmedPasswordField;
use SilverStripe\Security\Security;
use SilverStripe\Security\RequestAuthenticationHandler;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Security\IdentityStore;
use Psr\Log\LoggerInterface;

/**
 * Class SignUpForm
 *
 * @package user-management
 */
class SignUpForm extends Form
{

    /**
     * Constructor
     */
    public function __construct($controller, $name)
    {

        $this->setAttribute('id', 'SignUpForm');
        parent::__construct($controller, $name, $this->getFormFields($controller), $this->getFormActions());
    }
    
    /**
     * Form action, Register user and redirect to the call back url with auto login.
     */
    public function doSubmit($data, Form $form)
    {
       
        try {
            $signUpPersonal = Member::create();
            $form->saveInto($signUpPersonal);
            if (isset($data['DOB']) && $data['DOB']) {
                  $signUpPersonal->DOB = date('Y-m-d', strtotime($data['DOB']));
            }
            $signUpPersonal->write();

            $config = SiteConfig::current_site_config();
            $Member = Member::get()->byId($signUpPersonal->ID);
            $assignGroup = $signUpPersonal->Groups();
            $assignGroup->add($config->CustomerGroup());
            Injector::inst()->get(IdentityStore::class)->logIn($Member);
            //TO DO
            //$this->sessionMessage('Profile Created!', 'good');
            return $this->controller->redirect('my-profile');
        } catch (Exception $e) {
            $this->logger->log('Error occured in signup');
        }
    }


     /**
     * @param Controller $controller the controller instance that is being passed to the form
     * @return FieldList Fields for this form.
     */
    protected function getFormFields($controller = null)
    {
        $fields = FieldList::create(
            TextField::create("FirstName", "FirstName"),
            TextField::create("Surname", "Surname"),
            TextField::create("NickName", "NickName"),
            DateField::create("DOB", "DOB"),
            ConfirmedPasswordField::create("Password", "Password"),
            EmailField::create("Email", "Email"),
            TextField::create("Mobile", "Mobile"),
            TextField::create("SecurityQuestion", "SecurityQuestion"),
            TextField::create("SecurityAnswer", "SecurityAnswer")
        );
        // Update the fields using updateSignUpForm
        $this->extend('updateSignUpForm', $fields);
        return $fields;
    }


    /**
     * @return FieldList Actions for this form.
     */
    protected function getFormActions()
    {
        return FieldList::create(
            FormAction::create("doSubmit", "Submit")
        );
    }
}
