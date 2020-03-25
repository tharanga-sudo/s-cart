<?php

return [
    'title' => 'Import product',
    'title_module'    => 'Import product',
    'note' => 'You can create or update product information.<br>
    Please download the sample file below. <br>
    <span class="text-red"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
    <b>Notice:</b> Please use the correct file for each updated form.</span>',
    'admin'       => [
        'title'           => 'Import product',
        'submit'         => 'Import Info',
        'submit_des'         => 'Import Description',
        'process'         =>  [
            'add_new_sucess' => 'List product add new success',
            'update_sucess' => 'List product update success',
            'error' => 'List product error',
            'product_notfound' => 'Product not found',
            'step1' => '<b>STEP 1: </b> Create and update basic product information',
            'step2' => '<b>STEP 2: </b> Update description information of the product. <br>(SKU code must be generated in step 1)',
        ],
    ],
];
