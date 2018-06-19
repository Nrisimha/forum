<?php
namespace Venus\Apps\Main\Forms;

use Phalcon\Forms\Form;

/*  Validation classes
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
*/
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email as EmailValidator; 
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;


/*  Form element classes
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Element\Radio;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Select;
*/
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;


class SignUpForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        /*
        * Nick
        */
        $nick = new Text('nick');
        $nick->addValidators([
            new PresenceOf([
                'message' => $this->text->simple('nick_is_required')
            ]),
            new Alnum([
                'message' => $this->text->simple('nick_must_be_alphanumeric')
            ])
        ]);
        $this->add($nick);

        /*
        * Email
        */
        $email = new Email('email');
        $email->addValidators([
            new PresenceOf([
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
            new PresenceOf([
                'message' => $this->text->simple('password_required')
            ]),
            new StringLength([
                'min' => 6,
                'messageMinimum' => $this->text->assign('password_minimum','8')
            ]),
            new Confirmation([
                'message' => $this->text->simple('password_confirmation_failed'),
                'with' => 'confirmPassword'
            ])
        ]);
        $this->add($password);

        /*
        * Confirm Password
        */
        $confirmPassword = new Password('confirmPassword');
        $confirmPassword->addValidators([
            new PresenceOf([
                'message' => $this->text->simple('password_confirmation_required')
            ])
        ]);
        $this->add($confirmPassword);

        /*
        * Terms and conditions
        */
        $terms = new Check('terms', [
            'value' => 'yes'
        ]);
        $terms->addValidator(new Identical([
            'value' => 'yes',
            'message' => $this->text->simple('terms_requred')
        ]));
        $this->add($terms);

        /*
        * CSRF
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