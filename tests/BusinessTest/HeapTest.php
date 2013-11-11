<?php
namespace BusinessTest;
use Business;

class HeapTest extends \PHPUnit_Framework_TestCase {
    public function test_simpleSort() {
        $heap = new \Business\Heap();
        $numericComparator = function($value1, $value2) {
            if($value1 < $value2) {
                return 1;
            }
            elseif($value1 > $value2) {
                return -1;
            }
            return 0;
        };
        $nullComparator = function($value1, $value2) {
            if($value1 != NULL && $value2 == NULL) {
                return 1;
            }
            elseif($value2 != NULL && $value1 == NULL) {
                return -1;
            }
            return 0;
        };
        $heap->sortDescendent('value', $numericComparator);
        $heap->sortAscendent('country', $nullComparator);
        $heap->sortAscendent('group', $nullComparator);
        $heap->sortAscendent('count', $numericComparator);
        $data = array(
            array('value' => 1, 'country' => NULL, 'group' => 'Coworker', 'count' => 1),
            array('value' => 1, 'country' => NULL, 'group' => NULL, 'count' => 1),
            array('value' => 1, 'country' => 'AT', 'group' => 'Coworker', 'count' => 1),
            array('value' => 1, 'country' => 'AT', 'group' => NULL, 'count' => 1),
            array('value' => 1, 'country' => NULL, 'group' => NULL, 'count' => 1),
            array('value' => 2, 'country' => NULL, 'group' => NULL, 'count' => 1),
            array('value' => 2, 'country' => NULL, 'group' => NULL, 'count' => 1),
            array('value' => 2, 'country' => NULL, 'group' => NULL, 'count' => 1),
            array('value' => 2, 'country' => NULL, 'group' => NULL, 'count' => 1),
            array('value' => 2, 'country' => NULL, 'group' => NULL, 'count' => 1),
        );

        foreach($data as $value) {
            $heap->insert($value);
        }
        list($pad, $head) = $this->arrayTableMeta($data);
        echo $head, PHP_EOL;

        foreach($heap as $entry) {
            foreach($entry as $value) {
                echo str_pad($value, $pad, " ", STR_PAD_LEFT);
            }
            echo PHP_EOL;
        }
    }
    protected function arrayTableMeta($array) {
        $keys = array_keys($array[0]);
        $maxkeylen = 0;
        foreach($keys as $key) {
            if(($t = strlen($key)) > $maxkeylen) {
                $maxkeylen = $t;
            }
        }
        $str = NULL;
        foreach($keys as $key) {
            $str .= str_pad($key, $maxkeylen+2, " ", STR_PAD_LEFT);
        }
        return array($maxkeylen+2, $str);
    }
}
