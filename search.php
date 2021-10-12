<?php
class SynoDLMSearchMiobt
{
    private $baseUrl = 'http://www.miobt.com/rss-';
    private $categoryPrefix = 'miobt-';

    public function __construct()
    {
    }
    public function prepare($curl, $query)
    {
        $url = $this->baseUrl . urlencode($query) . '.xml';
        curl_setopt($curl, CURLOPT_URL, $url);
    }
    public function parse($plugin, $response)
    {
        $xml = simplexml_load_string($response);
        $count = 0;
        foreach ($xml->channel->item as $child) {
            $title = (string)$child->title;
            $download = (string)$child->enclosure['url'];
            $datetime = (string)$child->pubDate;
            $page = (string)$child->guid;
            $category = (string)$child->category;
            $count++;
            $plugin->addResult($title, $download, '0', $datetime, $page, '', '0', '0', $this->categoryPrefix.$category);
        }
        return $count;
    }
}
