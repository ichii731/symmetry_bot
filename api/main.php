<?php

/**
 * Twitter API Call Functions
 * @author ichii731
 */
require('vendor/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_GET['username'])) {
    print_r(request(htmlspecialchars($_GET['username'])));
} else {
    print_r('{"info":"invalid parameter"}');
}

/**
 * Return Data Array
 * @param string $username
 * @return string $json
 */
function request($_username)
{
    // Set DataTime
    $today = new DateTime();
    $today = $today->format('Y-m-d');
    $yesterday = new DateTime('-1 day');

    // Make Connection
    $connection = new TwitterOAuth($_ENV['CK'], $_ENV['CS'], $_ENV['AT'], $_ENV['AS']);

    // Get & Post Process
    $params = [
        'q' => '(from:' . $_username . ') until:' . $today . ' since:' . $yesterday->format('Y-m-d') . ' filter:images exclude:retweets',
        'result_type' => 'recent',
        'count' => '100',
        'tweet_mode' => 'extended'
    ];
    $tweets = $connection->get('search/tweets', $params)->statuses;
    foreach ($tweets as $key => $value) {
        $text = text_process($value->full_text);
        $json[$key]['text'] = $text['excerpt'] . " " . $text['url'];
        $json[$key]['image_url'] = $value->entities->media[0]->media_url_https;
    }
    $json = json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    // for dev
    //$json = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return $json;
}

function text_process($_text)
{
    // If the number of characters is more than 20, after 20 characters... after 20 characters
    $str = preg_replace('/\s+/', '', $_text);

    $text['url'] = mb_substr($str, -23);
    $excerpt = mb_substr($str, 0, -23);

    if (mb_strlen($excerpt) > 20) {
        $text['excerpt'] = mb_substr($excerpt, 0, 20) . '...';
    } else {
        $text['excerpt'] = $excerpt;
    }
    return $text;
}
