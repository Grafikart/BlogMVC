<?php
class Comment extends AppModel{

    public $order = 'Comment.created DESC';

    // Data validations
    public $validate = array(
        'username' => 'notEmpty',
        'content'  => 'notEmpty',
        'mail'     => array(
            'rule'    => 'email',
            'message' => 'Mail not valid :('
        ),
    );

}