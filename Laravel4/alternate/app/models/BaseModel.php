<?php

class BaseModel extends Eloquent {

    public static function validate($data) {
        return Validator::make($data , static::$rules);
    }
}
