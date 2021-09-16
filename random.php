<?php
/*
hikakin/seikin sym bot_system
MIT Licenced by ©2021 ichiiP
Unauthorized use is prohibited. Please contact the author when using it.
Author:@ichii731 | https://ic731.net
*/

//Auto Loading  
require('vendor/autoload.php');

// Using Composer Libs
use Abraham\TwitterOAuth\TwitterOAuth;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Define Authification Key
$CK = $_ENV['CK'];
$CS = $_ENV['CS'];
$AT = $_ENV['AT'];
$AS = $_ENV['AS'];

// Set DataTime
$today = new DateTime('-1 day');
$yesterday = new DateTime('-2 day');

// Make Connection
$connection = new TwitterOAuth($CK, $CS, $AT, $AS);

// Get & Post Process
$params = ['q' => '(from:@randomseikin2) until:' . $today->format('Y-m-d') . ' since:' . $yesterday->format('Y-m-d') . ' filter:images', 'result_type' => 'recent', 'count' => '1'];

$tweets = $connection->get('search/tweets', $params)->statuses;
foreach ($tweets as $val1) {
    foreach ($val1->extended_entities->media as $val2) {
        $title = 'Tweet from hikakin(@hikakin) ID: ' . $val1->id;
        if ($val2->media_url_https == '') {
        } else {
            download_image($val2->media_url_https, $val1->id);
            exec('python3 sym.py ' . $val1->id);
            $out_images = glob('out_img/' . $val1->id . '/*');
            if (count($out_images) == 0) {
                $imageId1 = $connection->upload('media/upload', ['media' => 'tmp_img/' . $val1->id . '/default.jpg']);
                $tweet = [
                    'status' => '画像から顔の認識ができませんでした' . '/' . $title,
                    'media_ids' => implode(',', [
                        $imageId1->media_id_string
                    ])
                ];
                $res = $connection->post('statuses/update', $tweet);
                rmrf('tmp_img/' . $val1->id);
                rmrf('out_img/' . $val1->id);
            } elseif (count($out_images) == 1) {
                $imageId1 = $connection->upload('media/upload', ['media' => 'tmp_img/' . $val1->id . '/default.jpg']);
                $imageId2 = $connection->upload('media/upload', ['media' => $out_images[0]]);
                $tweet = [
                    'status' => $title,
                    'media_ids' => implode(',', [
                        $imageId1->media_id_string,
                        $imageId2->media_id_string
                    ])
                ];
                $res = $connection->post('statuses/update', $tweet);
                // 削除
                rmrf('tmp_img/' . $val1->id);
                rmrf('out_img/' . $val1->id);
            } elseif (count($out_images) == 2) {
                $imageId1 = $connection->upload('media/upload', ['media' => 'tmp_img/' . $val1->id . '/default.jpg']);
                $imageId2 = $connection->upload('media/upload', ['media' => $out_images[0]]);
                $imageId3 = $connection->upload('media/upload', ['media' => $out_images[1]]);
                $tweet = [
                    'status' => $title,
                    'media_ids' => implode(',', [
                        $imageId1->media_id_string,
                        $imageId2->media_id_string,
                        $imageId3->media_id_string
                    ])
                ];
                $res = $connection->post('statuses/update', $tweet);
                // 削除
                rmrf('tmp_img/' . $val1->id);
                rmrf('out_img/' . $val1->id);
            } elseif (count($out_images) == 3) {
                $imageId1 = $connection->upload('media/upload', ['media' => 'tmp_img/' . $val1->id . '/default.jpg']);
                $imageId2 = $connection->upload('media/upload', ['media' => $out_images[0]]);
                $imageId3 = $connection->upload('media/upload', ['media' => $out_images[1]]);
                $imageId4 = $connection->upload('media/upload', ['media' => $out_images[2]]);
                $tweet = [
                    'status' => $title,
                    'media_ids' => implode(',', [
                        $imageId1->media_id_string,
                        $imageId2->media_id_string,
                        $imageId3->media_id_string,
                        $imageId4->media_id_string
                    ])
                ];
                $res = $connection->post('statuses/update', $tweet);
                // 削除
                rmrf('tmp_img/' . $val1->id);
                rmrf('out_img/' . $val1->id);
            }
        }
    }
}


// Image Download Process via Twitter
function download_image($url, $id)
{
    $file_name = 'default.jpg';
    mkdir('tmp_img/' . $id);
    $image = file_get_contents($url);
    $save_path = 'tmp_img/' . $id . '/' . $file_name;
    file_put_contents($save_path, $image);
}

// dFile Delete Function
function rmrf($dir)
{
    if (is_dir($dir) and !is_link($dir)) {
        array_map('rmrf',   glob($dir . '/*', GLOB_ONLYDIR));
        array_map('unlink', glob($dir . '/*'));
        rmdir($dir);
    }
}
