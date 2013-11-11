<?php
namespace Business;

class Heap extends \SplHeap {
    protected $attributes = array();
    protected $heuristics = array();
    protected $directions = array();
    public function sortAscendent($attribute, $heuristic) {
        $this->attributes[] = $attribute;
        $this->heuristics[$attribute] = $heuristic;
        $this->directions[$attribute] = 1;
    }
    public function sortDescendent($attribute, $heuristic) {
        $this->attributes[] = $attribute;
        $this->heuristics[$attribute] = $heuristic;
        $this->directions[$attribute] = -1;
    }
    protected function compare($object1, $object2) {
        foreach($this->attributes as $attribute) {
            $value = $this->heuristics[$attribute]($object1[$attribute], $object2[$attribute]);
            if($value != 0) {
                return $this->directions[$attribute] * $value;
            }
        }
        return 0;
    }
}
