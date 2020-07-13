<?php
// 保育士バンクから取得
// https://www.hoikushibank.com/search
// http://localhost/crawlers/hoikushibank.php

require_once '../vendor/autoload.php';
use Goutte\Client;

$base_url = 'https://www.hoikushibank.com';
$client = new Client();
$crawler = $client->request('GET', $base_url.'/search');

// 都道府県の各パスを取得
$urls = $crawler->filter('.link__list--pipe-separeted a')->extract('href');

$file = new SplFileObject("test.txt", "w");

// 沖縄でテスト
$urls = ["/okinawa"];
foreach($urls as $url) {

    $crawler = $client->request('GET',$base_url.$url);

    while(true){
        // 詳しく見るのリンクを取得
        $detail_urls = $crawler->filter('a.button.button--detail')->extract('href');

        // 詳細ページ
        // $detail_urls = ["/detail/p7816?utm_content=RFSL0000N13000N0000001"];
        foreach($detail_urls as $detail_url) {

            // urlがhttpsが含まれている場合はPRのなので飛ばす
            if(strpos($detail_url,"https") !== false){
                continue;
            }

            // 詳細ページの情報を取得
            $crawler_detail = $client->request('GET',$base_url.$detail_url);
            print_r($base_url.$detail_url."\n");
            
            // 募集園と住所を取得
            $nursery = $crawler_detail->filter('#job-posting > section:nth-child(1) > h1 > div.job-posting--heading__1')->text();
            $nursery_address = $crawler_detail->filter('#job-posting > section:nth-child(1) > h1 > div.job-posting--heading__2')->text();
            
            // 情報初期化
            $nursery_form = "";
            $nursery_url = "";
            $corporation = "";
            $corporation_url = "";

            // テーブル情報を取得
            $crawler_detail->filter('tr')->each(function($target) {
                
                global $nursery_form, $nursery_url, $corporation, $corporation_url;

                switch ($target->filter('th')->text()) {
                    case '施設形態':
                        $nursery_form = $target->filter('td')->text();
                        break;

                    case 'ホームページ':
                        $nursery_url = $target->filter('td')->text();
                        break;

                    case '法人名':
                        $corporation = $target->filter('td')->text();
                        break;

                    case 'URL':
                        $corporation_url = $target->filter('td')->text();
                        break;

                    default:
                        break;
                }
            });
            
            $file->fwrite($nursery.",".$nursery_address.",".$nursery_url.",".$corporation.",".$corporation_url.",".$nursery_form."\n");
            
            // 0.5秒待つ
            // usleep(1000000);
            usleep(500000);
        }

        // 次のページ処理
        $next_url = $crawler->filter('a.pager__link--forward')->extract('href');
        print_r($next_url[0]);

        if(empty($next_url)){
            // 次へのリンクがない場合は終了
            break;
        }

        // 次のページを取得
        $crawler = $client->request('GET','https:'.$next_url[0]);
        
        // 1秒待つ
        usleep(500000);
    }

}