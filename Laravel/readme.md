# Laravel Framework 4.2

## How to install

The Laravel framework is quite easy to setup since it uses composer :

- Clone the repository or download the laravel directory
- `composer update`
- edit app/config/database.php so it matches your database configuration.
- `php artisan migrate --seed` for creating the database and filling it with fake datas

## Libraries used for this project

**"laravel/framework": "4.2.*"**
The framework ^^

**"fzaninotto/faker": "1.5.*@dev"**
Not necessary but with this library we can fill the database using seeding with random datas

**"way/generators": "2.*",**
This library make code generation faster, like the previous library it's not needed to make Laravel work, but it makes you write code faster

**"barryvdh/laravel-debugbar": "1.*"**
A debugbar you should use to display queries and keep an eye on performances

**"graham-campbell/markdown": "2.0.*@dev"**
Used to convert markdown to HTML

**"forxer/Gravatar": "*"**
Used to generate comment avatar (I was a bit lazy here ^^)

## Notes

Here are some notes about some tips I used in this code

- For blade I created a @cacheinclude directive to include a view caching the result. There is no specific file to put this kind of logic so I put it in [global.php](https://github.com/Grafikart/BlogMVC/blob/master/Laravel/app/start/global.php)
- I created my own library [BootForm](https://github.com/Grafikart/BlogMVC/blob/master/Laravel/app/lib/Grafikart) to generate forms a bit quicker (I used it for the backend)
- All controllers dedicated to the back-end share the same "Admin" namespace. I quite like this idea at the moment. It keeps everything clean ^^.
- counter_cache doesn't exist (yet) on Eloquent so I use the model Events created and deleted to update the count field.