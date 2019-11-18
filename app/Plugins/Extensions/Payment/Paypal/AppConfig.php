<?php
#App\Plugins\Extensions\Payment\Paypal\AppConfig.php
namespace App\Plugins\Extensions\Payment\Paypal;

use App\Plugins\Extensions\ExtensionDefault;
use App\Models\AdminConfig;
use App\Models\ShopOrderStatus;
use App\Http\Controllers\Controller;
class AppConfig extends Controller
{
    use ExtensionDefault;

    protected $configGroup = 'Extensions';
    protected $configCode = 'Payment';
    protected $configKey = 'Paypal';
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
    const ORDER_STATUS_PROCESSING = 2;
    const ORDER_STATUS_FAILD = 6;

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
        $arrData = [
            'title' => $this->title,
            'code' => $this->configKey,
            'image' => $this->image,
            'permission' => self::ALLOW,
            'version' => $this->version,
            'auth' => $this->auth,
            'link' => $this->link,
        ];
        return $arrData;
    }

    public function install()
    {
        $return = ['error' => 0, 'msg' => ''];
        $check = AdminConfig::where('key', $this->configKey)->first();
        if ($check) {
            $return = ['error' => 1, 'msg' => 'Module exist'];
        } else {

            $configPaypal = [
                [
                    'group' => $this->configGroup,
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ON, //1- Enable extension; 0 - Disable
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.title',
                ],
                [
                    'group' => '',
                    'code' => 'paypal_config',
                    'key' => 'paypal_client_id',
                    'sort' => 0, // Sort extensions in group
                    'value' => '',
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.paypal_client_id',
                ],
                [
                    'group' => '',
                    'code' => 'paypal_config',
                    'key' => 'paypal_secrect',
                    'sort' => 0, // Sort extensions in group
                    'value' => '',
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.paypal_secrect',
                ],
                [
                    'group' => '',
                    'code' => 'paypal_config',
                    'key' => 'paypal_log',
                    'sort' => 0, // Sort extensions in group
                    'value' => '0',
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.paypal_log',
                ],

                [
                    'group' => '',
                    'code' => 'paypal_config',
                    'key' => 'paypal_path_log',
                    'sort' => 0, // Sort extensions in group
                    'value' => 'logs/paypal.log',
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.paypal_path_log',
                ],
                [
                    'group' => '',
                    'code' => 'paypal_config',
                    'key' => 'paypal_mode',
                    'sort' => 0, // Sort extensions in group
                    'value' => 'sandbox',
                    'detail' => $this->pathExtension.'::'. $this->configKey . '.paypal_mode',
                ],

                [
                    'group' => '',
                    'code' => 'paypal_config',
                    'key' => 'paypal_logLevel',
                    'sort' => 0, // Sort extensions in group
                    'value' => 'DEBUG',
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.paypal_logLevel',
                ],
                [
                    'group' => '',
                    'code' => 'paypal_config',
                    'key' => 'paypal_currency',
                    'sort' => 0, // Sort extensions in group
                    'value' => 'USD',
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.paypal_currency',
                ],
                [
                    'group' => '',
                    'code' => 'paypal_config',
                    'key' => 'paypal_order_status_success',
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ORDER_STATUS_PROCESSING,
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.paypal_order_status_success',
                ],
                [
                    'group' => '',
                    'code' => 'paypal_config',
                    'key' => 'paypal_order_status_faild',
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ORDER_STATUS_FAILD,
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.paypal_order_status_faild',
                ],
            ];
            $process = AdminConfig::insert(
                $configPaypal
            );
            if (!$process) {
                $return = ['error' => 1, 'msg' => 'Error when install'];
            }
        }
        return $return;
    }

    public function uninstall()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->delete();
        $process2 = (new AdminConfig)->whereIn('key', ['paypal_client_id', 'paypal_secrect', 'paypal_log', 'paypal_path_log', 'paypal_mode', 'paypal_logLevel', 'paypal_currency', 'paypal_order_status_success', 'paypal_order_status_faild'])->delete();
        if (!$process & !$process2) {
            $return = ['error' => 1, 'msg' => 'Error when uninstall'];
        }
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
        return view($this->pathExtension . '::' . $this->configKey)->with(
            [
                'group' => $this->configCode,
                'key' => $this->configKey,
                'title' => $this->title,
                'jsonStatusOrder' => json_encode(ShopOrderStatus::mapValue()),
            ]);
    }

    public function process($data)
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = AdminConfig::where('key', $data['pk'])->update(['value' => $data['value']]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error update'];
        }
        return $return;
    }

}
