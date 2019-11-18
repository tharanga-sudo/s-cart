<?php
#app/Http/Admin/Controllers/ExtensionsController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExtensionsController extends Controller
{

    public $namespaceGroup;

    public function __construct()
    {
        $this->namespaceGroup = [
            'Shipping' => '\App\Extensions\Shipping',
            'Payment' => '\App\Extensions\Payment',
            'Total' => '\App\Extensions\Total',
            'Other' => '\App\Extensions\Other',
        ];

    }
    public function index($group)
    {
        $group = sc_word_format_class($group);
        $action = request('action');
        $extensionKey = request('extensionKey');
        if ($action == 'config' && $extensionKey != '') {
            $namespace = $this->namespaceGroup[$group] . '\\' . $extensionKey.'\\AppConfig';
            $body = (new $namespace)->config();
        } else {
            $body = $this->extensionsGroup($group);
        }
        return $body;
    }

    protected function extensionsGroup($group)
    {
        $group = sc_word_format_class($group);
        $extensionsInstalled = sc_get_extension($group, $onlyActive = false);
        $extensions = sc_get_array_namespace_plugin('Extensions', $group);
        $title = trans('Extensions/language.' . $group);
        return $this->render($extensionsInstalled, $extensions, $title, $group);
    }

    public function render($extensionsInstalled, $extensions, $title, $group)
    {
        return view('admin.screen.extension')
            ->with(
                [
                    "title" => $title,
                    "extensionsInstalled" => $extensionsInstalled,
                    "extensions" => $extensions,
                    "group" => $group,
                ]
            )
            ->render();
    }

    public function install()
    {
        $key = request('key');
        $group = request('group');
        $group = sc_word_format_class($group);
        $key = sc_word_format_class($key);
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key.'\\AppConfig';
        $response = (new $class)->install();
        return json_encode($response);
    }
    public function uninstall()
    {
        $key = request('key');
        $group = request('group');
        $group = sc_word_format_class($group);
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key.'\\AppConfig';
        $response = (new $class)->uninstall();
        return json_encode($response);
    }
    public function enable()
    {
        $key = request('key');
        $group = request('group');
        $group = sc_word_format_class($group);
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key.'\\AppConfig';
        $response = (new $class)->enable();
        return json_encode($response);
    }
    public function disable()
    {
        $key = request('key');
        $group = request('group');
        $group = sc_word_format_class($group);
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key.'\\AppConfig';
        $response = (new $class)->disable();
        return json_encode($response);
    }

    public function process($group, $key)
    {
        $group = sc_word_format_class($group);
        $key = sc_word_format_class($key);
        $data = request()->all();
        $namespace = $this->namespaceGroup[$group];
        $class = $namespace . '\\' . $key.'\\AppConfig';
        $response = (new $class)->process($data);
        return json_encode($response);
    }
}
