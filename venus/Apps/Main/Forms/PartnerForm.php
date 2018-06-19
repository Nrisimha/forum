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


class PartnerForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
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
        /*
        * forumtitle
        */
        $forumtitle = new Text('forumtitle');
        $forumtitle->addValidators([
            new PresenceOf([
                'message' => $this->text->simple('forumtitle_is_required')
            ])
        ]);
        $this->add($forumtitle);

        /*
        * name
        */
        $name = new Text('name');
        $name->addValidators([
            new PresenceOf([
                'message' => $this->text->simple('name_is_required')
            ])
        ]);
        $this->add($name);

        /*
        * surname
        */
        $surname = new Text('surname');
        $surname->addValidators([
            new PresenceOf([
                'message' => $this->text->simple('surname_is_required')
            ])
        ]);
        $this->add($surname);
        
        /*
        * company_name
        */
        $company_name = new Text('company_name');
        $company_name->addValidators([
            new PresenceOf([
                'message' => $this->text->simple('company_name_is_required'),
                'allowEmpty' => true
            ])
        ]);
        $this->add($company_name);
        /*
        * company_name
        */
        $partner_site = new Text('partner_site');
        $partner_site->addValidators([
            new PresenceOf([
                'message' => $this->text->simple('partner_site_is_required'),
                'allowEmpty' => true
            ])
        ]);
        $this->add($partner_site);
        /*
        * phone
        */
        $phone = new Text('phone');
        $phone->addValidators([
            new PresenceOf([
                'message' => $this->text->simple('phone_is_required')
            ])
        ]);
        $this->add($phone);

        /*
        * info
        */
        $info = new Text('info');
        $info->addValidators([
            new PresenceOf([
                'message' => $this->text->simple('info_is_required')
            ])
        ]);
        $this->add($info);
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