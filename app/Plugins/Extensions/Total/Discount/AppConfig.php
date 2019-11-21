<?php
#App\Plugins\Extensions\Total\Discount\AppConfig.php
namespace App\Plugins\Extensions\Total\Discount;

use App\Plugins\Extensions\Total\Discount\Models\DiscountModel;
use App\Plugins\Extensions\Total\Discount\Controllers\DiscountController;
use App\Models\AdminConfig;
use App\Plugins\Extensions\ConfigDefault;
class AppConfig extends ConfigDefault
{

    protected $configKey = 'Discount';
    protected $configCode = 'Total';
    protected $configGroup = 'Extensions';

    protected $discountService;
    public function __construct()
    {
        $this->pathExtension = $this->configGroup . '/' . $this->configCode . '/' . $this->configKey;
        $this->title = trans($this->pathExtension.'::'.$this->configKey . '.title');
        $this->image = 'images/' . $this->pathExtension . '.png';
        $this->separator = false;
        $this->suffix = false;
        $this->prefix = false;
        $this->length = 8;
        $this->mask = '****-****';
        $this->discountService = new DiscountController;
        $this->version = '2.0';
        $this->auth = 'Naruto';
        $this->link = 'https://s-cart.org';

    }

    public function install()
    {
        $return = ['error' => 0, 'msg' => ''];
        $check = AdminConfig::where('key', $this->configKey)->first();
        if ($check) {
            $return = ['error' => 1, 'msg' => 'Module exist'];
        } else {
            $process = AdminConfig::insert(
                [
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'group' => $this->configGroup,
                    'sort' => 0,
                    'value' => self::ON, //Enable extension
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.title',
                ]
            );
            if (!$process) {
                $return = ['error' => 1, 'msg' => 'Error when install'];
            } else {
                $return = (new DiscountModel)->installExtension();
            }
        }

        return $return;
    }

    public function uninstall()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->delete();
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error when uninstall'];
        }
        (new DiscountModel)->uninstallExtension();
        return $return;
    }
    public function enable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->update(['value' => self::ON]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error enable'];
        }
        return $return;
    }
    public function disable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->update(['value' => self::OFF]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error disable'];
        }
        return $return;
    }
    public function config()
    {
        return redirect()->route('admin_discount.index');
    }

    public function getData()
    {
        $uID = auth()->user()->id ?? 0;
        $arrData = [
            'title' => $this->title,
            'code' => $this->configKey,
            'image' => $this->image,
            'permission' => self::ALLOW,
            'value' => 0,
            'version' => $this->version,
            'auth' => $this->auth,
            'link' => $this->link,
        ];

        $Discount = session('Discount');
        $check = json_decode($this->discountService->check($Discount, $uID), true);
        if (!empty($Discount) && !$check['error']) {
            $arrType = [
                '0' => 'Cash',
                '1' => 'Point',
                '2' => '%',
            ];
            $subtotal = \Cart::subtotal();
            $value = ($check['content']['group'] == '2') ? floor($subtotal * $check['content']['reward'] / 100) : $check['content']['reward'];
            $arrData = array(
                'title' => '<b>' . $this->title . ':</b> ' . $Discount . '',
                'code' => $this->configKey,
                'image' => $this->image,
                'permission' => self::ALLOW,
                'value' => ($value > $subtotal) ? -$subtotal : -$value,
                'version' => $this->version,
                'auth' => $this->auth,
                'link' => $this->link,
            );
        }
        return $arrData;
    }

}
