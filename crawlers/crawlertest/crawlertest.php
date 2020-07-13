<?php
// 参考https://qiita.com/zaburo/items/45d748ae3966bf08323f
// https://github.com/FriendsOfPHP/Goutte

//ライブラリロード
require_once '../vendor/autoload.php';

//use
use Goutte\Client;
//インスタンス生成
// $client = new Client();

//取得とDOM構築
// $crawler = $client->request('GET','http://localhost:3000/crawlertest/test.html');

// //要素の取得
// $tr = $crawler->filter('table tr')->each(function($element){
//     echo $element->text()."\n";
// });

// //tr要素の取得
// $tr = $crawler->filter('table#table1 tr')->each(function($element){
//     echo $element->text()."\n";
// });

// //tr要素の取得
// $tr = $crawler->filter('table.table.hoge tr')->each(function($element){
//     echo $element->text()."\n";
// });

// //tr要素の取得
// $tr = $crawler->filter('table')->eq(0)->filter('tr')->each(function($element){
//     echo $element->text()."\n";
// });

// //tr要素の取得
// $tr = $crawler->filter('table')->eq(0)->filter('tr')->each(function($element){

//     //td要素があるときのみ取得処理を行う
//     if(count($element->filter('td'))){
//         echo $element->filter('td')->eq(1)->text()."\n";
//     }

// });

// $tr = $crawler->filter('a')->each(function($element){

//     echo $element->attr('href');

// });

// $tr = $crawler->filter('img')->each(function($element){
//     echo $element->attr('src');
// });


// Click on links:
// $client = new Client();
// $crawler = $client->request('GET', 'https://www.hoikushibank.com/');
// $link = $crawler->selectLink('東京')->link();
// $crawler = $client->click($link);
// print_r($crawler);

// Submit forms:
// $client = new Client();
// $crawler = $client->request('GET', 'https://www.hoikushibank.com/search');
// // $crawler = $client->click($crawler->selectLink('Sign in')->link());
// $form = $crawler->selectButton('検索')->form();
// $crawler = $client->submit($form, array('keyword' => 'ニチイ'));
// print_r($crawler);
// $crawler->filter('.flash-error')->each(function ($node) {
//     print $node->text()."\n";
// });