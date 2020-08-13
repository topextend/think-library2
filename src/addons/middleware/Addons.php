<?php
// -----------------------------------------------------------------------
// |Author       : Jarmin <edshop@qq.com>
// |----------------------------------------------------------------------
// |Date         : 2020-08-13 11:39:25
// |----------------------------------------------------------------------
// |LastEditTime : 2020-08-13 11:39:59
// |----------------------------------------------------------------------
// |LastEditors  : Jarmin <edshop@qq.com>
// |----------------------------------------------------------------------
// |Description  : 
// |----------------------------------------------------------------------
// |FilePath     : \www.padmin.com\vendor\topextend\think-library\src\addons\middleware\Addons.php
// |----------------------------------------------------------------------
// |Copyright (c) 2020 http://www.ladmin.cn   All rights reserved. 
// -----------------------------------------------------------------------
namespace think\admin\addons\middleware;

use think\App;

class Addons
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app  = $app;
    }

    /**
     * 插件中间件
     * @param $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        hook('addon_middleware', $request);

        return $next($request);
    }
}