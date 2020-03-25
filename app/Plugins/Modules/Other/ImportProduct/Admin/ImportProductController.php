<?php
#app/Modules\Other\ImportProduct/Admin/ImportProductController.php
namespace App\Plugins\Modules\Other\ImportProduct\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopLanguage;
use App\Plugins\Modules\Other\ImportProduct\AppConfig;
use App\Models\ShopProduct;
use App\Models\ShopProductDescription;
use Validator;

class ImportProductController extends Controller
{
    public $languages;
    public $plugin;

    public function __construct()
    {
        $this->languages = ShopLanguage::getList();
        $this->plugin = new AppConfig;

    }

    public function index()
    {
        return view($this->plugin->pathPlugin . '::Admin.ImportProduct')
            ->with(
                [
                    'title' => trans($this->plugin->pathPlugin . '::ImportProduct.admin.title'),
                    'pathPlugin' => $this->plugin->pathPlugin,
                ]
            );

    }

    public function processData()
    {
        $data = request()->all();
        $validator = Validator::make(
            $data,
            [
                'file' => 'required|mimes:csv,txt|file|max:2048',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = request('file');
        $csv = array_map("str_getcsv", file($file->getRealPath(), FILE_SKIP_EMPTY_LINES));
        unset($csv[1]); //Uset line comment
        $keys = array_shift($csv);
        foreach ($csv as $i => $row) {
            $csv[$i] = array_combine($keys, $row);
        }
        $arrNew = [];
        $arrUpdate = [];
        $arrError = [];
        foreach (array_chunk($csv, 100) as $rows) {
            foreach ($rows as $row) {
                $sku = $row['sku'] ?? '';
                if ($sku == '') {
                    continue;
                }
                $dataUpdate = [];
                $dataUpdate['sku'] = $sku ?? '';
                $dataUpdate['image'] = $row['image'] ?? '';
                $dataUpdate['brand_id'] = (int)$row['brand_id'] ?? 0;
                $dataUpdate['vendor_id'] = (int)$row['vendor_id'] ?? 0;
                $dataUpdate['price'] = (int)$row['price'] ?? 0;
                $dataUpdate['cost'] = (int)$row['cost'] ?? 0;
                $dataUpdate['stock'] = (int)$row['stock'] ?? 0;
                $dataUpdate['sold'] = (int)$row['sold'] ?? 0;
                $dataUpdate['type'] = (int)$row['type'] ?? 0;
                $dataUpdate['kind'] = (int)$row['kind'] ?? 0;
                $dataUpdate['virtual'] = (int)$row['virtual'] ?? 0;
                $dataUpdate['status'] = (int)$row['status'] ?? 0;
                $dataUpdate['alias'] = (int)$row['alias'] ?? 0;
                $dataUpdate['view'] = (int)$row['view'] ?? 0;
                $dataUpdate['sort'] = (int)$row['sort'] ?? 0;
                if ($row['date_available']) {
                    $dataUpdate['date_available'] = $row['date_available'];
                }

                $checkProduct = (new ShopProduct)->where('sku', $sku)->first();
                if ($checkProduct) {
                    unset($dataUpdate['sku']);
                    (new ShopProduct)->where('sku', $sku)
                        ->update($dataUpdate);
                    $arrUpdate[] = $sku;
                } else {
                    (new ShopProduct)->create($dataUpdate);
                    $arrNew[] = $sku;
                }
            }
        }
        return redirect(route('admin_import_product.index'))
            ->with(compact('arrNew', 'arrUpdate', 'arrError'));
    }


    public function processDataDescription()
    {
        $data = request()->all();
        $validator = Validator::make(
            $data,
            [
                'file_des' => 'required|mimes:csv,txt|file|max:2048',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = request('file_des');
        $csv = array_map("str_getcsv", file($file->getRealPath(), FILE_SKIP_EMPTY_LINES));
        unset($csv[1]); //Uset line comment
        $keys = array_shift($csv);
        foreach ($csv as $i => $row) {
            $csv[$i] = array_combine($keys, $row);
        }
        $arrNewDes = [];
        $arrUpdateDes = [];
        $arrErrorDes = [];
        foreach (array_chunk($csv, 100) as $rows) {
            foreach ($rows as $row) {
                $sku = $row['sku'] ?? '';
                if ($sku == '') {
                    continue;
                }
                $dataUpdate = [];
                $dataUpdate['lang'] = $row['lang'] ?? 'en';
                $dataUpdate['name'] = $row['name'] ?? '';
                $dataUpdate['keyword'] = $row['keyword'] ?? '';
                $dataUpdate['description'] = $row['description'] ?? '';
                $dataUpdate['content'] = $row['content'] ?? '';
                $checkProduct = (new ShopProduct)->where('sku', $sku)->first();
                if ($checkProduct) {
                    $dataUpdate['product_id'] = $checkProduct['id'];
                    $checkDes = (new ShopProductDescription)
                        ->where('lang', $dataUpdate['lang'])
                        ->where('product_id', $checkProduct['id'])
                        ->delete();
                    (new ShopProductDescription)->insert($dataUpdate);
                    $arrNewDes[] = $sku;
                } else {
                    $arrErrorDes[] = $sku;
                }
            }
        }
        return redirect(route('admin_import_product.index'))
            ->with(compact('arrNewDes', 'arrUpdateDes', 'arrErrorDes'));
    }

    public function exportFormat()
    {
        $type = request('type');
        switch ($type) {
            case 'import_product':
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename=' . $type . '.csv');
                $output = fopen('php://output', 'w');
                $dataHeader = [
                    'sku' => 'SKU of product',
                    'image' => 'Path of image',
                    'brand_id' => 'ID of Brand',
                    'vendor_id' => 'ID of vendor',
                    'price' => 'Price is numeric',
                    'cost' => 'Cost  is numeric',
                    'stock' => 'Stock  is numeric',
                    'sold' => 'Sold  is numeric',
                    'type' => 'Type  is numeric',
                    'kind' => 'Kind is numeric',
                    'virtual' => 'Virtual is numeric',
                    'status' => 'Status: 0 off - 1 on',
                    'date_available' => 'Empty or like 2020-10-06',
                    'alias' => 'slug of the prod name ex: test-product-20g',
                    'view' => 'view',
                    'sort' => 'sort'
                ];
                $dataExample = [
                    'sku' => 'SKUDEMO_001',
                    'image' => '/data/product/img-22.jpg',
                    'brand_id' => '2',
                    'vendor_id' => '1',
                    'price' => '15000',
                    'cost' => '5000',
                    'stock' => '100',
                    'sold' => '0',
                    'type' => '0',
                    'kind' => '0',
                    'virtual' => '0',
                    'status' => '1',
                    'date_available' => '2020-10-06',
                    'alias' => 'test-product-20g',
                    'view' => '1',
                    'sort' => '1',
                ];
                fputcsv($output, array_keys($dataHeader));
                fputcsv($output, $dataHeader);
                fputcsv($output, $dataExample);
                break;

            case 'import_product_description':
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename=' . $type . '.csv');
                $output = fopen('php://output', 'w');
                $dataHeader = [
                    'sku' => 'SKU of product',
                    'lang' => 'Code of language. Ex en,vi',
                    'name' => 'Name of product',
                    'keyword' => 'Keywords',
                    'description' => 'Description',
                    'content' => 'Detail for product',
                ];
                $dataExample1 = [
                    'sku' => 'SKUDEMO_001',
                    'lang' => 'en',
                    'name' => 'Easy Polo Black Edition',
                    'keyword' => 's-cart, free',
                    'description' => '',
                    'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                ];
                $dataExample2 = [
                    'sku' => 'SKUDEMO_001',
                    'lang' => 'vi',
                    'name' => 'Phien ban mau den',
                    'keyword' => '',
                    'description' => '',
                    'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                ];
                fputcsv($output, array_keys($dataHeader));
                fputcsv($output, $dataHeader);
                fputcsv($output, $dataExample1);
                fputcsv($output, $dataExample2);
                break;

            default:
                ;
        }
        exit;
    }

}
