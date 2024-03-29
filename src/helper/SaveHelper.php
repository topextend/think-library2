<?php
// -----------------------------------------------------------------------
// |Author       : Jarmin <edshop@qq.com>
// |----------------------------------------------------------------------
// |Date         : 2020-07-08 16:36:17
// |----------------------------------------------------------------------
// |LastEditTime : 2020-07-08 17:23:18
// |----------------------------------------------------------------------
// |LastEditors  : Jarmin <edshop@qq.com>
// |----------------------------------------------------------------------
// |Description  : Class SaveHelper
// |----------------------------------------------------------------------
// |FilePath     : \think-library\src\helper\SaveHelper.php
// |----------------------------------------------------------------------
// |Copyright (c) 2020 http://www.ladmin.cn   All rights reserved. 
// -----------------------------------------------------------------------
namespace think\admin\helper;

use think\admin\Helper;
use think\db\Query;

/**
 * 数据更新管理器
 * Class SaveHelper
 * @package think\admin\helper
 */
class SaveHelper extends Helper
{
    /**
     * 表单扩展数据
     * @var array
     */
    protected $data;

    /**
     * 表单额外更新条件
     * @var array
     */
    protected $where;

    /**
     * 数据对象主键名称
     * @var array|string
     */
    protected $field;

    /**
     * 数据对象主键值
     * @var string
     */
    protected $value;

    /**
     * 逻辑器初始化
     * @param Query|string $dbQuery
     * @param array $data 表单扩展数据
     * @param string $field 数据对象主键
     * @param array $where 额外更新条件
     * @return boolean
     * @throws \think\db\exception\DbException
     */
    public function init($dbQuery, $data = [], $field = '', $where = [])
    {
        $this->where = $where;
        $this->query = $this->buildQuery($dbQuery);
        $this->field = $field ?: $this->query->getPk();
        $this->data = $data ?: $this->app->request->post();
        $this->value = $this->app->request->post($this->field, null);
        // 主键限制处理
        if (!isset($this->where[$this->field]) && is_string($this->value)) {
            $this->query->whereIn($this->field, explode(',', $this->value));
            if (isset($this->data)) unset($this->data[$this->field]);
        }
        // 前置回调处理
        if (false === $this->controller->callback('_save_filter', $this->query, $this->data)) {
            return false;
        }
        // 执行更新操作
        $result = $this->query->where($this->where)->update($this->data) !== false;
        // 结果回调处理
        if (false === $this->controller->callback('_save_result', $result)) {
            return $result;
        }
        // 回复前端结果
        if ($result !== false) {
            $this->controller->success(lang('think_library_save_success'), '');
        } else {
            $this->controller->error(lang('think_library_save_error'));
        }
    }

}
