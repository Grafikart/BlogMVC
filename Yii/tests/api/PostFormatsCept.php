<?php
/** @todo make this ducking thing work */

use Codeception\Util\Fixtures;

/** @type \Codeception\Scenario $scenario */
$scenario->groups('api', 'content');
$scenario->skip('XML and RSS checking is still not implemented');

$I = new ApiGuy($scenario);
$I->wantTo(
    'Verify that posts are displayed correctly in json, xml and rss formats'
);

$totalPostsNumber = Fixtures::get('data:posts:length');
$lastPage = ceil($totalPostsNumber / 5);
$nonexistingPage = $lastPage + 1;
$firstCategorySlug = Fixtures::get('data:categories[0]:slug');

$urls = array(
    \BlogFeedPage::$url,
    \AuthorFeedPage::route(1),
    \CategoryFeedPage::route($firstCategorySlug),
);

foreach ($urls as $url) {
    $I->amOnPage($url . '?format=json');
    $I->seeResponseIsJson();
    $I->amOnPage($url . '?format=json&page=' . $lastPage);
    $I->seeResponseIsJson();
    $I->amOnPage($url . '?format=json&page=' . $nonexistingPage);
    $I->seeResponseCodeIs(404);
    /** @todo wouldn't it be cooler to return the last page on -1, penultimate page
     * on -2 and so on? */
    $I->amOnPage($url . '?format=json&page=-1');
    $I->seeResponseCodeIs(400);

    $I->amOnPage($url . '?format=xml');

    $I->seeResponseContains('<posts>');
    $I->assertNotEmpty($xml->posts);

    $I->amOnPage($url . '?format=xml&page=' . $lastPage);
    $response = $I->grabResponse();
    $xml = new \SimpleXMLElement($response);
    $I->assertNotEmpty($xml->posts);

    $I->amOnPage($url . '?format=xml&page=' . $nonexistingPage);
    $I->seeResponseCodeIs(404);
    $I->amOnPage($url . '?format=xml&page=-1');
    $I->seeResponseCodeIs(400);

    $I->amOnPage($url . '?format=rss');
    $response = $I->grabResponse();
    $rss = new \SimpleXMLElement($response);
    $I->assertNotEmpty($rss->channel);
    $I->assertNotEmpty($rss->channel->children());
    $I->amOnPage($url . '?format=rss&page=' . $lastPage);
    $I->seeResponseCodeIs(400);
    $I->amOnPage($url . '?format=rss&page=' . $nonexistingPage);
    $I->seeResponseCodeIs(400);
    $I->amOnPage($url . '?format=rss&page=-1');
    $I->seeResponseCodeIs(400);
}

//$scenario->skip('Test is unfinished: response content isn\'t checked at all');
//$scenario->skip('Test is unfinished: author and category pages aren\'t checked at all');