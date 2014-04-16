<?php
$i = new WebGuy($scenario);
$i->wantTo('read blog');
$i->amGoingTo('read posts from different pages on the main feed and category/author page');
$i->expectTo('see blog posts and encounter 404 on invalid pages');

$i->amOnPage('/');
$i->see('Last posts');
$i->see('Categories');
$i->see('The Route Of All Evil', 'article');
$i->dontSee('Rebirth', 'article');

$i->see('2', 'ul.pagination');
$i->click('2', 'ul.pagination');
$i->seeCurrentUrlEquals('/?page=2');
$i->see('Rebirth', 'article');
$i->dontSee('Future shock', 'article');

$i->amOnPage('/?page=3');
$i->see('Page not found');

// categories

$i->amOnPage('/');
$i->click('Category #1');
$i->seeCurrentUrlEquals('/category/category-1');
$i->seeInTitle('Category #1');
$i->see('Space Pilot 3000', 'article');
$i->see('Parasites Lost', 'article');
$i->dontSee('The Route Of All Evil', 'article');

$i->amOnPage('/category/category-1?page=2');
$i->see('Page not found');
$i->dontSeeElement('article');

// authors

$i->amOnPage('/');
$i->see('admin', 'article');
$i->click('admin', 'article');
$i->seeCurrentUrlEquals('authors/1');
$i->see('The Route Of All Evil', 'article');
$i->dontSee('Rebirth', 'article');
$i->see('2', 'ul.pagination');
$i->click('2', 'ul.pagination');
$i->seeCurrentUrlEquals('/authors/1?page=2');
$i->see('Rebirth', 'article');
$i->dontSee('Future shock', 'article');
$i->amOnPage('/authors/1?page=3');
$i->see('Page not found');
$i->dontSeeElement('article');

// commenting

$i->amOnPage('/');
$i->click('The Route Of All Evil', 'article');
$i->seeCurrentUrlEquals('/the-route-of-all-evil');
$i->see('Category #3', 'article');
$i->see('admin', 'article');