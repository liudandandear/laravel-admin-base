<?php


namespace AdminBase;


use Encore\Admin\Extension;

class AdminBase extends Extension
{
    public $name = 'base';

    public $views = __DIR__.'/../resources/views';
}