<?php
use Goutte\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $client = new Client();
    $news=[];
    $index =0 ;
    // Go to the filgoal website
$crawler = $client->request('GET', 'https://www.filgoal.com/articles');
//$crawler -> an object of all filgoal html
// Get the latest post in this category and display the titles
$crawler->filter('#list-box ul li')->each(function ($node)use(&$news ,&$index){
    
    $node->filter('a div h6')->each(function($node)use(&$news ,&$index){
        $news[$index]['title']=$node->text();
       });

    $node->filter('a div p')->each(function($node)use(&$news ,&$index){
        $news[$index]['content']= $node->text();
       });

    $node->filter('a img')->each(function($node)use(&$news ,&$index){
        if(empty($node->attr('data-src'))){
            return ;
        }
        $news[$index]['img']=  'https:'.$node->attr('data-src');
    });

$index++;
     
});
return view('welcome',compact('news'));
});
