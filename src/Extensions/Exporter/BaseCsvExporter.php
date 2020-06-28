<?php


namespace AdminBase\Extensions\Exporter;


use Encore\Admin\Grid\Exporters\CsvExporter;
use Encore\Admin\Auth\Permission;

class BaseCsvExporter extends CsvExporter
{
    /**
     * 指定源数据输出字段
     * @var array
     */
    protected $columnUseOriginalValue = [

    ];

    public function export()
    {
        Permission::check($this->getSlug());
        $this->columnCallback();
        parent::export();
    }

    /**
     * 导出权限节点定义 = table + _export
     * @return string
     */
    private function getSlug()
    {
        return $this->grid->model()->getTable() . '_export';
    }

    /**
     * 字段过滤
     */
    private function columnCallback()
    {
        $this->column('is_release', function ($value) {
            return $value == 1 ? '是' : '否';
        });
    }
}