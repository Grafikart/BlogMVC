<?php
use \Codeception\Util\Fixtures;

$categorySlug = Fixtures::get('data:categories[0]:slug');
for ($k = 0; $k < Fixtures::get('data:posts:length'); $k++) {
    if (Fixtures::get("data:posts[$k]:author") === 1) {
        $postSlug = Fixtures::get("data:posts[$k]:slug");
        break;
    }
}
if (!isset($postSlug)) {
    throw new \RuntimeException('Couldn\'t find post written by first user.');
}
return array(
    'site/login',
    array('site/logout', 'redirects' => true,),
    'category/list',
    array('category/index', 'opts' => array('slug' => $categorySlug,),),
    'user/list',
    array('user/index', 'opts' => array('id' => 1),),
    'post/index',
    array('post/show', 'opts' => array('slug' => $postSlug,),),
    array(
        'comment/add',
        'opts' => array('postSlug' => $postSlug,),
        'expectedCode' => 400,
    ),
    array(
        'comment/ajaxAdd',
        'opts' => array('postSlug' => $postSlug, 'id' => 1),
        'expectedCode' => 400,
    ),
);