<?php
namespace Venus\Apps\Main\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class FormBase extends Form
{
    public $elements = array(
        "name" => [
            ["Name","text"],
            "validators" =>[
                "PresenceOf" => 
                    ["message"=>"This area is required."],
                
            ]
        ]
    );

    public function build(array $elements)
    {
      foreach ($elements as $name => $element) {
        switch ($element[0][1]) {
          case 'value':
            # code...
            break;
          
          default:
            # code...
            break;
        }





      }

    }

    public function renderDecorated($name)
    {
        $element  = $this->get($name);

        // Get any generated messages for the current element
        $messages = $this->getMessagesFor(
            $element->getName()
        );

        $export = "";

        if (count($messages)) {
            // Print each element
            $export .= '<div class="messages">';

            foreach ($messages as $message) {
                $export .= $message. ". ";
            }

            $export .= "</div>";
        }

        $export .= "<p>";

        $export .= '<label for="'. $element->getName(). '">'. $element->getLabel(). "</label>";

        $export .= $element;

        $export .= "</p>";

        return $export;
    }
}
