<?php
use \Codeception\Util\Fixtures;

$firstCategorySlug = Fixtures::get('data:categories[0]:slug');
$firstCategoryTitle = Fixtures::get('data:categories[0]:title');
$firstUserLogin = Fixtures::get('data:users[0]:login');
for ($k = 0; $k < Fixtures::get('data:posts:length'); $k++) {
    if (Fixtures::get("data:posts[$k]:author") === 1) {
        $firstPostTitle = Fixtures::get("data:posts[$k]:title");
        $firstPostSlug = Fixtures::get("data:posts[$k]:slug");
        $firstPostId = $k + 1;
        break;
    }
}
if (!isset($firstPostTitle, $firstPostId, $firstPostSlug)) {
    throw new \RuntimeException('Couldn\'t find post written by first user.');
}

return array(
    \BlogFeedPage::$url => array(
        'title' => 'Blog',
    ),
    \CategoryListPage::$url => array(
        'title' => 'Categories',
        'backTo' => 'Blog',
        'nav' => array('Manage',),
    ),
    \CategoryFeedPage::route($firstCategorySlug) => array(
        'title' => $firstCategoryTitle,
        'backTo' => 'Blog',
        'nav' => array('Blog', 'Categories',),
    ),
    \UserListPage::$url => array(
        'title' => 'Authors',
        'backTo' => 'Blog',
        'nav' => array('Blog',),
    ),
    \AuthorFeedPage::route(1) => array(
        'title' => $firstUserLogin.'\'s posts',
        'backTo' => 'Blog',
        'nav' => array('Blog', 'Authors')
    ),
    /*
    \LoginPage::$url => array(
        'title' => 'Login',
        'backTo' => 'Blog',
    ),
    */
    \AdminPanelPage::$url => array(
        'title' => 'Admin panel',
        'backTo' => 'Blog',
    ),
    \PostsDashboardPage::$url => array(
        'title' => 'Posts management',
        'backTo' => 'Admin panel',
        'nav' => array('Create new post',),
    ),
    \PostFormPage::$newPostUrl => array(
        'title' => 'New post',
        'backTo' => 'Posts management',
        'nav' => array('Posts management', 'Blog',),
    ),
    \PostFormPage::route($firstPostId) => array(
        'title' => 'Edit '.$firstPostTitle,
        'backTo' => 'Posts management',
        'nav' => array('Posts management', 'Blog', 'This post',),
    ),
    \UsersDashboardPage::$url => array(
        'title' => 'Users management',
        'backTo' => 'Admin panel',
        'nav' => array('Create user',),
    ),
    \CreateNewUserPage::$url => array(
        'title' => 'New user',
        'backTo' => 'Users management',
        'nav' => array('Admin panel', 'Users management',),
    ),
    \CategoryDashboardPage::$url => array(
        'title' => 'Categories management',
        'backTo' => 'Admin panel',
        'nav' => array('Create new',),
    ),
    \CategoryFormPage::$newCategoryUrl => array(
        'title' => 'New category',
        'backTo' => 'Categories management',
        'nav' => array('Categories management', 'Admin panel',),
    ),
    \CategoryFormPage::route($firstCategorySlug) => array(
        'title' => 'Edit category '.$firstCategoryTitle,
        'backTo' => 'Categories management',
        'nav' => array('Categories management', 'Admin panel',),
    ),
    \OptionsPage::$url => array(
        'title' => 'Options',
        'backTo' => 'Admin panel',
        'nav' => array('Admin panel',),
    ),
    \ServiceStatusPage::$url => array(
        'title' => 'Application status',
        'backTo' => 'Admin panel',
        'nav' => array('Admin panel',),
    ),
    \ProfilePage::$url => array(
        'title' => 'Profile',
        'backTo' => 'Admin panel',
        'nav' => array('Admin panel',),
    ),
    \SuicideBoothPage::$url => array(
        'title' => 'Stop\'n\'Drop suicide booth',
        'backTo' => 'Profile',
        'nav' => null,
    ),
    \HelpPage::$url => array(
        'title' => 'Help',
        'backTo' => 'Admin panel',
        'nav' => array('Admin panel',),
    ),
    \DevHelpPage::$url => array(
        'title' => 'Extended help',
        'backTo' => 'Help',
        'nav' => array('Help', 'Admin panel',),
    ),
);
