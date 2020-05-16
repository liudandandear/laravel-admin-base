<?php

namespace AdminBase\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\MessageBag;

class HttpController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * larave-admin 全局失败提示
     * @param string $msg
     * @return RedirectResponse
     */
    protected function error($msg = '操作失败')
    {
        $error = new MessageBag([
            'title' => $msg,
            'message' => $msg,
        ]);
        return back()->with(compact('error'));
    }
}
