<?php
namespace App\Core\Managers;

use App\Core\Models\Hashtag;
use App\Core\Forms\HashtagForm;

class HashtagManager extends BaseManager
{
    /**
     * Get hashtag form
     * @param  object                      $entity
     * @param  array                       $options
     * @return \App\Core\Forms\HashtagForm
     */
    public function getForm($entity = null, $options = null)
    {
        return new HashtagForm($entity, $options);
    }

    /**
     * Find records
     * @param  array|string                       $parameters
     * @return multitype:\App\Core\Models\Hashtag
     */
    public function find($parameters = null)
    {
        return Hashtag::find($parameters);
    }

    /**
     * Find first record
     * @param  array|string             $parameters
     * @return \App\Core\Models\Hashtag
     */
    public function findFirst($parameters = null)
    {
        return Hashtag::findFirst($parameters);
    }

    /**
     * Find first record by id
     * @param unknown $id
     */
    public function findFirstById($id)
    {
        return Hashtag::findFirstById($id);
    }

    /**
     * Create a new record
     * @param  array                    $st_inputData
     * @return \App\Core\Models\Hashtag
     */
    public function create(array $st_inputData)
    {
        $st_defaultData = [
            'hashtag_name' => new \Phalcon\Db\RawValue('NULL')
        ];

        $st_data = array_merge($st_defaultData, $st_inputData);

        $hashtag = new Hashtag();
        $hashtag->setHashtagName($st_data['hashtag_name']);

        return $this->save($hashtag, 'create');
    }

    /**
     * Update an existing record
     * @param  array                    $st_inputData
     * @return \App\Core\Models\Hashtag
     */
    public function update(array $st_inputData)
    {
        $st_defaultData = [
            'hashtag_name' => new \Phalcon\Db\RawValue('NULL')
        ];

        $st_data = array_merge($st_defaultData, $st_inputData);

        $hashtag = Hashtag::findFirstById($st_data['id']);

        if (!$hashtag) {
            throw new \Exception('Object not found');
        }

        $hashtag->setHashtagName($st_data['hashtag_name']);

        return $this->save($hashtag, 'update');
    }

    /**
     * Delete an existing record
     * @param  number     $id
     * @throws \Exception
     * @return boolean
     */
    public function delete($id)
    {
        $object = Hashtag::findFirstById($id);

        if (!$object) {
            throw new \Exception('Hashtag not found');
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
