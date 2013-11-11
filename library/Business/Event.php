<?php
namespace Business;

class Event {
    protected $sender;
    protected $data;
    protected $previousEvents = array();
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }
    public function setSender($sender) {
        $this->sender = $sender;
        return $this;
    }
    public function getSender() {
        return $this->sender;
    }
    public function setData($data) {
        $this->data = $data;
        return $this;
    }
    public function getData() {
        return $this->data;
    }
    public function getName() {
        return $this->name;
    }
    public function addPreviousEvent(Event $event) {
        $this->previousEvents[] = $event;
        return $this;
    }
}
