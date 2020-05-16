<?php

namespace AdminBase\Models\Admin;

use AdminBase\Models\AdminBaseModel;

class Site extends AdminBaseModel
{
    protected $table = 'sites';

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(SiteCategory::class);
    }
}
