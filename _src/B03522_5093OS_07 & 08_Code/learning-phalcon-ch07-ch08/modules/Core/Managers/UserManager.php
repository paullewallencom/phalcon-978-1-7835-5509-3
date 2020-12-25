<?php
namespace App\Core\Managers;

use App\Core\Models\User;
use App\Core\Models\UserRole;
use App\Core\Models\AclRoles;
use App\Core\Models\UserProfile;

use App\Core\Forms\UserForm;

class UserManager extends BaseManager
{
    /**
     * Get form
     * @param  object                   $entity
     * @param  array                    $options
     * @return \App\Core\Forms\UserForm
     */
    public function getForm($entity = null, $options = null)
    {
        return new UserForm($entity, $options);
    }

    /**
     * Find records
     * @param  array|string                    $parameters
     * @return multitype:\App\Core\Models\User
     */
    public function find($parameters = null)
    {
        return User::find($parameters);
    }

    /**
     * Find first record
     * @param  array|string          $parameters
     * @return \App\Core\Models\User
     */
    public function findFirst($parameters = null)
    {
        return User::findFirst($parameters);
    }

    /**
     * Find first record by id
     * @param number $id
     */
    public function findFirstById($id)
    {
        return User::findFirstById($id);
    }

    /**
     * Create a new user
     *
     * @param  array                        $data
     * @param  string                       $user_group_name
     * @return string|\App\Core\Models\User
     */
    public function create($data, $user_role = 'Guest')
    {
        $security = $this->getDI()->get('security');

        if (isset($data['user_acl_role'])) {
            $user_role = $data['user_acl_role'];
        }

        $user = new User();
        $user->setUserFirstName($data['user_first_name']);
        $user->setUserLastName($data['user_last_name']);
        $user->setUserEmail($data['user_email']);
        $user->setUserPassword($security->hash($data['user_password']));
        $user->setUserIsActive($data['user_is_active']);

        $o_acl_role  = AclRoles::findFirstByName($user_role);

        if (!$o_acl_role) {
            throw new \Exception("Role $user_role does not exists");
        };

        $o_user_role[0] = new UserRole();
        $o_user_role[0]->setUserRole($user_role);

        $user->roles = $o_user_role;

        $profile = new UserProfile();
        $profile->setUserProfileLocation($data['user_profile_location']);

        $user->profile = $profile;

        return $this->save($user, 'create');
    }

    /**
     * Update an existing record
     * @param  array                    $data
     * @return \App\Core\Models\Hashtag
     */
    public function update(array $data)
    {
        $object = User::findFirstById($data['id']);

        if (!$object) {
            throw new \Exception('Object not found');
        }

        $security = $this->getDI()->get('security');

        $object->setUserFirstName($data['user_first_name']);
        $object->setUserLastName($data['user_last_name']);
        $object->setUserEmail($data['user_email']);
        $object->setUserPassword($security->hash($data['user_password']));
        $object->setUserIsActive($data['user_is_active']);

        $o_acl_role  = AclRoles::findFirstByName($data['user_acl_role']);

        if (!$o_acl_role) {
            throw new \Exception("Role $user_role does not exists");
        };

        $o_user_role[0] = new UserRole();
        $o_user_role[0]->setUserRole($data['user_acl_role']);

        $object->roles = $o_user_role;

        $object->profile->setUserProfileLocation($data['user_profile_location']);

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
        $object = User::findFirstById($id);

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
