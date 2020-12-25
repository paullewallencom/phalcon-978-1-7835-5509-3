<?php
namespace App\Core\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Identical;

use App\Core\Models\AclRoles;

class UserForm extends Form
{
    private $edit;

    public function initialize($entity = null, $options = null)
    {
        if (isset($options['edit']) && $options['edit'] === true) {
            $this->edit = true;
        }

        // First name
        $user_first_name = new Text('user_first_name', array(
            'placeholder' => 'First name',
        ));

        $user_first_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'First name is required',
            ))
        ));

        $this->add($user_first_name);

        // Last name
        $user_last_name = new Text('user_last_name', array(
            'placeholder' => 'Last name',
        ));

        $user_last_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Last name is required',
            ))
        ));

        $this->add($user_last_name);

        // Email
        $user_email = new Text('user_email', array(
            'placeholder' => 'Email',
        ));

        $user_email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required',
            )),
            new Email(array(
                'message' => 'The e-mail is not valid',
            )),
        ));

        $this->add($user_email);

        //Password
        $user_password = new Password('user_password', array(
            'placeholder' => 'Password',
        ));

        $user_password->addValidators(array(
            new PresenceOf(array(
                'message' => 'Password is required'
            )),
            new StringLength(array(
                'min' => 8,
                'messageMinimum' => 'Password is too short. Minimum 8 characters'
            ))
        ));

        $this->add($user_password);

        // User is active
        $this->add(new Select('user_is_active', array(
            1 => 'Yes',
            0 => 'No'
        )));

        // User location
        $user_profile_location = new Text('user_profile_location', array(
            'placeholder' => 'Location',
        ));

        if (true === $this->edit) {
            $user_profile_location->setDefault($entity->profile->getUserProfileLocation());
        }

        $this->add($user_profile_location);

        // User role
        $user_acl_role = new Select('user_acl_role', AclRoles::find(), array(
            'using' => array('name', 'name')
        ));

        $this->add($user_acl_role);

        //CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(
            new Identical(array(
                'value' => $this->security->getSessionToken(),
                'message' => 'CSRF validation failed',
            ))
        );

        $this->add($csrf);

        $this->add(new Submit('save', array(
            'class' => 'btn btn-lg btn-primary btn-block',
        )));
    }
}
