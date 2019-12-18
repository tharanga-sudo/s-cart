<?php
$prefixSearch = sc_config('PREFIX_SEARCH')??'search';
$prefixContact = sc_config('PREFIX_CONTACT')??'contact';
$prefixNews = sc_config('PREFIX_NEWS')??'news';

Route::get('/'.$prefixSearch.$suffix, 'ShopFront@search')
->name('search');
Route::post('/subscribe', 'ContentFront@emailSubscribe')
->name('subscribe');
Route::get('/'.$prefixContact.$suffix, 'ContentFront@getContact')
->name('contact');
Route::post('/contact', 'ContentFront@postContact')
->name('contact.post');
Route::get('/'.$prefixNews.$suffix, 'ContentFront@news')
->name('news');
Route::get('/'.$prefixNews.'/{name}_{id}.html', 'ContentFront@newsDetail')
->where(['id' => '[0-9]+'])
->name('news.detail');
