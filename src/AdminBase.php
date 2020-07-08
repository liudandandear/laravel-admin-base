<?php


namespace AdminBase;


use Encore\Admin\Extension;

class AdminBase extends Extension
{
    public $name = 'setting';

    public $views = __DIR__.'/../resources/views';

    public $menu = [
        'title' => 'AdminBase',
        'path'  => '',
        'icon'  => 'fa-gears',
    ];
}