<?php

class BaseTask extends \Phalcon\CLI\Task
{
    /**
     * Log a message to the console.
     *
     * @param string $s_message
     * @param string $color     Allowed values are green, blue, red or yellow
     */
    public function consoleLog($s_message, $color = 'green', $endline = true)
    {
        $start      = "\033[";
        $end        = "\033[0m\n";
        $bash_color = '0;32';
        $colors = array(
            'green'  => '0;32',
            'red'    => '0;31',
            'yellow' => '0;33',
            'blue'   => '0;34',
            'grey'   => '0;30',
        );
        if (isset($colors[$color])) {
            $bash_color = $colors[$color];
        }
        echo $start, $bash_color, 'm', $s_message;
        if ($endline) {
            echo $end;
        }
    }

    /**
     * Countdown method. Outputs seconds left until an action is taken
     *
     * @param integer $time Time in seconds
     */
    public function countdown($time)
    {
        for ($i = 1;$i <= $time;$i++) {
            sleep(1);
            $this->consoleLog(($time-$i).' seconds left ...', 'red');
        }
    }

    /**
     * Quit method is calling exit() with a message
     *
     * @param string $s_message
     */
    public function quit($s_message)
    {
        $this->consoleLog($s_message, 'red');
        exit;
    }

    /**
     * Log messages to a log file
     *
     * @param string $s_message
     * @param string $log_file  Location of the log file. Default: /tmp/app.log
     */
    public function log($s_message, $log_file = '/tmp/app.log')
    {
        error_log(PHP_EOL.$s_message.PHP_EOL, 3, $log_file);
    }

    /**
     * Confirm an action
     *
     * @param string $message
     */
    protected function confirm($message = 'Are you sure you want to process it')
    {
        echo "\033[0;31m".$message.' [y/N]: '."\033[0m";

        $confirmation = trim(fgets(STDIN));
        if ($confirmation !== 'y') {
            exit(0);
        }
    }
}
