<?php
namespace Business;

class Future implements \SplObserver {
    const TYPE_CLOSURE = 1;
    const TYPE_OBJMETHOD = 2;
    protected $callback = NULL;
    protected $type = 0;
    public function __construct($callback = NULL) {
        $this->callback = $callback;
        if($callback instanceof \Closure) {
            $this->type = self::TYPE_CLOSURE;
        } elseif(is_array($callback) && count($callback) == 2 && is_object($callback[0]) && is_string($callback[1])) {
            $this->type = self::TYPE_OBJMETHOD;
        }
    }
    public function update(\SplSubject $subject) {
        if(is_callable($this->callback)) {
            switch($this->type) {
            case self::TYPE_CLOSURE:
                $callback = $this->callback;
                return $callback($subject);
            case self::TYPE_OBJMETHOD:
                return $this->callback[0]->${$this->callback[1]}($object);
            default:
                return call_user_func($this->callback, $subject);
            }
        }
    }
}
