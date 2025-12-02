<?php

namespace app\admin\model\dramas;

use app\admin\library\Auth;
use fast\Tree;
use think\Model;
use traits\model\SoftDelete;

class Video extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'dramas_video';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'flags_arr',
        'tags_arr',
        'category_text',
        'year_text',
        'area_text',
        'flags_text',
        'status_text'
    ];

    public function getLangList()
    {
        $list = (new \app\admin\model\Lang())->column('lang', 'id');
        return $list;
    }
    
    public function getFlagsList()
    {
        return ['hot' => __('Flags hot'), 'recommend' => __('Flags recommend')];
    }

    public function getStatusList()
    {
        return ['up' => __('Status up'), 'down' => __('Status down')];
    }

    public function getCategoryList($site_id, $lang_id)
    {
        $category = Category::where('pid', 0)
            ->where('type', 'video')
            ->where('site_id', $site_id)
            ->where('lang_id', $lang_id)
            ->find();
        $category_list = [];
        if($category){
            $category_list = Category::where('pid', $category['id'])
                ->where('type', 'video')
                ->orderRaw('weigh desc, id asc')
                ->column('name', 'id');
        }
        return $category_list;
    }

    public function getYearList($site_id, $lang_id)
    {
        $category = Category::where('pid', 0)
            ->where('type', 'year')
            ->where('site_id', $site_id)
            ->where('lang_id', $lang_id)
            ->find();
        $category_list = [];
        if($category){
            $category_list = Category::where('pid', $category['id'])
                ->where('type', 'year')
                ->orderRaw('weigh desc, id asc')
                ->select();
            if($category_list){
                $category_list = collection($category_list)->toArray();
            }
        }
        return $category_list;
    }

    public function getAreaList($site_id, $lang_id)
    {
        $category = Category::where('pid', 0)
            ->where('type', 'area')
            ->where('site_id', $site_id)
            ->where('lang_id', $lang_id)
            ->find();
        $category_list = [];
        if($category){
            $category_list = Category::where('pid', $category['id'])
                ->where('type', 'area')
                ->orderRaw('weigh desc, id asc')
                ->select();
            if($category_list){
                $category_list = collection($category_list)->toArray();
            }
        }
        return $category_list;
    }


    public function getCategoryIdsArrAttr($value, $data)
    {
        $arr = $data['category_ids'] ? explode(',', $data['category_ids']) : [];

        $category_ids_arr = [];
        if ($arr) {
            $tree = Tree::instance();
            $site_id = Auth::instance()->id;
            $tree->init(collection(\app\admin\model\dramas\Category::where('type', 'video')
                ->where('site_id', $site_id)
                ->order('weigh desc,id desc')->select())->toArray(), 'pid');

            foreach ($arr as $key => $id) {
                $category_ids_arr[] = $tree->getParentsIds($id, true);
            }
        }

        return $category_ids_arr;
    }


    public function getCategoryTextAttr($value, $data)
    {
        $value = $value ?: ($data['category_ids'] ?? '');
        $valueArr = $value?explode(',', $value):[];
        $site_id = Auth::instance()->id;
        $list = $this->getCategoryList($site_id, $data['lang_id']);
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }

    public function getFlagsArrAttr($value, $data)
    {
        $value = $value ?: ($data['flags'] ?? '');
        $valueArr = $value?explode(',', $value):[];
        return $valueArr;
    }

    public function gettagsArrAttr($value, $data)
    {
        $value = $value ?: ($data['tags'] ?? '');
        $valueArr = $value?explode(',', $value):[];
        return $valueArr;
    }


    public function getYearTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['year_id']) ? $data['year_id'] : '');
        $site_id = Auth::instance()->id;
        $yearList = $this->getYearList($site_id, $data['lang_id']);
        $list = [];
        foreach ($yearList as $item){
            $list[$item['id']] = $item['name'];
        }
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getAreaTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['area_id']) ? $data['area_id'] : '');
        $site_id = Auth::instance()->id;
        $areaList = $this->getAreaList($site_id, $data['lang_id']);
        $list = [];
        foreach ($areaList as $item){
            $list[$item['id']] = $item['name'];
        }
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getFlagsTextAttr($value, $data)
    {
        $value = $value ?: ($data['flags'] ?? '');
        $valueArr = $value?explode(',', $value):[];
        $list = $this->getFlagsList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setFlagsAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }


    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
