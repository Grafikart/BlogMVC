<?php

App::uses('Model', 'Model');

class AppModel extends Model {

    public $recursive = -1;
    public $actsAs = array('Containable');

}
