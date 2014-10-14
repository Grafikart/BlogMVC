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
        'title' => 'Блог',
    ),
    \CategoryListPage::$url => array(
        'title' => 'Категории',
        'backTo' => 'Блог',
        'nav' => array('Управление'),
    ),
    \CategoryFeedPage::route($firstCategorySlug) => array(
        'title' => $firstCategoryTitle,
        'backTo' => 'Блог',
        'nav' => array('блог', 'категории',),
    ),
    \UserListPage::$url => array(
        'title' => 'Авторы',
        'backTo' => 'Блог',
        'nav' => array('блог',),
    ),
    \AuthorFeedPage::route(1) => array(
        'title' => 'Записи '.$firstUserLogin,
        'backTo' => 'Блог',
        'nav' => array('блог', 'авторы',)
    ),
    /*
    \LoginPage::$url => array(
        'title' => 'Вход',
        'backTo' => 'Блог',
    ),
    */
    \AdminPanelPage::$url => array(
        'title' => 'Панель управления',
        'backTo' => 'Блог',
    ),
    \PostsDashboardPage::$url => array(
        'title' => 'Управление записями',
        'backTo' => 'Панель управления',
        'nav' => array('Создать новую запись', 'Управление категориями',),
    ),
    \PostFormPage::$newPostUrl => array(
        'title' => 'Новая запись',
        'backTo' => 'Управление записями',
        'nav' => array('управление записями', 'блог',),
    ),
    \PostFormPage::route($firstPostId) => array(
        'title' => 'Запись "' . $firstPostTitle . '"',
        'backTo' => 'Управление записями',
        'nav' => array('управление записями', 'блог', 'эту запись',),
    ),
    \UsersDashboardPage::$url => array(
        'title' => 'Управление пользователями',
        'backTo' => 'Панель управления',
        'nav' => array('Создать пользователя',),
    ),
    \CreateNewUserPage::$url => array(
        'title' => 'Новый пользователь',
        'backTo' => 'Управление пользователями',
        'nav' => array('панель управления', 'управление пользователями',),
    ),
    \CategoryDashboardPage::$url => array(
        'title' => 'Управление категориями',
        'backTo' => 'Панель управления',
        'nav' => array('Создать новую',),
    ),
    \CategoryFormPage::$newCategoryUrl => array(
        'title' => 'Новая категория',
        'backTo' => 'Управление категориями',
        'nav' => array('управление категориями', 'панель управления',),
    ),
    \CategoryFormPage::route($firstCategorySlug) => array(
        'title' => 'Категория "' . $firstCategoryTitle . '"',
        'backTo' => 'Управление категориями',
        'nav' => array('управление категориями', 'панель управления',),
    ),
    \OptionsPage::$url => array(
        'title' => 'Настройки',
        'backTo' => 'Панель управления',
        'nav' => array('панель управления',),
    ),
    \ServiceStatusPage::$url => array(
        'title' => 'Статус приложения',
        'backTo' => 'Панель управления',
        'nav' => array('панель управления',),
    ),
    \ProfilePage::$url => array(
        'title' => 'Профиль',
        'backTo' => 'Панель управления',
        'nav' => array('панель управления',),
    ),
    \SuicideBoothPage::$url => array(
        'title' => 'Будка самоубийств имени Бендера Б.Родригеза',
        'backTo' => 'Профиль',
        'nav' => null,
    ),
    \HelpPage::$url => array(
        'title' => 'Помощь',
        'backTo' => 'Панель управления',
        'nav' => array('панель управления',),
    ),
    \DevHelpPage::$url => array(
        'title' => 'Расширенная помощь',
        'backTo' => 'Помощь',
        'nav' => array('помощь', 'панель управления',),
    ),
);
