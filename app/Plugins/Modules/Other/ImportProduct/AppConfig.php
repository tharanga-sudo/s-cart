<?php
#app/Modules/Other/ImportProduct/AppConfig.php
namespace App\Plugins\Modules\Other\ImportProduct;

use App\Admin\Models\AdminMenu;
use App\Models\AdminConfig;
use App\Plugins\Modules\ConfigDefault;
class AppConfig extends ConfigDefault
{

    public $configGroup = 'Modules';
    public $configCode = 'Other';
    public $configKey = 'ImportProduct';
    public $pathPlugin;

    public function __construct()
    {
        $this->pathPlugin = $this->configGroup . '/' . $this->configCode . '/' . $this->configKey;
        $this->title = trans($this->pathPlugin.'::'. $this->configKey . '.title_module');
        $this->image = 'images/' . $this->pathPlugin . '.png';
        $this->version = '1.0';
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
                    'detail' => $this->pathPlugin.'::'. $this->configKey . '.title',
                ]
            );
            if (!$process) {
                $return = ['error' => 1, 'msg' => 'Error when install'];
            } else {
                $checkMenu = AdminMenu::find('200');
                if (!$checkMenu) {
                    AdminMenu::insert([
                        'id' => 200,
                        'sort' => 100,
                        'parent_id' => 2,
                        'title' => 'admin.import_data',
                        'icon' => 'fa-floppy-o',
                    ]);
                }
                AdminMenu::insert(
                    [
                        'parent_id' => 200,
                        'title' => 'Modules/Other/ImportProduct::ImportProduct.title',
                        'icon' => 'fa-gg',
                        'uri' => 'route::admin_import_product.index',
                    ]
                );
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
        //Remove menu
        (new AdminMenu)->where('uri', 'route::admin_import_product.index')->delete();
        if (!(new AdminMenu)->where('parent_id', 200)->count()) {
            (new AdminMenu)->find(200)->delete();
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

    public function getData()
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

}
