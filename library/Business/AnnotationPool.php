<?php
namespace Business;

class AnnotationPool {
    const KLASS = "__CLASS__";
    const METHOD = "__METHOD__";
    const PARAMS = "__PARAMS__";

    public function storeAnnotation($object) {
        if(!is_object($object)) {
            throw new Exception();
        }
        $className = get_class($object);
        if(!isset(self::$pool[$className])) {
            self::$pool[$className] = new \ReflectionClass($object);
        }
    }
}
