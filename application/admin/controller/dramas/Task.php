<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace app\admin\controller\dramas;

use app\common\controller\Backend;
use think\Db;

/**
 * 任务
 *
 * @icon fa fa-circle-o
 */
class Task extends Backend
{
    protected $dataLimit = 'auth';
    protected $dataLimitField = 'site_id';
    protected $noNeedRight = ['sync'];

    /**
     * Task模型对象
     * @var \app\admin\model\dramas\Task
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\dramas\Task;
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("statusList", $this->model->getStatusList());
        $hooks = \addons\dramas\model\Task::$hooks;
        foreach ($hooks as &$hook){
            $hook = __($hook);
        }
        $this->view->assign("hooks", $hooks);
        $this->assignconfig("hooks", $hooks);
        $this->view->assign("langList", $this->model->getLangList());
        $this->assignconfig("langList", $this->model->getLangList());
    }



    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    public function sync(){
        $testdata_file = ADDON_PATH . "dramas" . DS . 'testdata' . DS . "task.php";
        if (is_file($testdata_file)) {
            $datas = include $testdata_file;
            Db::startTrans();
            foreach ($datas as $templine) {
                $templine = str_ireplace('__PREFIX__', config('database.prefix'), $templine);
                $templine = str_ireplace('__SITEID__', $this->auth->id, $templine);
                $templine = str_ireplace('INSERT INTO ', 'INSERT IGNORE INTO ', $templine);
                try {
                    Db::execute($templine);
                } catch (\PDOException $e) {
                    Db::rollback();
                    $this->error(__('Operation failed').'：'.$e->getMessage());
                }
            }
            Db::commit();
            $this->success(__('Operation completed'));
        }else{
            $this->error(__('No results were found'));
        }

    }

}
