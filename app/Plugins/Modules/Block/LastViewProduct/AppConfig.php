<?php
#app/Modules/Block/LastViewProduct/AppConfig.php
namespace App\Plugins\Modules\Block\LastViewProduct;

use App\Models\AdminConfig;
use App\Models\ShopBlockContent;
use App\Plugins\Modules\ModuleDefault;
use App\Http\Controllers\Controller;
class AppConfig extends Controller
{
    use ModuleDefault;

    protected $configGroup = 'Modules';
    protected $configCode = 'Block';
    protected $configKey = 'LastViewProduct';
    protected $namespace = '';
    public $pathExtension = '';
    public $title;
    public $version;
    public $auth;
    public $link;
    public $image;
    const ON = 1;
    const OFF = 0;
    public function __construct()
    {
        $this->pathExtension = $this->configGroup . '/' . $this->configCode . '/' . $this->configKey;
        $this->title = trans($this->pathExtension.'::'. $this->configKey . '.title');
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
                    'value' => self::ON, //1- Enable extension; 0 - Disable
                    'detail' => $this->pathExtension.'::'.$this->configKey . '.title',
                ]
            );
            $this->processDefault();
            if (!$process) {
                $return = ['error' => 1, 'msg' => 'Error when install'];
            }
        }
        return $return;
    }

    public function uninstall()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)
            ->where('key', $this->configKey)
            ->delete();
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error when uninstall'];
        }
        (new ShopBlockContent)
            ->where('text', $this->namespace)
            ->delete();
        return $return;
    }
    public function enable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)
            ->where('key', $this->configKey)
            ->update(['value' => self::ON]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error enable'];
        }
        return $return;
    }
    public function disable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)
            ->where('key', $this->configKey)
            ->update(['value' => self::OFF]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error disable'];
        }
        return $return;
    }

//=======================

    public function processData()
    {
        $arrData = [
            'title' => $this->title,
            'code' => $this->configKey,
            'version' => $this->version,
            'auth' => $this->auth,
            'link' => $this->link,
        ];
        return $arrData;
    }

    public function processDefault()
    {
        return $process = ShopBlockContent::insert(
            [
                'name' => $this->title,
                'position' => 'left',
                'page' => '',
                'group' => 'module',
                'text' => $this->namespace,
                'status' => self::ON, //1- Enable extension; 0 - Disable
                'sort' => 0,
            ]
        );

    }

}
