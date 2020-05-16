<?php


namespace AdminBase\Traits;

use Encore\Admin\Show;

trait ShowTrait
{
    /**
     * 显示开始/修改时间
     * @param Show $show
     */
    protected function setShowTimeView(Show &$show)
    {
        $show->field('created_at', trans('admin.created_at'));
        $show->field('updated_at', trans('admin.updated_at'));
    }
}