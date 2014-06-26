<?php
return array(
    'heading.categories' => 'Категории',
    'heading.lastPosts' => 'Последние записи',
    'heading.userPosts' => 'Записи {username}',
    'heading.blog' => 'Блог',
    'heading.pageNumber' => 'Страница #{n}',
    'heading.pagination' => 'Навигация',
    'heading.newCategory' => 'Добавить категорию',
    'heading.editCategory' => 'Редактировать категорию {category}',
    'heading.newPost' => 'Новая запись',
    'heading.editPost' => 'Редактировать запись',
    'heading.commentsAmount' => '{n} комментарий|{n} комментария|'.
        '{n} комментариев|{n} комментария',
    'heading.yourPosts' => 'Ваши записи',
    'heading.options' => 'Настройки',
    'heading.help' => 'Помощь',
    'heading.application' => 'Приложение',
    'heading.cachedValues' => 'Кэшированные значения',
    'heading.statistics' => 'Статистика',
    'heading.serviceStatus' => 'Статус сервиса',
    'heading.managePosts' => 'Управление записями',
    'heading.users' => 'Пользователи',
    'heading.profile' => 'Профиль',
    'heading.username' => 'Логин',
    'heading.passwordUpdate' => 'Смена пароля',
    'heading.suicideBoothSection' => 'сотритемойпрофиль-ссылка',
    'heading.pleaseSignIn' => 'Пожалуйста, войдите',
    'heading.createNewUser' => 'Создать нового пользователя',
    'heading.suicideBooth' => 'Будка для самоубийств',
    'heading.httpError' => 'Ошибка #{errorCode}',

    'pageTitle.adminPanel' => 'Панель управления',
    'pageTitle.blog' => 'Блог',
    'pageTitle.userFeed' => 'Записи {username}',
    'pageTitle.categoryList' => 'Категории',
    'pageTitle.userList' => 'Авторы',

    'control.manage' => 'Управлять',
    'control.edit' => 'Редактировать',
    'control.delete' => 'Удалить',
    'control.save' => 'Сохранить',
    'control.publish' => 'Опубликовать',
    'control.addNew' => 'Добавить новый',
    'control.add' => 'Добавить',
    'control.new' => 'Новый',
    'control.submit' => 'Отправить',
    'control.create' => 'Создать',
    'control.createNew' => 'Создать новый',
    'control.flushCache' => 'Сбросить кэш',
    'control.recalculateCounters' => 'Перерассчитать значения счетчиков '.
        'категорий',
    'control.signIn' => 'Войти',
    'control.deleteMyProfile' => 'Удалить мой профиль',

    'link.backTo' => '&lt; Назад в {pageTitle}',
    'link.backToMainFeed' => '&lt; Назад к основной ленте',
    'link.backToCategories' => '&lt; Назад к списку категорий',
    'link.backToPosts' => '&lt; Назад к записям',
    'link.edit' => 'Редактировать',
    'link.more' => 'Далее...',
    'link.readMore' => 'Читать далее...',
    'link.viewPost' => 'Просмотреть запись',
    'link.here' => 'здесь',
    'link.link' => 'ссылка',
    'link.login' => 'Войти',
    'link.logout' => 'Выйти',
    'link.adminPanel' => 'Панель управления',
    'link.blog' => 'Блог',
    'link.createNewPost' => 'Создать новую запись',
    'link.suicideBooth' => 'Пжл удалите меня',

    'text.category' => 'Категория',
    'text.onTime' => ',',
    'text.by' => ' ',
    'text.id' => 'ID',
    'text.name' => 'Название',
    'text.postCount' => 'PКоличество записей',
    'text.actions' => 'Действия',
    'text.noCategoriesFound' => 'Не найдено ни одной категории :/',
    'text.noPostsYet' => 'Записей не найдено.',
    'text.commentThisPost' => 'Комментировать эту запись',
    'text.welcomeMessage' => 'Добро пожаловать в мой блог',
    'text.sorryNoPostsYet' => 'Простите, пока не написано ни одного поста',
    'text.profileGreeting' => 'Привет, {username}!',
    'text.rss.defaultDescription' => '{appName} лента RSS.',

    'paragraph.serviceStatusCache' => 'Показываемые данные кэшируются и могут '.
        'быть устаревшими. Время жизни кэша составляет одну минуту для секции '.
        'статуса и один час для секции статистики. Впрочем, можно сбросить '.
        'кэш прямо сейчас:',
    'paragraph.userPostsAdminNotice' => 'Вы написали {postCount} '.
        'записей, которые получили {commentCount} комментариев. Вы можете '.
        'управлять ими в '.
        '<a href="{dashboardUrl}">панели управления записями</a>.',
    'paragraph.usersAdminNotice' => 'Вы можете ознакомиться с основной '.
        'информацией о пользователях и создать нового '.
        '<a href="{dashboardUrl}">здесь</a>.',
    'paragraph.userOptionsAdminNotice' => 'Если вы хотите сменить пароль или '.
        'посетить будку для самоубийств, то вам необходимо проследовать по '.
        '<a href="{dashboardUrl}">этой ссылке</a>.',
    'paragraph.serviceOptionsAdminNotice' => 'Вы также можете редактировать '.
        'настройки приложения (язык и заголовок сайта и тему) '.
        '<a href="{optionsUrl}">здесь</a>.',
    'paragraph.helpAdminNotice' => 'Вы можете ознакомиться с коротким '.
        'руководством об использовании сервиса '.
        '<a href="{helpUrl}">здесь</a>.',
    'paragraph.suicideBoothWarning' => 'Нажатие на кнопку ниже приведет к '.
        'коллапсу вашего профиля, включая все написанные записи. Если вы '.
        'стопроцентно, абсолютно и неверятно уверены в необходимости этого, '.
        'просто нажмите на кпонку ниже. Если вы по каким-то причинам '.
        'передумали, то можно просто <a href="{backLink}" class="alert-link">'.
        'вернуться на предыдущую страницу</a>.',
    'paragraph.httpError' => 'Похоже, произошла какая-то страшная ошибка. '.
        'Если вы уверены, что прошли по корректному адресу, пожалуйста, '.
        'свяжитесь с владельцем сайта.',

    'pagination.delimiter' => '...',
    'statistics.users.total' => 'Пользователей',
    'statistics.categories.total' => 'Категорий',
    'statistics.posts.total' => 'Записей, всего',
    'statistics.posts.today' => 'Записей, сегодня',
    'statistics.comments.total' => 'Комментариев, всего',
    'statistics.comments.today' => 'Комментариев, сегодня',

    'status.yiiVersion' => 'Версия Yii',
    'status.twigVersion' => 'Версия Twig',
    'status.phpVersion' => 'Версия PHP',
    'status.os' => 'Операционная система',
    'status.uptime' => 'Аптайм',
    'status.serverTime' => 'Серверное время',

    'timeInterval.ago' => '{interval} назад',
    'timeInterval.justNow' => 'только что',
    'timeInterval.seconds' => '{n} секунда|{n} секунды|{n} секунд|{n} секунды',
    'timeInterval.minutes' => '{n} минута|{n} минуты|{n} минут|{n} минуты',
    'timeInterval.hours' => '{n} час|{n} часа|{n} часов|{n} часа',
    'timeInterval.days' => '{n} день|{n} дня|{n} дней|{n} дня',
    'timeInterval.months' => '{n} месяц|{n} месяца|{n} месяцев|{n} месяца',
    'timeInterval.years' => '{n} год|{n} года|{n} лет|{n} года',
    'category.listPageTitle' => 'Список категорий',
    'category.postCount' => '{n} запись|{n} записи|{n} записей|{n} записи',

    // 'format.postDate' => 'd-m-Y',
);