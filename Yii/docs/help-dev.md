# Dev-help

This page describes extending options for application.

## Yii

This application was built with Yii 1.1.14. This means that it can be extended
in every way Yii supports - extensions, widgets (it's nearly the same syntax in
Twig), custom parameters in config.
This application was built as a part of *contest-like* project, so feel free to
explore, rewrite, tear and break everything down or build something using
application components.
The only thing i have to mention is that config is rewritten every time
application name or language is switched on [options page](/admin/options), so
there's no point in leaving comments in it.

## Theming

As stated above, this application is run with the help of Yii, so
[same rules apply](http://www.yiiframework.com/doc/guide/1.1/en/topics.theming)
(except for using Twig). You'll want to place your theme files in
`public/skins/{{ your skin name }}` folder and activate your theme by setting
`theme => 'your skin name'` in configuration root. Then you can overriding
default templates with yours placed in `public/skins/{{ your skin name }}/views`
folder (just use the same names and everything will be ok). You can also safely
point to your new assets placed in your skin folder: site root is pointing to
the `public/` application folder.

## Proper cache

This application uses file cache by default, and that is definitely not a
recommended option. To use a proper caching engine, just open
`config/front.php` file and update cache settings according to
[Yii manual](http://www.yiiframework.com/doc/guide/1.1/en/caching.overview).

## Q? A.

### Q: The common way for Yii to render a template is to put `$content` into rendered layout. Why i don't see anything like that in templates?

**A**: Because it wouldn't let me use twig inheritance. Layout template can
access controller, but can't receive data as usual template from `render()`
method. At one moment i've realized that i don't want to put pagination widget
separately in any template that needs it and it easier just to suppress
pagination generation when no data has arrived. So long story short: Twig made
me do it.

### Q: Original BlogMVC requirement was to build an application that handles *only* required minimum. Why have you built something that goes beyond that?

**A**: To be honest, i've built this application to fill my
[github profile](https://github.com/etki). I needed something as finished as
possible, i've polished the project all the time i could, i blew dust off my
[PHP CI](https://github.com/Block8/PHPCI) install, i've learned
[Codeception](https://github.com/Codeception/Codeception), attached
[Twig](https://github.com/fabpot/Twig) and ran all the tests i could, i've made
my migrations compatible for several db engines and created a test to locate
missing translations.
Also, this application will serve me as my own blog until i finally code my own
website, so i am double-interested to make everything as good as possible.
So, i was not building an application that just *can run*, i was building
something that would be *usable*.

### Q: You did something wrong, Yii has a native tool for that!

**A**: I'm afraid i'm a conservative type guy. It's hard for me to learn new
things if i know the older way around. So, in a couple of places i intentionally
did not use Yii tools or even didn't know about them. Actually, i've rewritten
and thrown pieces of code during development just because i discovered ways to
do same thing in more elegant or native manner.

### Q: I have more questions / i have a suggestion / i want to hug you

**A**: Most possibly i won't develop this application any further (and, i hope,
you downloaded this application not from my but from Grafikart's
[BlogMVC repo](https://github.com/Grafikart/BlogMVC)), but feel free
to contact me at [vk](http://vk.com/fikey) or
[twitter](https://twitter.com/flickpicker). There is also a constantly growing
possibility that i have finished one (or both) of my personal websites,
[ambinight](http://ambinight.com) and [etki.name](http://etki.name).