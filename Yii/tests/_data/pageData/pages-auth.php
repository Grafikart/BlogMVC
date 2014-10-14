<?php
use \Codeception\Util\Fixtures;
for ($k = 0; $k < Fixtures::get('data:posts:length'); $k++) {
    if (Fixtures::get("data:posts[$k]:author") === 1) {
        $postSlug = Fixtures::get("data:posts[$k]:slug");
        $postId = $k + 1;
        break;
    }
}
if (!isset($postSlug, $postId)) {
    throw new \RuntimeException('Couldn\'t find post written by first user.');
}
$firstCategorySlug = Fixtures::get('data:categories[0]:slug');

return array(
    'admin/index',
    'admin/help',
    'admin/devHelp',
    'admin/options',
    'admin/flushCache',
    'admin/status',
    'admin/recalculate',
    'user/dashboard',
    'user/new',
    'user/profile',
    'user/suicide',
    'user/updateUsername',
    'user/updatePassword',
    'post/dashboard',
    'post/new',
    array('post/checkSlug', 'opts' => array('slug' => 'sluggity',),),
    array('post/edit', 'opts' => array('id' => $postId,),),
    array('post/delete', 'opts' => array('id' => $postId,),),
    'category/dashboard',
    array('category/edit', 'opts' => array('slug' => $firstCategorySlug),),
    array('category/save', 'opts' => array('slug' => $firstCategorySlug),),
    array('category/delete', 'opts' => array('slug' => $firstCategorySlug),),
    array(
        'comment/delete',
        'opts' => array('postSlug' => $postSlug, 'id' => 1),
    ),
);
