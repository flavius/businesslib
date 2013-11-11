<?php
namespace Business;

interface Reflective {
    public function availableProperties();
    public function propertyComparer($propertyName, $object);
}
