<?php
// 参考URL:http://dallp.hatenablog.com/entry/20170310/1489152055

require_once __DIR__ . '/vendor/autoload.php';

// 早速クローラー書いてみた
// $cli = new Goutte\Client();
// $url = 'http://www.arukikata.co.jp/country/europe/GB/';
// $crawler = $cli->request('GET',$url);

// $crawler->filter('#cities_link .photo_list p')->each(function($name) {
//     echo $name->text() . "\n";
// });

// 第二弾: 複数ページをクロールしてみた(URL取得)
// $cli = new Goutte\Client();
// $url = 'http://www.arukikata.co.jp/country/US/';
// $crawler = $cli->request('GET',$url);

// $urls = $crawler->filter('.country_textlink .top_map .city_list a')->extract('href');
// print_r($urls);

// 第二弾: 複数ページをクロールしてみた
// $cli = new Goutte\Client();
// $url = 'http://www.arukikata.co.jp/country/US/';
// $crawler = $cli->request('GET',$url);

// $urls = $crawler->filter('.country_textlink .top_map .city_list a')->extract('href');

// foreach ($urls as $url) {
// 	$crawler = $cli->request('GET',$url);
// 	$crawler->filter('#cities_link .photo_list p')->each(function($name) {
// 		echo $name->text() . "\n";
// 	});
// }

// 最終的に完成したコード
$cli = new Goutte\Client();
$url = 'http://www.arukikata.co.jp/';
$crawler = $cli->request('GET',$url);

// グローバルナビからリンクを抽出
$urls = $crawler->filter('#header2018 #subnav a')->extract('href');

foreach($urls as $url) {
    // URLに'area'が含まれていたら地域ページ
    if (strpos($url,'area')) {
        $crawler = $cli->request('GET',$url);
        // 地域ページのエリアマップから、各国へのリンクを抽出
        $countryURLs = $crawler->filter('#area_Map a')->extract('href');

        foreach($countryURLs as $url) {
            // URLに'country'が含まれていたら国ページ
            if(strpos($url,'country')) {
                $crawler = $cli->request('GET',$url);
                // ターミナル出力時にどの国の都市か分かりやすいようにh1も抽出
                $crawler->filter('h1')->each(function($name) {
                    echo $name->text() . "\n";
                });
                // 都市リストを抽出
                $crawler->filter('#cities_link .photo_list p')->each(function($name) {
                    echo $name->text() . "\n";
                });
            }
            // ほんの少しの思いやり
            usleep(500000);
        }
    }
}