<?php

namespace AdminBase\Actions\Post;

use AdminBase\Utility\JsonHelper;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Auth\Database\OperationLog;

class LogInput extends RowAction
{
    public $name = "详细日志";

    public function form(OperationLog $model)
    {
        $input = $model->input;
        if (!JsonHelper::isValidJson($input)) {
            $input = $model->input;
        }
        $input = JsonHelper::decode($input);
        $this->textarea('input', '详细记录')->value(json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))->readonly();
    }

}