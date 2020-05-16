<?php


namespace AdminBase\Traits;


use Encore\Admin\Form;

trait FormTrait
{
    /**
     * 禁用form表单底部功能操作
     * @param Form $form
     */
    protected function disableFormFooter(Form &$form)
    {
        $form->footer(function (Form\Footer $footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
            $footer->disableReset();
        });
    }

    /**
     * 禁用底部所有操作
     * @param Form $form
     */
    protected function disableFormFooterAll(Form &$form)
    {
        $form->footer(function (Form\Footer $footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
            $footer->disableReset();
            $footer->disableSubmit();
        });
    }
}