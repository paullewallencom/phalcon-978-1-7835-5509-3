<?php
namespace App\Core\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\Identical;

class CategoryForm extends Form
{
    private $edit = false;

    public function initialize($entity = null, $options = null)
    {
        if (isset($options['edit']) && $options['edit'] === true) {
            $this->edit = true;
        }

        $locales = $this->getDI()->get('config')->i18n->locales->toArray();

        foreach ($locales as $locale => $name) {

            if (true === $this->edit) {
                $translations = $entity->getTranslations(["category_translation_lang = '$locale'"])->toArray();
            }

            $category_name[$locale] = new Text ("translations[$locale][category_translation_name]", [
                'value' => $this->edit === true ? $translations[0]['category_translation_name'] : null
            ]);

            $category_slug[$locale] = new Text ( "translations[$locale][category_translation_slug]", [
                'value' => $this->edit === true ? $translations[0]['category_translation_slug'] : null
            ]);

            $category_lang[$locale] = new Hidden ( "translations[$locale][category_translation_lang]", [
                'value' => $locale
            ]);

            $this->add( $category_name[$locale] );
            $this->add( $category_slug[$locale] );
            $this->add( $category_lang[$locale] );
        }

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
