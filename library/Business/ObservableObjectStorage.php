<?php
namespace Business;

class ObservableObjectStorage implements \SplSubject, \ArrayAccess, \IteratorAggregate {
    protected $observers = NULL;
    protected $properties = array();
    protected $rawStorage = NULL;
    protected $events = array();

    protected $endpoint = NULL;
    protected $event = NULL;

    public function observers($newObservers = NULL) {
        if(NULL != $newObservers) {
            $this->observers = $newObservers;
        }
        elseif(NULL == $this->observers) {
            $this->observers = new \SplObjectStorage();
        }
        return $this->observers;
    }
    public function storage(\SplObjectStorage $newStorage = NULL) {
        if(NULL != $newStorage) {
            $this->rawStorage = $newStorage;
        }
        elseif(NULL == $this->rawStorage) {
            $this->rawStorage = new \SplObjectStorage();
        }
        return $this->rawStorage;
    }
    public function endpoint($endpoint = NULL) {
        if(NULL != $endpoint) {
            $this->endpoint = $endpoint;
        }
        return $this->endpoint;
    }
    /**
     * Trigger an event
     */
    public function __call($name, $argv) {
        return $this->dispatch($name, $argv);
    }
    /**/
    public function addObject($number) {
        return $this->dispatch('addObject', array($number));
    }
     /**/
    protected function dispatch($name, $argv) {
        if(!isset($this->events[$name])) {
            throw new \Exception();
        }
        foreach($this->events[$name] as $data) {
            $event = $data['event'];
            $observer = $data['callback'];
            $this->event($event)->setData($argv);
            $retval = $observer->update($this);
        }
    }
    public function event($event = NULL) {
        if(NULL == $event) {
            return $this->event;
        }
        $this->event = $event;
        return $this->event;
    }
    /**
     * Define an event name and an observer
     */
    public function on(Event $event, \SplObserver $future) {
        if(!isset($this->events[$event->getName()])) {
            $this->events[$event->getName()] = array();
        }
        $this->events[$event->getName()][] = array('event' => $event, 'callback' => $future);
    }

    public function property($name, $defaultValue) {
        $this->properties[$name] = $defaultValue;
    }
    public function offsetExists( $offset ) {
        return isset($this->properties[$offset]);
    }
        public function offsetGet ( $offset ) {
            return $this->properties[$offset];
        }

    public function offsetSet ( $offset , $value ) {
        $this->properties[$offset] = $value;
        return $this;
    }
    public function offsetUnset ( $offset ) {
        unset($this->properties[$offset]);
    }

    public function attach(\SplObserver $object) {
    }
    public function detach(\SplObserver $object) {
    }

    /**
     * Notify all observers of a change
     */
    public function notify($event = NULL) {
        foreach($this->storage as $observer) {
            $observer->update($event);
        }
    }
    public function getIterator() {
        return $this->rawStorage;
    }
}
