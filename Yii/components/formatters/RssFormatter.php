<?php

/**
 * Represents posts feed as RSS document.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class RssFormatter
{
    /**
     * Transforms array of posts into RSS document.
     *
     * @param \Post[] $posts Post feed.
     *
     * @return string RSS document.
     * @since 0.1.0
     */
    public function format(array $posts)
    {
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $xml = new \SimpleXMLElement('<rss version="2.0"/>');
        $channel = $xml->addChild('channel');
        foreach ($this->getChannelParams() as $key => $value) {
            $channel->addChild($key, $value);
        }
        foreach ($posts as $post) {
            $item = $channel->addChild('item');
            $url = $app->createAbsoluteUrl(
                'post/show',
                array('slug' => $post->slug)
            );
            $pubDate = new \DateTime($post->created);

            $item->title = $post->name;
            $item->link = $url;
            $item->description = $post->rendered;
            $item->pubDate = $pubDate->format(\DateTime::RSS);
        }
        return $xml->asXML();
    }

    /**
     * Returns set of channel parameters.
     *
     * @return string[] Channel parameters.
     * @since 0.1.0
     */
    protected function getChannelParams()
    {
        /** @type \CWebApplication $app */
        $app = \Yii::app();
        $appParams = $app->getParams();
        $rssParams = isset($appParams['rss'])?$appParams['rss']:array();
        $items = array(
            'title' => $app->name,
            'link' => $app->getBaseUrl(true),
            'language' => $app->getLanguage(),
            'generator' => $app->getId(),
            'docs' => 'http://blogs.law.harvard.edu/tech/rss',
        );
        if (isset($rssParams['description'])) {
            $items['description'] = $rssParams['description'];
        } else {
            $items['description'] = \Yii::t(
                'templates',
                'text.rss.defaultDescription',
                array(
                    '{appName}' => $items['title'],
                    '{baseUrl}' => $items['link'],
                )
            );
        }
        return $items;
    }
}
 