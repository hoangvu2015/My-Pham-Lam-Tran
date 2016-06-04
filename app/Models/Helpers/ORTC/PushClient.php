<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-24
 * Time: 01:03
 */

namespace Antoree\Models\Helpers\ORTC;


class PushClient
{
    /**
     * @var PushClient
     */
    private static $instance;

    /**
     * @return PushClient
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new PushClient();
        }

        return self::$instance;
    }

    private $connector;
    private $messages;

    private function __construct()
    {
        $this->messages = [];
        $this->connector = new Realtime(appOrtcServer(), appOrtcClientKey(), appOrtcClientSecrent(), appOrtcClientToken());
    }

    /**
     * @param string $channel
     * @param mixed $data
     * @return bool
     */
    public function sendNow($channel, $data)
    {
        if ($this->connector->auth(array($channel => 'w'))) {
            if (is_array($data) || is_object($data)) {
                $data = json_encode($data);
            }
            if ($this->connector->send($channel, $data)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $channel
     * @param mixed $data
     */
    public function queue($channel, $data)
    {
        if (!isset($this->messages[$channel])) {
            $this->messages[$channel] = [];
        }

        if (is_array($data) || is_object($data)) {
            $data = json_encode($data);
        }

        $this->messages[$channel][] = $data;
    }

    /**
     * @param bool $deleteAfter
     * @return bool
     */
    public function queueSend($deleteAfter = true)
    {
        foreach ($this->messages as $channel => $messages) {
            if ($this->connector->auth(array($channel => 'w'))) {
                foreach ($this->messages as $message) {
                    if (!$this->connector->send($channel, $message)) {
                        return false;
                    }
                }
            }
        }

        if ($deleteAfter) {
            $this->messages = [];
        }

        return true;
    }
}