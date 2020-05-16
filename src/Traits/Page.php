<?php


namespace AdminBase\Traits;

use AdminBase\Common\Constant;

/**
 * 分页
 * Trait Page
 * @package AdminBase\Traits
 */
trait Page
{
    /**
     * 格式化分页
     */
    protected function format()
    {
        if (isset($this->params['p'])) {
            $this->p = intval($this->params['p']);
            $this->p < 1 && $this->p = 1;
            $this->pageLimit = ($this->p - 1) * Constant::PAGE_SIZE;
        }
    }
}