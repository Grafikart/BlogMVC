<?php
return array(
    'auth.login.greeting' => 'Вы успешно вошли в систему.',
    'auth.login.fail' => 'Неправильный логин или пароль.',
    'auth.login.alreadyAuthorized' => 'Вы уже авторизованы, незачем пытаться '.
        'авторизоваться еще раз.',
    'auth.logout.goodbye' => 'Вы вышли из системы.',
    'auth.logout.guestAttempt' => 'Вы не входили в систему, зачем вы '.
        'пытаетесь выйти?',
    'profile.passwordUpdate.success' => 'Ваш пароль был успешно обновлен.',
    'profile.passwordUpdate.fail' => 'Ваш пароль не был обновлен, проверьте '.
        'форму на ошибки.',
    'profile.passwordUpdate.noData' => 'Ваш пароль не был обновлен, потому '.
        'что сервер не получил данных. Вы что, посылаете запросы вручную?',
    'profile.usernameUpdate.success' => 'Ваш новый логин был успешно сохранен.',
    'profile.usernameUpdate.fail' => 'Ваш логин не был обновлен, проверьте '.
        'форму на ошибки.',
    'profile.usernameUpdate.noData' => 'Ваш логин не был обновлен, потому что '.
        'сервер не получил данных. Вы что, посылаете запросы вручную?',
    'profile.usernameUpdate.alreadyOwned' => 'Указанный логин и без того '.
        'принадлежит вам.',
    'cache.lifespanNotice' => 'Эти данные могут быть кэшированы. Срок жизни '.
        'кэша составляет {lifespan}.',
    'cache.afterFlush' => 'Кэш сброшен. Он будет регенерирован для каждого '.
        'кэшируемого ресурса при запросе этого ресурса.',
    'deletion.goodbye' => 'Это было приятное знакомство.',
    'comment.submit.success' => 'Ваш комментарий был успешно добавлен.',
    'comment.submit.fail' => 'Ваш комментарий не был добавлен.',
    'comment.delete' => 'Комментарий был успешно удален.',
    'post.submit.success' => 'Ваша запись была успешно сохранена.',
    'post.submit.fail' => 'Ваша запись не была сохранена, проверьте форму на '.
        'ошибки.',
    'post.delete.success' => 'Ваша запись "{postTitle}" была успешно удалена.',
    'post.update.success' => 'Ваша запись "{postTitle}" была успешно обновлена',
    'user.creation.success' => 'Пользователь {user} был успешно создан.',
    'user.creation.fail' => 'Пользователь не был создан, проверьте форму на '.
        'ошибки.',
    'category.recalculated' => 'Счетчики категорий были перерасчитаны.',
    'category.submit.success' => 'Категория {category} была успешно создана.',
    'category.submit.failure' => 'Категория не была создана, проверьте форму '.
        'на ошибки.',
    'category.update.success' => 'Категория {category} была обновлена.',
    'category.update.fail' => 'категория {category} не была обновлена, '.
        'проверьте форму на ошибки.',
    'category.delete.success' => 'Категория {categoryTitle} была успешно '.
        'удалена.',
    'category.delete.notEmpty' => 'Категория {categoryTitle} содержит записи '.
        'и не может быть удалена.',
    'category.delete.doesNotExist' => 'Категория не существует и не может '.
        'быть удалена',
    'category.delete.fail' => 'Категория {categoryTitle} не удалось удалить '.
        'неизвестной причине.',
    'options.update.success' => 'Настройки приложения были обновлены.',
    'options.update.fail' => 'Настрйоки приложения не были обновлены.',
);
