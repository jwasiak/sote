<?php

/** 
 * SOTESHOP/stSymfonyUpdate
 *
 * Ten plik należy do aplikacji stSymfonyUpdate opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSymfonyUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stEventDispatcher.class.php 32206 2020-06-05 07:20:32Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Klasa stEventDispatcher
 *
 * @package     stSymfonyUpdate
 * @subpackage  libs
 */
class stEventDispatcher
{
    protected static $instance = null;

    protected
            $listeners = array(),
            $logger = null,
            $callSequence = array('first', 'default', 'last');

    /**
     * Singelton
     *
     * @return   stEventDispatcher
     */
    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class();
            self::$instance->initialize();
        }

        return self::$instance;
    }

    public function initialize()
    {
        if (sfConfig::get('sf_logging_enabled'))
        {
            $this->logger = sfLogger::getInstance();
        }
    }

    /**
     * Connects a listener to a given event name.
     *
     * @param   string      $name               An event name
     * @param   mixed       $listener           A PHP callable
     */
    public function connect($name, $listener)
    {
        if (is_array($listener) && isset($listener[2]))
        { 
            $call_sequence = $listener[2] === true ? 'last' : $listener[2];
            
            unset($listener[2]);
        }
        else
        {
            $call_sequence = 'default';
        }

        if (!isset($this->listeners[$name][$call_sequence]))
        {
            $this->listeners[$name][$call_sequence] = array();
        }

        if (null !== $this->logger)
        {
            $ls = $this->listenerToString($listener);
            $this->logMessage(sprintf('connecting "%s" to "%s" event', $ls, $name));
        }

        $this->listeners[$name][$call_sequence][] = $listener;
    }

    /**
     * Disconnects a listener for a given event name.
     *
     * @param   string      $name               An event name
     * @param   mixed       $listener           A PHP callable
     * @return  mixed       false if listener does not exist, null otherwise
     */
    public function disconnect($name, $listener)
    {
        if (!isset($this->listeners[$name]))
        {
            return false;
        }

        foreach ($this->listeners[$name] as $i => $callable)
        {
            if ($listener === $callable)
            {
                if (null !== $this->logger)
                {
                    $ls = $this->listenerToString($listener);
                    $this->logMessage(sprintf('disconnecting "%s" from "%s" event', $ls, $name));
                }

                unset($this->listeners[$name][$i]);
            }
        }
    }

    /**
     * Notifies all listeners of a given event.
     *
     * @param   sfEvent     $event              A sfEvent instance
     * @return  sfEvent     The sfEvent instance
     */
    public function notify(sfEvent $event)
    {
        $listeners = $this->getListeners($event->getName());

        if ($listeners)
        {
            foreach ($this->callSequence as $sequence)
            {
                if (!isset($listeners[$sequence])) continue;

                foreach ($listeners[$sequence] as $listener)
                {
                    call_user_func($listener, $event);

                    if (null !== $this->logger)
                    {
                        $ls = $this->listenerToString($listener);
                        $this->logMessage(sprintf('calling "%s" listener (event_name: "%s", event_type: "notify")', $ls, $event->getName()));
                    }
                }
            }

        }

        return $event;
    }

    /**
     * Notifies all listeners of a given event until one returns a non null value.
     *
     * @param   sfEvent     $event              A sfEvent instance
     * @return  sfEvent     The sfEvent instance
     */
    public function notifyUntil(sfEvent $event)
    {
        $listeners = $this->getListeners($event->getName());

        if ($listeners)
        {
            foreach ($this->callSequence as $sequence)
            {
                if (!isset($listeners[$sequence])) continue;

                foreach ($listeners[$sequence] as $listener)
                {
                    if (null !== $this->logger)
                    {
                        $ls = $this->listenerToString($listener);
                        $this->logMessage(sprintf('calling "%s" listener (event_name: "%s", event_type: "notifyUntil")', $ls, $event->getName()));
                    }

                    if (call_user_func($listener, $event))
                    {
                        $event->setProcessed(true);
                        break;
                    }
                }
            }

        }

        return $event;
    }

    /**
     * Filters a value by calling all listeners of a given event.
     *
     * @param   sfEvent     $event              A sfEvent instance
     * @param   mixed       $value              The value to be filtered
     * @return  sfEvent     The sfEvent instance
     */
    public function filter(sfEvent $event, $value)
    {
        $listeners = $this->getListeners($event->getName());

        if ($listeners)
        {
            foreach ($this->callSequence as $sequence)
            {
                if (!isset($listeners[$sequence])) continue;

                foreach ($listeners[$sequence] as $listener)
                {
                    if (null !== $this->logger)
                    {
                        $ls = $this->listenerToString($listener);
                        $this->logMessage(sprintf('calling "%s" listener (event_name: "%s", event_type: "filter")', $ls, $event->getName()));
                    }

                    $value = call_user_func($listener, $event, $value);
                }
            }
        }

        $event->setReturnValue($value);

        return $event;
    }

    /**
     * Returns all listeners associated with a given event name.
     *
     * @param   string      $name               The event name
     * @return  array       An array of listeners
     */
    public function getListeners($name = null)
    {
        if (null === $name)
        {
            return $this->listeners;
        }

        if (!isset($this->listeners[$name]))
        {
            $this->listeners[$name] = array();
        }

        return $this->listeners[$name];
    }

    public function setListeners($listeners)
    {
        $this->listeners = $listeners;
    }

    protected function logMessage($message, $level = SF_LOG_INFO)
    {
        static $messages = array();

        if (!isset($messages[$message]))
        {
            $messages[$message] = true;

            $this->logger->log('{stEventDispatcher} ' . $message, $level);
        }
    }

    /**
     * Converts $listener to string
     *
     * @param         array       $listener
     * @return   string
     */
    protected function listenerToString($listener)
    {
        if (is_array($listener))
        {
            if (isset($listener[1]))
            {
                $name = $listener[0] . '::' . $listener[1] . '(sfEvent $event)';
            }
            else
            {
                $name = $listener[0] . '(sfEvent $event)'; 
            }
        }
        else
        {
            $name = $listener;
        }

        return $name . '(sfEvent $event)';
    }
}