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

// Make Connection
$connection = new TwitterOAuth($CK, $CS, $AT, $AS);


// 動画データベースから情報取得
$file = "database/hikakin.json";
$json = file_get_contents($file);
$json = json_decode($json, true);
$val = array_rand($json, 1);
$title = $json[$val]['snippet']['title'];
$videoid = $json[$val]['id']['videoId'];
$url = "https://youtube.com/watch?v=" . $videoid;
$image_url = "https://i.ytimg.com/vi/" . $videoid . "/maxresdefault.jpg";


        $title = '【過去動画データベースより取得】 ' . $title . " / " . $url;

            download_image($image_url, $videoid);
            exec('python3 sym.py ' . $videoid);
            $out_images = glob('out_img/' . $videoid . '/*');
            $in_images = glob('tmp_img/' . $videoid . '/*');
            if (count($in_images) == 0) {
                
            } else if (count($out_images) == 0) {
                $imageId1 = $connection->upload('media/upload', ['media' => 'tmp_img/' . $videoid . '/default.jpg']);
                $tweet = [
                    'status' => '画像から顔の認識ができませんでした' . '/' . $title,
                    'media_ids' => implode(',', [
                        $imageId1->media_id_string
                    ])
                ];
                $res = $connection->post('statuses/update', $tweet);
                rmrf('tmp_img/' . $videoid);
                rmrf('out_img/' . $videoid);
            } elseif (count($out_images) == 1) {
                $imageId1 = $connection->upload('media/upload', ['media' => 'tmp_img/' . $videoid . '/default.jpg']);
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
                rmrf('tmp_img/' . $videoid);
                rmrf('out_img/' . $videoid);
            } elseif (count($out_images) == 2) {
                $imageId1 = $connection->upload('media/upload', ['media' => 'tmp_img/' . $videoid . '/default.jpg']);
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
                rmrf('tmp_img/' . $videoid);
                rmrf('out_img/' . $videoid);
            } elseif (count($out_images) == 3) {
                $imageId1 = $connection->upload('media/upload', ['media' => 'tmp_img/' . $videoid . '/default.jpg']);
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
                rmrf('tmp_img/' . $videoid);
                rmrf('out_img/' . $videoid);
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
