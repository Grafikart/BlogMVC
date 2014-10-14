## Wat?

This document lists things that are going far away from original requirements
but would be extremely nice to implement.

## Todos

* Full ajax support
* Code consistency (e.g. similar actions have to be declared in same way)
* Full-load testing (e.g. users lists are not tested with 100 users, so
pagination isn't really tested)
* Control records per page via `\Yii::app()->params['pagination'][$type]`
* Profiling everywhere
* Tracing every chunk of code
* Caching everything heavy
* Erroneous ajax calls will return valid JSON array containing errors
accompanied by status code 200. This is arguable situation, but i think that
status code 400 is much more appropriate.
* `/admin/category/:slug/edit` works, but `/admin/category/:slug` won't because
of `/admin/category/new` being the single url in that range.
* Cache admin index values (\# of posts and comments)
* Get rid of those config editors and simply place volatile values in a separate
file.