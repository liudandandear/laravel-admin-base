<?php

namespace AdminBase\Controllers\Auth;


use AdminBase\Controllers\HttpController;

class Validate2FaController extends HttpController
{
    /**
     *
     * @return mixed
     */
    public function index()
    {
        return redirect('/');
    }
}
