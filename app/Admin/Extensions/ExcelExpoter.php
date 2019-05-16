<?php

namespace App\Admin\Extensions;

use App\User;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelExpoter extends AbstractExporter
{
    public $filename;
    public $sheetname;
    public $limit;
    public $title;
    public $function;
    public function __construct($function = null, $filename = 'Export File', $title = "Title export", $sheetname = 'Sheet')
    {
        $this->filename  = $filename;
        $this->sheetname = $sheetname;
        $this->title     = $title;
        $this->function  = $function;

    }

    public function export()
    {
        if ($this->function == null) {
            $dataExport = $this->getData();
            $header     = true;
        } else {
            $dataExport = $this->{$this->function}();
            $header     = false;
        }

        $spreadsheet = new Spreadsheet();

        $worksheet = $spreadsheet->getActiveSheet();

        $worksheet->setTitle($this->sheetname);
        $worksheet->getCell('A1')->setValue($this->title);
        $worksheet->fromArray($dataExport, $nullValue = null, $startCell = 'A2');
        $writer = IOFactory::createWriter($spreadsheet, "Xls");
        // $writer->save('write.xls');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $this->filename . '.xls"');
        header('Cache-Control: max-age=0');
        $writer->save("php://output");
    }

    public function dataOrder()
    {
        $data     = $this->getData();
        $dataRows = [];
        foreach ($data as $key => $value) {
            $dataRows[] = [
                '#' . $value['id'],
                (int) $value['subtotal'],
                (int) $value['shipping'],
                (int) $value['discount'],
                (int) $value['total'],
                ($value['user_id']) ? 'Đã đăng ký' : 'Chưa đăng ký',
                !empty($value['customer']['email']) ? $value['customer']['email'] : 'N/A',
                $value['toname'],
                $value['address1'] . ' ' . $value['address2'],
                $value['phone'],
                $value['comment'],
                $value['created_at'],

            ];
        }

        $arrTitle = ['Số Order', 'Tổng tiền hàng', 'Tiền ship', 'Tiền giảm giá', 'Tổng tiền', 'ID khách hàng', 'Email', 'Tên người nhận', 'Địa chỉ', 'Số điện thoại', 'Ghi chú', 'Ngày tạo'];
        return array_merge([$arrTitle], $dataRows);
    }

    public function dataCustomer()
    {
        $data     = $this->getData();
        $dataRows = [];
        foreach ($data as $key => $value) {
            $dataRows[] = [
                $value['id'],
                $value['name'],
                $value['email'],
                $value['address1'] . ' ' . $value['address2'],
                $value['phone'],
                $value['created_at'],
            ];
        }

        $arrTitle = ['ID', 'Tên', 'Email', 'Địa chỉ', 'Số điện thoại', 'Ngày tạo'];
        return array_merge([$arrTitle], $dataRows);
    }

    public function dataCustomer_report()
    {
        $data     = $this->getData();
        $dataRows = [];
        foreach ($data as $key => $value) {
            $orders       = User::find($value['id'])->orders;
            $total_order  = $orders->count();
            $total_amount = 0;
            foreach ($orders as $key => $order) {
                $total_amount += $order->total;
            }
            $dataRows[] = [
                $value['id'],
                $value['name'],
                $value['email'],
                $value['address1'] . ' ' . $value['address2'],
                $value['phone'],
                $total_order,
                number_format($total_amount),

                $value['created_at'],
            ];
        }
        $arrTitle = ['ID', 'Tên', 'Email', 'Địa chỉ', 'Số điện thoại', 'Tổng đơn hàng', 'Tiển tiền hàng', 'Ngày tạo'];
        return array_merge([$arrTitle], $dataRows);
    }
}
