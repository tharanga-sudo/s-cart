<?php

namespace App\Http\Controllers;

use App\Models\ShopProduct;
use App\CsvData;
use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{

    public function getImport()
    {
        $products = Product::paginate(20);
        return view('products.import.index',compact('products'));
    }

    public function parseImport(CsvImportRequest $request)
    {

        $path = $request->file('csv_file')->getRealPath();

        if ($request->has('header')) {
            $data = Excel::load($path, function ($reader) {
            })->get()->toArray();
        } else {
            $data = array_map('str_getcsv', file($path));
        }

        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }
            }
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }

        return view('products.import.import_fields', compact('csv_header_fields', 'csv_data', 'csv_data_file'));

    }

    public function processImport(Request $request)
    {
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $product = new Product();
            foreach (config('import.product.fields') as $index => $field) {
                if ($data->csv_header) {
                    $product->$field = $row[$request->fields[$field]];
                } else {
                    $product->$field = $row[$request->fields[$index]];

                }
            }
            $product->save();
        }
        $customers = Product::all();

        return view('products.import.import_success', compact('customers'));
    }

}
