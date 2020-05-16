<?php

namespace AdminBase\Middleware;

use AdminBase\Common\Format;
use Closure;
use Illuminate\Http\Request;

class DatetimeFormatBefore
{
    /**
     * 兼容mongo，格式化请求参数
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $params = Format::formatRequest($request->all());

        $request->merge($params);

        return $next($request);
    }
}
