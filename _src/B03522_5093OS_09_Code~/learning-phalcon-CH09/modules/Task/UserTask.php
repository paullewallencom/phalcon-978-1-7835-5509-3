<?php
class UserTask extends BaseTask
{
    /**
     * @Description("Test action")
     */
    public function testAction()
    {
        $this->consoleLog('OK');
    }

    /**
     * @Description("Create a new user")
     * @Example("php modules/cli.php user create F_NAME L_NAME EMAIL@DOMAIN.TLD PASSWORD IS_ACTIVE LOCATION BIRTHDAY")
     */
    public function createAction($params = null)
    {
        if (!is_array($params) || count($params) < 5) {
            $this->quit('Usage: php modules/cli.php user create F_NAME L_NAME EMAIL@DOMAIN.TLD PASSWORD IS_ACTIVE LOCATION BIRTHDAY');
        }

        $this->confirm('You will create a user with the following data: '.implode(' | ', $params));

        $manager = $this->getDI()->get('core_user_manager');

        try {
            $user = $manager->create(array(
                'user_first_name' => $params[0],
                'user_last_name' => $params[1],
                'user_email' => $params[2],
                'user_password' => $params[3],
                'user_is_active' => $params[4],
                'user_profile_location' => $params[5],
                'user_profile_birthday' => $params[6],
            ), 'Guest');

            $this->consoleLog(sprintf(
                "User %s %s has been created. ID: %d",
                $user->getUserFirstName(),
                $user->getUserLastName(),
                $user->getId()
            ));
        } catch (\Exception $e) {
            $this->consoleLog("There were some errors creating the user: ", "red");
            $errors = json_decode($e->getMessage(), true);

            if (is_array($errors)) {
                foreach ($errors as $error) {
                    $this->consoleLog("  - $error", "red");
                }
            } else {
                $this->consoleLog("  - ".$e->getMessage(), "red");
            }
        }
    }
}
