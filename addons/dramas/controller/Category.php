<?php

namespace addons\dramas\controller;

use addons\dramas\model\Category as CategoryModel;

/**
 * 分类管理
 * @icon   fa fa-list
 * @remark 用于统一管理网站的所有分类
 */

class Category extends Base
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 分类列表
     */
    public function index()
    {
        $id = $this->request->get('id', 0);
        $data = CategoryModel::getCategoryList($id, $this->site_id, $this->lang_id);
        $this->success(__('List'), $data);
    }


}
