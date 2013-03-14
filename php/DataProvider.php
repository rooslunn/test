<?php

/**
 * Interface for news provider
 */
interface IDataProvider {
    /**
     * Searches for pattern in news provider
     * @param  string $query pattern to search for
     * @return array xml objects matching pattern in title or description
     */
    public function search_for($query);
}

/**
 * Implements news provider
 */
class RSSDataProvider implements IDataProvider {

    const FEED_URL = 'http://news.google.com/news?cf=all&ned=ru_ru&hl=ru&topic=b&output=rss';

    private function _get_feed_xml() {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => static::FEED_URL,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => array(
                "X-Requested-With: XMLHttpRequest",
                "Accept-Encoding: gzip, deflate"
            ),
            CURLOPT_RETURNTRANSFER => 1,
        ));
        return curl_exec($ch);
    }

    public function search_for($query) {
        $output = array();
        $pattern = "/\b$query\w*\b/iu";

        $feed_xml = new SimpleXMLElement($this->_get_feed_xml());
        foreach ($feed_xml->channel[0]->item as $news) {
            $title = (string) $news->title;
            $clear_description = strip_tags((string) $news->description);
            $in_title = preg_match($pattern, $title);
            $in_description = preg_match($pattern, $clear_description);
            if ($in_title || $in_description) {
                $output[] = $news;
            }
        }

        return $output;
    }
}