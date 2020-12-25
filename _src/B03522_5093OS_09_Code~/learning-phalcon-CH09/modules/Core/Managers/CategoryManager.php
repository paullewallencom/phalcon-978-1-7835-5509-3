<?php
namespace App\Core\Managers;

use App\Core\Models\Category;
use App\Core\Models\CategoryTranslation;
use App\Core\Forms\CategoryForm;

class CategoryManager extends BaseManager
{
    /**
     * Get form
     * @param  object                       $entity
     * @param  array                        $options
     * @return \App\Core\Forms\CategoryForm
     */
    public function getForm($entity = null, $options = null)
    {
        return new CategoryForm($entity, $options);
    }

    /**
     * Find records
     * @param  array|string                       $parameters
     * @return multitype:\App\Core\Models\Hashtag
     */
    public function find($parameters = null)
    {
        return Category::find($parameters);
    }

    /**
     * Find first record
     * @param  array|string             $parameters
     * @return \App\Core\Models\Hashtag
     */
    public function findFirst($parameters = null)
    {
        return Category::findFirst($parameters);
    }

    /**
     * Find first record by id
     * @param unknown $id
     */
    public function findFirstById($id)
    {
        return Category::findFirstById($id);
    }

    /**
     * Create a new record
     * @param  array                     $input_data
     * @throws \Exception
     * @return \App\Core\Models\Category
     */
    public function create(array $input_data)
    {
        $default_data = array(
            'translations' => array(
                'en' => array(
                    'category_translation_name' => 'Category name',
                    'category_translation_slug' => '',
                    'category_translation_lang' => 'en',
                ),
            ),
            'category_is_active' => 0,
        );

        $data = array_merge($default_data, $input_data);

        $category = new Category();
        $category->setCategoryIsActive($data['category_is_active']);

        $categoryTranslations = array();

        foreach ($data['translations'] as $lang => $translation) {
            $tmp = new CategoryTranslation();
            $tmp->assign($translation);
            array_push($categoryTranslations, $tmp);
        }

        $category->translations = $categoryTranslations;

        return $this->save($category, 'create');
    }

    /**
     * Update an existing record
     * @param  array                    $st_inputData
     * @return \App\Core\Models\Hashtag
     */
    public function update(array $st_inputData)
    {
        $st_defaultData = array(
            'translations' => array(
                'en' => array(
                    'category_translation_name' => 'Category name',
                    'category_translation_slug' => '',
                    'category_translation_lang' => 'en',
                ),
            )
        );

        $st_data = array_merge($st_defaultData, $st_inputData);
        $object  = Category::findFirstById($st_data['id']);

        if (!$object) {
            throw new \Exception('Object not found');
        }

        foreach ($st_data['translations'] as $locale => $values) {
            $translation = $object->getTranslations(["category_translation_lang = '$locale'"]);
            $translation[0]->setCategoryTranslationName($values['category_translation_name']);
            $translation[0]->setCategoryTranslationSlug($values['category_translation_slug']);
            $translation[0]->setCategoryTranslationLang($values['category_translation_lang']);
            $this->save($translation[0], 'update');
        }

        return $this->save($object, 'update');
    }

    /**
     * Delete an existing record
     * @param  number     $id
     * @throws \Exception
     * @return boolean
     */
    public function delete($id)
    {
        $object = Category::findFirstById($id);

        if (!$object) {
            throw new \Exception('Object not found');
        }

        if (false === $object->delete()) {
            foreach ($object->getMessages() as $message) {
                $error[] = (string) $message;
            }

            throw new \Exception(json_encode($error));
        }

        return true;
    }

}
