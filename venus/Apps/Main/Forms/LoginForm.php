<?php
namespace Venus\Apps\Main\Forms;

use Phalcon\Forms\Form;

/*  Validation classes
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\Alpha;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\CreditCard;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\Digit;
use Phalcon\Validation\Validator\ExclusionIn;
use Phalcon\Validation\Validator\File;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\Url;
use Phalcon\Validation\Validator\Confirmation;
*/
use Phalcon\Validation\Validator\PresenceOf as Required;
use Phalcon\Validation\Validator\Email as EmailValidator; 
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Identical;


/*  Form element classes
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Element\Radio;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;
*/
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;


/*
*
*/

class LoginForm extends Form
{

    public function initialize($entity = null, $options = null)
    {

        /*
        * Email
        */
        $email = new Email('email');
        $email->addValidators([
            new Required([
                'message' => $this->text->simple('email_is_required')
            ]),
            new EmailValidator([
                'message' => $this->text->simple('email_not_valid')
            ])
        ]);
        $this->add($email);


        /*
        * Password
        */
        $password = new Password('password');
        $password->addValidators([
            new Required([
                'message' => $this->text->simple('password_required')
            ]),
            new StringLength([
                'min' => 6,
                'messageMinimum' => $this->text->assign('password_minimum','8')
            ]),
        ]);
        $this->add($password);


        /*
        * Remember Me
        */
        $terms = new Check('terms', [
            'value' => 'yes'
        ]);
        $this->add($terms);


        /*
        * Csrf Validation
        */
        $csrf = new Hidden('csrf');
        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => $this->text->simple('form_error_csrf')
        ]));
        $csrf->clear();
        $this->add($csrf);
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                return '<span class="form_error">'.$message.'</span>';
            }
        }
        return false;
    }
}