<?php
namespace App\Core\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Identical;

class HashtagForm extends Form
{
    public function initialize($entity = null, $options = null)
    {
        $hashtag_name = new Text('hashtag_name', array(
            'placeholder' => 'Name',
        ));

        $hashtag_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Name is required',
            ))
        ));

        $this->add($hashtag_name);

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
