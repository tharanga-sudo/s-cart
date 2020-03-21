<?php
#app/Http/Admin/Controllers/ShopTemplateOnlineController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class ShopTemplateOnlineController extends Controller
{
    public function index()
    {
            $arrTemplateLibrary = [];
            $arrTemplateLibrary[] = [
                'key' => 'template_demo',
                'name' => 'Paypal method',
                'description' => 'Demo description plugin',
                'image' => 'https://s-cart-public.s3.ap-southeast-1.amazonaws.com/member/naruto/KH4t3tPd5ywfgsTAv3NQ62YF0Tb89vrBAY7o0l9n.png',
                'path'  => 'https://s-cart-download.s3-ap-southeast-1.amazonaws.com/Plugins/Modules/template_282b741c6cf358307c00586ec15a1ad3.zip',
                'price' => '0',
                'viewed' => '110',
                'downloaded' => '20',
                'date' => '2012-11-22',
                'auth' => 'Naruto',
                'link' => 'https://s-cart.org/extension.html',
                'rate' => ['times' => 0, 'point' => '0'],
    
            ];
            $arrTemplateLibrary[] = [
                'key' => 'Paypal2',
                'name' => 'Paypal method2',
                'description' => 'Demo description plugin',
                'image' => 'https://s-cart-public.s3.ap-southeast-1.amazonaws.com/member/naruto/KH4t3tPd5ywfgsTAv3NQ62YF0Tb89vrBAY7o0l9n.png',
                'path'  => 'https://s-cart-download.s3-ap-southeast-1.amazonaws.com/Plugins/Modules/template_282b741c6cf358307c00586ec15a1ad3.zip',
                'price' => '1120',
                'downloaded' => '20',
                'date' => '2012-11-22',
                'auth' => 'Naruto',
                'link' => 'https://s-cart.org/extension.html',
                'rate' => ['times' => 10, 'point' => '33'],
    
            ];
            $arrTemplateLibrary[] = [
                'key' => 'Cash',
                'name' => 'Paypal method2',
                'description' => 'Demo description plugin',
                'image' => 'https://s-cart-public.s3.ap-southeast-1.amazonaws.com/member/naruto/KH4t3tPd5ywfgsTAv3NQ62YF0Tb89vrBAY7o0l9n.png',
                'path'  => 'https://s-cart-download.s3-ap-southeast-1.amazonaws.com/Plugins/Modules/template_282b741c6cf358307c00586ec15a1ad3.zip',
                'price' => '234',
                'downloaded' => '20',
                'date' => '2012-11-22',
                'auth' => 'Naruto',
                'link' => 'https://s-cart.org/extension.html',
                'rate' => ['times' => 10, 'point' => '33'],
    
            ];
            $page = request('page') ?? 1;
            $dataApi = file_get_contents('http://demo.s-cart.org/api/products?page[size]=115&page[number]='.$page);
            $dataApi = json_decode($dataApi, true);
    
            $resultItems = trans('product.admin.result_item', ['item_from' => $dataApi['from'] ?? 0, 'item_to' => $dataApi['to']??0, 'item_total' => $dataApi['total'] ?? 0]);
    
            $title = trans('template.admin.list');
    
            return view('admin.screen.template_online')->with(
                [
                    "title" => $title,
                    "arrTemplateLocal" => sc_get_all_template(),
                    "arrTemplateLibrary" => $arrTemplateLibrary,
                    "resultItems" => $resultItems,
                    "dataApi" => $dataApi,
                ]);

    }

    public function install()
    {
        $response = ['error' => 0, 'msg' => 'Install success'];
        $key = request('key');
        $path = request('path');
        try {
            $data = file_get_contents($path);
            $pathTmp = $key.'_'.time();
            $fileTmp = $pathTmp.'.zip';
            Storage::disk('tmp')->put($fileTmp, $data);
        } catch(\Exception $e) {
            $response = ['error' => 1, 'msg' => $e->getMessage()];
        }

        $unzip = sc_unzip(storage_path('tmp/'.$fileTmp), storage_path('tmp/'.$pathTmp));
        if($unzip) {
            File::copyDirectory(storage_path('tmp/'.$pathTmp.'/'.$key.'/public'), public_path('templates'));
            File::deleteDirectory(storage_path('tmp/'.$pathTmp.'/'.$key.'/public'));
            File::copyDirectory(storage_path('tmp/'.$pathTmp), resource_path('views/templates'));
            File::deleteDirectory(storage_path('tmp/'.$pathTmp));
            Storage::disk('tmp')->delete($fileTmp);
        } else {
            $response = ['error' => 1, 'msg' => 'error while unzip'];
        }
        return response()->json($response);
    }

}
