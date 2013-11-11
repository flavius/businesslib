<?php
namespace BusinessTest;
use Business;

class NumberContainer {
    protected $number;
    public function setValue($number) {
        $this->number = $number;
        return $this;
    }
    public function getValue() {
        return $this->number;
    }
}

class ObservableObjectStorageTest extends \PHPUnit_Framework_TestCase {
    public function test_SimpleNumbers() {
        $input = new \Business\ObservableObjectStorage();
        $output = new \Business\ObservableObjectStorage();
        $input->endpoint($output);
        $output->endpoint($input);
        $sum = $output->property('sum', 0);
        $min = $output->property('min', array());
        $max = $output->property('max', array());
        $average = $output->property('average', 0);
        $addObjectEvent = new \Business\Event('addObject');
        $input->on($addObjectEvent, new \Business\Future(function($input) {
            $output = $input->endpoint();
            $event = $input->event();
            $data = $event->getData();
            $output['sum'] += $data[0]->getValue();
        }));
        $input->on(new \Business\Event('removeObject'), new \Business\Future(function($input) {
            $output = $input->endpoint();
            $event = $input->event();
            $data = $event->getData();
            $output['sum'] -= $data[0]->getValue();
        }));

        $numberObjects = array();

        $sums_expected = array();
        $sums_actual = array();
        $sum = 0;
        foreach(range(0, 1) as $pos => $number) {
            $numberObj = new NumberContainer();
            $numberObjects[] = $numberObj;
            $input->addObject($numberObj->setValue($number));
            $sum += $number;
            $sums_expected[] = $sum;
            $sums_actual[] = $output['sum'];
        }
        $this->assertTrue($sums_expected == $sums_actual);

        /**
        foreach($numberObjects as $numberObj) {
            $input->removeObject($numberObj);
            $number = $numberObj->getValue();
            $sum -= $number;
            $this->assertEquals($sum, $output['sum']);
        }
        /**/
    }
}
