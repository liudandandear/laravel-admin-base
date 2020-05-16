<?php

namespace AdminBase\Forms\Field;


use AdminBase\Utility\Google2FaHelper;
use AdminBase\Utility\Random;
use Encore\Admin\Form\Field;

class Google2FaButton extends Field
{
    protected $view = 'common::google2fa';

    protected $userSecretKey = '';

    public function secret($userSecretKey = ''){
        if ($userSecretKey) {
            $this->userSecretKey = $userSecretKey;
        }
        return $this;
    }

    public function render()
    {
        if ($this->userSecretKey) {
            $valid = 1;
            $this->variables = array_merge($this->variables, compact('valid'));
        }else{
            $secretKey = Google2FaHelper::getSecretKey();
            $inlineUrl = Google2FaHelper::getInlineUrl($secretKey);
            $valid = 0;
            $recoveryCode = Random::character(32);
            request()->session()->put(Google2FaHelper::$secretSessionKey, $secretKey);
            $this->variables = array_merge($this->variables, compact('secretKey', 'inlineUrl', 'valid', 'recoveryCode'));
        }
        return parent::render();
    }
}
