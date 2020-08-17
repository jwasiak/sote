<?php
class stCompatibilityOpinion {

    protected static $opinionServices = array();

    public static function show() {
        foreach (self::$opinionServices as $name => $value)
            if ($value) return true;
        return false;
    }

    public static function setOpinionService($name, $value = true) {
        self::$opinionServices[$name] = $value;
    }

    public static function hasOpinionService($name) {
        return isset(self::$opinionServices[$name]);
    }

    public static function removeOpinionService($name) {
        if(isset(self::$opinionServices[$name]))
            unset(self::$opinionServices[$name]);
    }
}
