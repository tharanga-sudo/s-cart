<?php
#App\Plugins\Extensions\Shipping\ShippingStandard\AppConfig.php
namespace App\Plugins\Extensions\Shipping\ShippingStandard;

use App\Plugins\Extensions\ExtensionDefault;
use App\Plugins\Extensions\Shipping\ShippingStandard\Models\ShippingStandardModel;
use App\Models\AdminConfig;
use App\Http\Controllers\Controller;
class AppConfig extends Controller
{
    use ExtensionDefault;

    protected $configGroup = 'Extensions';
    protected $configCode = 'Shipping';
    protected $configKey = 'ShippingStandard';

    public $title;
    public $version;
    public $auth;
    public $link;
    public $image;
    public $pathExtension = '';
    const ALLOW = 1;
    const DENIED = 0;
    const ON = 1;
    const OFF = 0;
    public function __construct()
    {
        $this->pathExtension = $this->configGroup . '/' . $this->configCode . '/' . $this->configKey;
        $this->title = trans($this->pathExtension.'::'.$this->configKey . '.title');
        $this->image = 'images/' . $this->pathExtension . '.png';
        $this->version = '2.0';
        $this->auth = 'Naruto';
        $this->link = 'https://s-cart.org';
    }

    public function processData()
    {
        $subtotal = \Cart::subtotal();
        $shipping = ShippingStandardModel::first();
        if ($subtotal >= $shipping->shipping_free) {
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
        } else {
            $arrData = [
                'title' => $this->title,
                'code' => $this->configKey,
                'image' => $this->image,
                'permission' => self::ALLOW,
                'value' => $shipping->fee,
                'version' => $this->version,
                'auth' => $this->auth,
                'link' => $this->link,
            ];

        }
        return $arrData;
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
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ON, //1- Enable extension; 0 - Disable
                    'detail' => $this->pathExtension.'::' . $this->configKey . '.title',
                ]
            );
            if (!$process) {
                $return = ['error' => 1, 'msg' => 'Error when install'];
            } else {
                $return = (new ShippingStandardModel)->installExtension();
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
        (new ShippingStandardModel)->uninstallExtension();
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
        return view($this->pathExtension.'::ShippingStandard')->with(
            [
                'group' => $this->configCode,
                'key' => $this->configKey,
                'title' => $this->title,
                'pathExtension' => $this->pathExtension,
                'data' => ShippingStandardModel::first(),
            ]);
    }

    public function process($data)
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = ShippingStandardModel::where('id', $data['pk'])
            ->update([$data['name'] => $data['value']]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error update'];
        }
        return $return;
    }

}
