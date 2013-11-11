<?php
namespace Business;

class AnnotatedObject {
    protected static $annotationPool;
    protected $wrappedObject;
    public function __construct($wrappedObject) {
        if(NULL == self::$annotationPool) {
            self::$annotationPool = new AnnotationPool();
        }
    }
    public function setAnnotationPool(AnnotationPool $annotationPool) {
        $this->annotationPool = $annotationPool;
        if($this->wrappedObject) {
            $this->annotationPool->storeAnnotation($this->wrappedObject);
        }
    }
}
