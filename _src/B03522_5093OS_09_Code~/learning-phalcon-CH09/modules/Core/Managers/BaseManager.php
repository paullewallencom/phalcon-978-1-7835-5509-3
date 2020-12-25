<?php
namespace App\Core\Managers;

class BaseManager extends \Phalcon\Mvc\User\Module
{
    /**
     * Get records from DB - REST ready
     * @param array $parameters
     * @param array $options
     */
    public function restGet(array $parameters = null, array $options = null, $page = 1, $limit = 10)
    {
        $objects = $this->find($parameters);

        if (is_array($objects)) {
            $result = $objects;
        } else {
            $result = $objects->filter(function ($object) {
                return $object->toArray();
            });
        }

        $paginator = new \Phalcon\Paginator\Adapter\NativeArray([
            'data'  => $result,
            'limit' => $limit,
            'page'  => $page,
        ]);

        $data = $paginator->getPaginate();

        if ($data->total_items > 0) {
            return $data;
        }

        if (isset($parameters['bind']['id'])) {
            throw new \Exception('Not found', 404);
        } else {
            throw new \Exception('No Content', 204);
        }
    }

    /**
     * Delete an object with rest
     * @param  number     $id
     * @throws \Exception
     * @return boolean
     */
    public function restDelete($id)
    {
        $object = $this->findFirstById($id);

        if (!$object) {
            throw new \Exception('Object not found', 404);
        }

        if (false === $object->delete()) {
            foreach ($object->getMessages() as $message) {
                $error[] = (string) $message;
            }

            throw new \Exception(json_encode($error));
        }

        return true;
    }

    /**
     * Create a new object
     * @param array $data
     */
    public function restCreate($data)
    {
        $result = $this->create($data);

        if (is_object($result)) {
            return $result->toArray();
        }
    }

    /**
     * Update an existing object
     * @param array $data
     */
    public function restUpdate($data)
    {
        $result = $this->update($data);

        if (is_object($result)) {
            return $result->toArray();
        }
    }

    /**
     * Save/Create/Update an object
     *
     * @param  \Phalcon\Mvc\Model $object
     * @param  string             $type
     * @throws \Exception
     * @return Object
     */
    public function save($object, $type = 'save')
    {
        switch ($type) {
            case 'save':
                $result = $object->save();
                break;
            case 'create':
                $result = $object->create();
                break;
            case 'update':
                $result = $object->update();
                break;
        }

        if (false === $result) {
            foreach ($object->getMessages() as $message) {
                $error[] = (string) $message;
            }
            $output = (count($error) > 1) ? json_encode($error) : $error[0];

            throw new \Exception($output);
        }

        return $object;
    }
}
