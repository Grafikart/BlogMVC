# Help

## Overview

This is a lightweight blogging platform made as a part of 
[BlogMVC](http://blogmvc.com) project.

## The system

### Markdown

Everything - posts, comments and help pages - are formatted with the help of
[Markdown](http://wikipedia.org/wiki/Markdown), a simple markup language.
Markdown is much less clumsy than plain HTML, and if you haven't worked with
it before, you will adapt easily. Original Markdown syntax description can be
accessed by [this link](http://daringfireball.net/projects/markdown/syntax).  
You can also check this page source in `docs/help.md` (path is mentioned
relatively to application root).

### Users

This platform doesn't use any hierarchical role system: there is no site admin
who has more privileges than others. Any user can create another user in the
[dashboard](/admin/users), but any user may edit or delete only himself (apart
from he or she deletes other user directly from database, of course).

### Posts and comments

Every user may post (or not post, if he wishes so) new posts. Every post belongs
to a single category and will appear at main and corresponding category pages
instantly after it was submitted. 
Post controls are quite simple: one category, no tags, Markdown syntax, no
"comments open/closed" flag. Any post modifications may be done only by it's
owner.  
Comments can be written by virtually anyone: the only difference is that system
will put an `@` sign before name of unregistered user.

### Under the hood

This platform is built on top of [Yii Framework](http://yiiframework.com) with
[Twig](http://twig.sensiolabs.org/). There is a special
[status page](/admin/options/status) which will tell you more about installed
software and also reveal some statistics.
If you want to know more about under-the-hood processes and extending, you
should check with [extended help guide](/admin/help/dev), which will shed the
light on some details.