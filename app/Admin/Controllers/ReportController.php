<?php
#app/Http/Admin/Controllers/ReportController.php
namespace App\Admin\Controllers;

use App\Admin\Extensions\ExcelExpoter;
use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ReportController extends Controller
{
    use HasResourceActions;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index($key, Content $content)
    {
        return $content
            ->header('Index')
            ->description(' ')
            ->body($this->{$key}());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function customer()
    {
        $grid = new Grid(new User);
        $grid->id('ID')->sortable();
        $grid->name(trans('language.customer.name'))->sortable();
        $grid->email('Email')->sortable();
        $grid->phone(trans('language.customer.phone'))->sortable();
        $grid->address(trans('language.customer.address'))->display(function () {
            return $this->address1 . ' ' . $this->address2;
        });
        $grid->order_total(trans('language.customer.order_total'));
        $grid->order_amount(trans('language.customer.amount_total'))->display(function ($order_amount) {
            return number_format($order_amount);
        });

        $grid->disableCreation();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableFilter();
        $grid->disableActions();
        $grid->tools(function ($tools) {
            $tools->disableRefreshButton();
        });
        $grid->paginate(100);
        $grid->disableExport(false);
        $grid->exporter(new ExcelExpoter($function = 'dataCustomer', $filename = 'Customer list', $title = 'Export data Customer', $sheetname = 'Sheet name'));

        return $grid;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function product()
    {
        $grid = new Grid(new ShopProduct);
        $grid->id('ID')->sortable();
        $grid->sku(trans('product.sku'))->sortable();
        $grid->name(trans('product.name'));
        $grid->category()->name(trans('product.category'));
        $grid->price(trans('product.price'))->display(function ($price) {
            return number_format($price);
        })->sortable();
        $grid->stock(trans('product.stock'))->display(function ($stock) {
            return number_format($stock);
        })->sortable();
        $grid->sold(trans('product.sold'))->display(function ($sold) {
            return number_format($sold);
        })->sortable();
        $grid->view(trans('product.view'))->display(function ($view) {
            return number_format($view);
        })->sortable();

        $grid->disableCreation();
        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableFilter();
        $grid->disableActions();
        $grid->tools(function ($tools) {
            $tools->disableRefreshButton();
        });
        $grid->paginate(100);
        $grid->exporter(new ExcelExpoter('dataCustomer', 'Customer list'));

        return $grid;
    }

}
