<?php  

/*
Render block
 */
if (!function_exists('sc_block_render')) {
    function sc_block_render($nameSpace)
    {
        $fullNameSpace = '\\App\Plugins\Modules\Block\\'.$nameSpace.'\Controllers\\' . $nameSpace.'Controller';
        if (class_exists($fullNameSpace)) {
            $class = (new $fullNameSpace);
            if (method_exists($class, 'render')) {
                return $class->render();
            }
        }
        return false;
    }
}

if (!function_exists('sc_get_array_namespace_plugin')) {
    /**
     * Get class plugin
     *
     * @param   [string]  $group  Extentions,Modules
     * @param   [string]  $code  Payment, Shipping
     *
     * @return  [array] 
     */
    function sc_get_array_namespace_plugin($group, $code)
    {
        $group = sc_word_format_class($group);
        $code = sc_word_format_class($code);
        $arrClass = [];
        $dirs = array_filter(glob(app_path() . '/Plugins/' . $group . '/' . $code . '/*'), 'is_dir');
        if ($dirs) {
            foreach ($dirs as $dir) {
                $tmp = explode('/', $dir);
                $nameSpace = '\App\Plugins\\' . $group . '\\' . $code . '\\' . end($tmp);
                $nameSpaceConfig = $nameSpace . '\\AppConfig';
                if (file_exists($dir . '/AppConfig.php') && class_exists($nameSpaceConfig)) {
                    $arrClass[end($tmp)] = $nameSpace;
                }
            }
        }
        return $arrClass;
    }
}

/*
    Get class payment config
    */
if (!function_exists('sc_get_class_payment_config')) {
    function sc_get_class_payment_config($paymentMethod)
    {
        $paymentMethod = sc_word_format_class($paymentMethod);
        $nameSpace = sc_get_extension_namespace('Payment', $paymentMethod);
        $class = $nameSpace . '\AppConfig';
        return $class;
    }
}

/*
    Get class payment controller
    */
if (!function_exists('sc_get_class_payment_controller')) {
    function sc_get_class_payment_controller($paymentMethod)
    {
        $paymentMethod = sc_word_format_class($paymentMethod);
        $nameSpace = sc_get_extension_namespace('Payment', $paymentMethod);
        $class = $nameSpace . '\Controllers\\' . $paymentMethod . 'Controller';
        return $class;
    }
}

/*
    Get class shipping config
    */
if (!function_exists('sc_get_class_shipping_config')) {
    function sc_get_class_shipping_config($shippingMethod)
    {
        $shippingMethod = sc_word_format_class($shippingMethod);
        $nameSpace = sc_get_extension_namespace('Shipping', $shippingMethod);
        $class = $nameSpace . '\AppConfig';
        return $class;
    }
}

/*
    Get class shipping controller
    */
if (!function_exists('sc_get_class_shipping_controller')) {
    function sc_get_class_shipping_controller($shippingMethod)
    {
        $shippingMethod = sc_word_format_class($shippingMethod);
        $nameSpace = sc_get_extension_namespace('Shipping', $shippingMethod);
        $class = $nameSpace . '\Controllers\\' . $shippingMethod . 'Controller';
        return $class;
    }
}



/*
    Get class total config
    */
if (!function_exists('sc_get_class_total_config')) {
    function sc_get_class_total_config($totalMethod)
    {
        $totalMethod = sc_word_format_class($totalMethod);
        $nameSpace = sc_get_extension_namespace('Total', $totalMethod);
        $class = $nameSpace . '\AppConfig';
        return $class;
    }
}

/*
    Get class total controller
    */
if (!function_exists('sc_get_class_total_controller')) {
    function sc_get_class_total_controller($totalMethod)
    {
        $totalMethod = sc_word_format_class($totalMethod);
        $nameSpace = sc_get_extension_namespace('Total', $totalMethod);
        $class = $nameSpace . '\Controllers\\' . $totalMethod . 'Controller';
        return $class;
    }
}


    /**
     * Get namespace module
     *
     * @param   [string]  $code  Block, Cms,..
     * @param   [string]  $key  Content,..
     *
     * @return  [array] 
     */
    if (!function_exists('sc_get_module_namespace')) {
        function sc_get_module_namespace($code, $key)
        {
            $code = sc_word_format_class($code);
            $key = sc_word_format_class($key);
            $nameSpace = '\App\Plugins\Modules\\'.$code.'\\' . $key;
            return $nameSpace;
        }
    }

    /**
     * Get namespace extension
     *
     * @param   [string]  $code  Payment, shipping,..
     * @param   [string]  $key  Paypal, Cash,...
     *
     * @return  [array] 
     */
    if (!function_exists('sc_get_extension_namespace')) {
        function sc_get_extension_namespace($code, $key)
        {
            $code = sc_word_format_class($code);
            $key = sc_word_format_class($key);
            $nameSpace = '\App\Plugins\Extensions\\'.$code.'\\' . $key;
            return $nameSpace;
        }
    }