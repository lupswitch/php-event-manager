<?php
/**
 * User: Script
 * Date: 06.11.2018
 * Time: 6:59
 */

namespace Geega\EventManager;


class EventManager
{
    public static $instance = null;

    private $listeners = array();
    /**
     *
     * @return EventManager
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * @param string $event_name
     * @param array $data
     * @return EventManager
     */
    public function emit($event_name, array $data = array())
    {
        $listener = $this->getListener($event_name);
        if (!$listener) {
            return $this;
        }
        foreach ($listener as $event) {
            call_user_func($event['callback'], $data);
        }
        return $this;
    }
    /**
     *
     * @param string $event_name
     * @param mixed $callback
     * @param int $priority
     * @return EventManager
     */
    public function on($event_name, $callback, $priority = 1)
    {
        return $this->registerEvent($event_name, $callback, $priority);
    }
    /**
     *
     * @param string $event_name
     * @return EventManager
     */
    public function detach($event_name)
    {
        return $this->deRegisterEvent($event_name);
    }
    /**
     *
     * @param string $event_name
     * @param mixed $callback
     * @return EventManager
     */
    public final function registerEvent($event_name, $callback)
    {
        $event_name = trim($event_name);
        if (!isset($this->listeners[$event_name])) {
            $this->listeners[$event_name] = array();
        }
        $event = array(
            'event_name' => $event_name,
            'callback' => $callback
        );
        array_push($this->listeners[$event_name], $event);

        return $this;
    }
    /**
     *
     * @param string $event_name
     * @return EventManager
     */
    public final function deRegisterEvent($event_name)
    {
        if (isset($this->listeners[$event_name])) {
            unset($this->listeners[$event_name]);
        }
        return $this;
    }
    /**
     *
     * @return array
     */
    public function getListeners()
    {
        return $this->listeners;
    }

    /**
     * @param $listener
     * @return bool | array
     */
    public function getListener($listener)
    {
        if (isset($this->listeners[$listener])) {
            return $this->listeners[$listener];
        }
        return false;
    }
}