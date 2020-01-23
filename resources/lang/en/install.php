<?php
return [
    'info' => [
        'about' => 'S-Cart is a free e-commerce website project for businesses, built on the Laravel framework (PHP & Mysql)',
        'about_pro' => 'Best Laravel eCommerce Platform for Business!',
        'about_us' => '- About us, please visit <a target="_new" href="https://s-cart.org/">S-Cart\'s homepage</a>',
        'document' => '- Installation guide <a target="_new" href="https://s-cart.org/installation.html">HERE</a>',
        'version' => 'Versions',
        'terms' => '<span style="color:red">*</span> Please read the terms before installing <a target="_new" href="https://s-cart.org/license.html">HERE</a>.',
        'terms_pro' => '<span style="color:red">*</span> Please read the terms before installing <a target="_new" href="https://s-cart.org/pro.html">HERE</a>.',
        '',
    ],
    'env' => [
        'process' => 'Generating file .env',
        'error_open' => 'Cant not open file .env.example',
        'process_sucess' => 'Generate file .env success!',
        'error' => 'Error while generating file .env',
        'nofound' => 'File .env.expample no found!',
    ],
    'key' => [
        'process' => 'Generating API key',
        'process_sucess' => 'Generate API key success!',
        'error' => 'Error while generating API key',
    ],
    'database' => [
        'process' => 'Initializing database',
        'process_1' => 'Initializing table admin',
        'process_2' => 'Initializing table shopping',
        'process_sucess' => 'Successful initialization!',
        'process_sucess_1' => 'Insert table admin success!',
        'process_sucess_2' => 'Insert table shopping success!',
        'file_notfound' => 'Cant not found file .sql',
        'error' => 'Error while initializing database',
    ],
    'permission' => [
        'process' => 'Setting permission folders',
        'process_sucess' => 'Setting permission success!',
        'error' => 'Error while initializing setting permission folder',
    ],
    'complete' => [
        'process' => 'Prepare to finish',
        'process_success' => 'Completed!',
        'error' => 'Error while finish',
    ],

    'validate' => [
        'database_port_number' => 'Database port is number',
        'database_port_required' => 'Database port required',
        'database_host_required' => 'Host databse required',
        'database_name_required' => 'Database name required',
        'database_user_required' => 'Database user required',
        'admin_url_required' => 'Admin path required',
        'admin_user_required' => 'Admin user required',
        'admin_password_required' => 'Admin password required',
        'admin_email_required' => 'Admin email required',
        'timezone_default_required' => 'Timezone default required',
        'language_default_required' => 'Language default required',
    ],
    'installing_button' => 'Installing S-Cart',
    'database_host' => 'DB host',
    'database_port' => 'DB port',
    'database_name' => 'DB name',
    'database_user' => 'DB user',
    'database_password' => 'DB pasword',
    'admin_url' => 'Admin url',
    'admin_user' => 'Admin user',
    'admin_password' => 'Admin password',
    'admin_email' => 'Admin email',
    'language_default' => 'Language',
    'timezone_default' => 'Timezone',
    'title' => 'Install S-Cart',
    'installing' => 'Begin Install',
    'rename_error' => 'Can not rename file install.php. Please remove or rename it!',
    'terms' => '<span style="color:red">*</span> Agree with the terms and conditions',
    'requirement_check' => 'Requirement check',
    'check_extension' => 'Check extension',
    'check_writable' => 'Check writable',
    'check_failed' => 'Failed',
    'check_ok' => 'OK',
];
