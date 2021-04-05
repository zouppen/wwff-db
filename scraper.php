<?php

class Scraper {
    function __construct($html) {
        $doc = new DOMDocument();
        libxml_disable_entity_loader(TRUE);
        libxml_use_internal_errors(TRUE);
        $doc->loadHTML($html);
        $this->xpath = new DOMXpath($doc);
    }

    function queryValue($path, $ctx = null) {
        return $this->query($path, $ctx)[0]->nodeValue;
    }

    function query($path, $ctx = null) {
        return $this->xpath->query($path, $ctx);
    }

    function scrape($def) {
        $ans = $this->queryValue($def['xpath'], $def['ctx']);
        if (array_key_exists('regex', $def)) {
            preg_match($def['regex'], $ans, $groups);
            if (array_key_exists('group', $def)) {
                $ans = $groups[$def['group']];
            } else {
                $ans = $groups[0];
            }
        }
        if (array_key_exists('test', $def)) {
            $ans = $ans === $def['test'];
        }
        return $ans;
    }

    // Dump node. Helps in debugging when you can see what the parser
    // sees. Formatted in XML style
    function dump($ctx) {
        $raw = $this->xpath->document->saveXML($ctx);
        $xml = new DOMDocument();
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;
        $xml->loadXML($raw);
        return $xml->saveXML();
    }
}

class HttpHelper {
    function __construct($cookie_file = null) {
        $opts = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_FAILONERROR => 1,
        ];
        if ($cookie_file != null) {
            $opts[CURLOPT_COOKIEFILE] = $cookie_file;
            $opts[CURLOPT_COOKIEJAR] = $cookie_file;
        }

        // Fetch HTML with cURL
        $this->ch = curl_init();
        curl_setopt_array($this->ch, $opts);
    }

    function fetch($url) {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        return curl_exec($this->ch);
    }

    function get_error() {
        return curl_error($this->ch);
    }
}
