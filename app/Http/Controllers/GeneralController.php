<?php
#app/Http/Controller/GeneralController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopSubscribe;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function __construct()
    {
        $languages = sc_language_all();
        $currencies = sc_currency_all();
        $blocksContent = sc_block_content();
        $layoutsUrl = sc_link();
        view()->share('languages', $languages);
        view()->share('currencies', $currencies);
        view()->share('blocksContent', $blocksContent);
        view()->share('layoutsUrl', $layoutsUrl);
    }

    /**
     * Process email subscribe
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function emailShop(Request $request)
    {
        $data = $request->all();
        $validator = $request->validate(
            ['subscribe_email' => 'required|email'], 
            [
            'subscribe_email.required' => trans('validation.required'),
            'subscribe_email.email' => trans('validation.email'),
            ]
        );

        $checkEmail = ShopSubscribe::where('email', $data['subscribe_email'])
            ->first();
        if (!$checkEmail) {
            ShopSubscribe::insert(['email' => $data['subscribe_email']]);
        }
        return redirect()->back()
            ->with(['message' => trans('front.subscribe.subscribe_success')]);
    }

    /**
     * Default page not found
     *
     * @return  [type]  [return description]
     */
    public function pageNotFound()
    {
        return view(
            'templates.' . sc_store('template') . '.notfound',
            [
            'title' => '404 - Page not found',
            'msg' => trans('front.page_not_found'),
            'description' => '',
            'keyword' => ''
            ]
        );
    }

    /**
     * Default item not found
     *
     * @return  [type]  [return description]
     */
    public function itemNotFound()
    {
        return view(
            'templates.' . sc_store('template') . '.notfound',
            [
                'title' => '404 - Item not found',
                'msg' => trans('front.item_not_found'),
                'description' => '',
                'keyword' => '',
            ]
        );
    }

}
