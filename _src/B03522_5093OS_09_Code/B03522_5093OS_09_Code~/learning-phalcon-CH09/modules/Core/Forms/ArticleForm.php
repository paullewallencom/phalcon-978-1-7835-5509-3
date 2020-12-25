<?php
namespace App\Core\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\Identical;

use App\Core\Models\CategoryTranslation;
use App\Core\Models\Hashtag;

class ArticleForm extends Form
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
                $translations = $entity->getTranslations(["article_translation_lang = '$locale'"])->toArray();
            }

            $article_translation_short_title[$locale] = new Text ("translations[$locale][article_translation_short_title]", [
                'value' => $this->edit === true ? $translations[0]['article_translation_short_title'] : null
            ]);

            $article_translation_long_title[$locale] = new Text ("translations[$locale][article_translation_long_title]", [
                'value' => $this->edit === true ? $translations[0]['article_translation_long_title'] : null
            ]);

            $article_translation_description[$locale] = new TextArea ("translations[$locale][article_translation_description]", [
                'value' => $this->edit === true ? $translations[0]['article_translation_description'] : null
            ]);

            $article_translation_slug[$locale] = new Text ( "translations[$locale][article_translation_slug]", [
                'value' => $this->edit === true ? $translations[0]['article_translation_slug'] : null
            ]);

            $article_translation_lang[$locale] = new Hidden ( "translations[$locale][article_translation_lang]", [
                'value' => $locale
            ]);

            $this->add( $article_translation_short_title[$locale] );
            $this->add( $article_translation_long_title[$locale] );
            $this->add( $article_translation_description[$locale] );
            $this->add( $article_translation_slug[$locale] );
            $this->add( $article_translation_lang[$locale] );
        }

        // Categories
        $categories = new Select('categories[]', CategoryTranslation::find(["category_translation_lang = 'en'"]), [
            'using' => [
                'category_translation_category_id',
                'category_translation_name'
            ],
            'multiple' => true
        ]);

        if ($this->edit === true) {
            $categories_defaults = array();

            foreach ($entity->getCategories(["columns" =>["id"]]) as $category) {
                $categories_defaults[] = $category->id;
            }

            $categories->setDefault($categories_defaults);
        }

        $this->add($categories);

        // Hash tags
        $hashtags = new Select('hashtags[]', Hashtag::find(), [
            'using' => [
                'id',
                'hashtag_name'
            ],
            'multiple' => true
        ]);

        if ($this->edit === true) {
            $hashtags_defaults = array();

            foreach ($entity->getHashtags(["columns" =>["id"]]) as $hashtag) {
                $hashtags_defaults[] = $hashtag->id;
            }

            $hashtags->setDefault($hashtags_defaults);
        }

        $this->add($hashtags);

        // Is published
        $this->add(new Select('article_is_published', array(
            1 => 'Yes',
            0 => 'No'
        )));

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
