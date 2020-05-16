<?php


namespace AdminBase\Controllers\Admin;

use AdminBase\Actions\Post\LogInput;
use AdminBase\Models\Admin\NewOperationLog;
use Encore\Admin\Auth\Database\OperationLog;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Arr;

class LogController extends \Encore\Admin\Controllers\LogController
{
    /**
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OperationLog());
        $grid->disableExport();

        $grid->model()->orderBy('id', 'DESC');

        $grid->column('id', 'ID')->sortable();
        $grid->column('user.name', '用户名称');
        $grid->column('ip', 'IP地址')->label('primary');
        $grid->column('method')->display(function ($method) {
            $color = Arr::get(OperationLog::$methodColors, $method, 'grey');

            return "<span class=\"badge bg-$color\">$method</span>";
        });
        $grid->column('do', '操作');

        $grid->column('created_at', trans('admin.created_at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
            $actions->disableView();
            $actions->disableDelete();
            //模态框 form 表单提交
            $actions->add(new LogInput());
        });

        $grid->disableCreateButton();

        $grid->filter(function (Grid\Filter $filter) {
            $userModel = config('admin.database.users_model');

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('user_id', '用户')->select($userModel::all()->pluck('name', 'id'));
            $filter->equal('method')->select(array_combine(OperationLog::$methods, OperationLog::$methods));
            $filter->equal('ip');
        });

        return $grid;
    }

    public function detail($id)
    {
        $show = new Show(NewOperationLog::query()->findOrFail($id));
        $show->field('id', 'ID');
        $show->field('user_id', '用户ID');
        $show->field('method', '请求地址');
        $show->field('ip', 'IP地址');
        $show->field('do', '操作');
        $show->field('input', '详细参数');
        $show->field('created_at', '记录时间');
        return $show;
    }
}