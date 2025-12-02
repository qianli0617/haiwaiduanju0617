<?php

namespace app\admin\controller\dramas;

use addons\dramas\model\ResellerBind;
use addons\dramas\model\Share;
use app\common\controller\Backend;
use think\Db;
use app\admin\model\dramas\UserOauth;
use Exception;
use think\exception\PDOException;
use app\admin\model\dramas\UserWalletLog;


/**
 * 会员管理
 *
 * @icon fa fa-user
 */
class User extends Backend
{
    protected $dataLimit = 'auth';
    protected $dataLimitField = 'site_id';
    protected $noNeedRight = ['changeParentUser', 'changeVip', 'changeReseller'];

    protected $relationSearch = true;

    /**
     * @var \app\admin\model\dramas\User
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\dramas\User;
    }

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            $searchWhere = $this->request->request('searchWhere');
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with('group')
                ->where($where)
                ->where(function ($query) use ($searchWhere) {
                    if ($searchWhere) {
                        $table_name = (new \app\admin\model\dramas\User())->getQuery()->getTable();
                        $query = $query->table($table_name)->whereOr($table_name.'.id', '=', $searchWhere)
                            ->whereOr($table_name.'.mobile', 'like', "%{$searchWhere}%")
                            ->whereOr($table_name.'.nickname', 'like', "%$searchWhere%");
                    }
                    return $query;
                })
                ->order($sort, $order)
                ->count();
            $list = $this->model
                ->with('group')
                ->where($where)
                ->where(function ($query) use ($searchWhere) {
                    if ($searchWhere) {
                        $table_name = (new \app\admin\model\dramas\User())->getQuery()->getTable();
                        $query = $query->table($table_name)->whereOr($table_name.'.id', '=', $searchWhere)
                            ->whereOr($table_name.'.mobile', 'like', "%{$searchWhere}%")
                            ->whereOr($table_name.'.nickname', 'like', "%$searchWhere%");
                    }
                    return $query;
                })
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            foreach ($list as $k => $v) {
                $v->hidden(['password', 'salt']);
                $v->third_platform = UserOauth::all(['user_id' => $v->id]);
            }
            $result = array("total" => $total, "rows" => $list);

            $this->success(__('View'), null, $result);
        }
        return $this->view->fetch();
    }

    /**
     * 用户详情
     */
    public function profile($id)
    {
        $row = $this->model->get($id);
        if (!$row) {
            $this->error(__('No results were found'));
        }
        $row->hidden(['password', 'salt']);
        $row->third_platform = UserOauth::all(['user_id' => $row->id]);
        $row->parent_user = $this->model->get($row->parent_user_id);
        $reseller = ResellerBind::alias('b')
            ->join('dramas_reseller r', 'b.reseller_id=r.id', 'LEFT')
            ->where('b.user_id', $id)
            ->field('b.user_id,b.reseller_id,b.expiretime,r.name')
            ->find();
        $row->reseller = $reseller;

        if ($this->request->isAjax()) {
            $this->success(__('Detail'), null, $row);
        }
        $this->assignconfig('row', $row);
        $this->assignconfig('groupList', \app\admin\model\UserGroup::field('id,name,status')->select());
        return $this->view->fetch();
    }

    /**
     * 更新信息
     */
    public function update()
    {
        $params = $this->request->post('data');
        $params = json_decode($params, true);
        $user = $this->model->get($params['id']);
        if (!$user) {
            $this->error(__('No results were found'));
        }
        $result = Db::transaction(function () use ($user, $params) {

            try {
                if (!empty($params['password'])) {
                    $salt = \fast\Random::alnum();
                    $user->password = \app\common\library\Auth::instance()->getEncryptPassword($params['password'], $salt);
                    $user->salt = $salt;
                    $user->save();
                }
                $verification = $user->verification;
                if (!empty($params['mobile'])) {
                    $verification->mobile = 1;
                } else {
                    $verification->mobile = 0;
                }
                $user->verification = $verification;
                $user->save();

                return $user->validate('\app\admin\validate\dramas\User.update')->allowField('nickname,avatar,username,group_id,birthday,bio,mobile,email,level,gender,status')->save($params);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        });

        if ($result) {
            return $this->success(__('Update successful'), null, $user);
        } else {
            return $this->error($user->getError());
        }
    }

    /**
     * 选择
     */
    public function select()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $searchWhere = $this->request->request('search');
            $total = $this->model
                ->where($where)
                ->where(function ($query) use($searchWhere) {
                    if($searchWhere){
                        $query->whereOr('id', '=', $searchWhere)
                            ->whereOr('nickname', 'like', "%$searchWhere%")
                            ->whereOr('mobile', 'like', "%$searchWhere%");
                    }
                })
                ->order($sort, $order)
                ->field('id, nickname, mobile, avatar')
                ->count();

            $list = $this->model
                ->where($where)
                ->where(function ($query) use($searchWhere) {
                    if($searchWhere){
                        $query->whereOr('id', '=', $searchWhere)
                            ->whereOr('nickname', 'like', "%$searchWhere%")
                            ->whereOr('mobile', 'like', "%$searchWhere%");
                    }
                })
                ->order($sort, $order)
                ->field('id, nickname, mobile, avatar')
                ->limit($offset, $limit)
                ->select();
            $result = array("total" => $total, "rows" => $list);

            $this->success(__('Select'), null, $result);
        }
        return $this->view->fetch();
    }

    /**
     * 用户余额充值
     */
    public function money_recharge()
    {

        if ($this->request->isAjax()) {
            $params = $this->request->post();
            $user = $this->model->get($params['user_id']);
            $params['money'] = $params['money'];
            if ($params['money'] > 0) {
                $type = 'admin_recharge';
            } elseif ($params['money'] < 0) {
                $type = 'admin_deduct';
            } else {
                $this->error(__('Please enter the correct amount'));
            }
            $result = Db::transaction(function () use ($params, $user, $type) {
                return \addons\dramas\model\User::money($params['money'], $user->id, $type, 0, $params['remarks']);
            });
            if ($result) {
                $this->success(__('Operation completed'));
            } else {
                $this->error(__('Operation failed'));
            }
        }
        return $this->view->fetch();
    }

    /**
     * 用户积分充值
     */
    public function score_recharge()
    {
        if ($this->request->isAjax()) {
            $params = $this->request->post();
            $user = $this->model->get($params['user_id']);
            $params['score'] = intval($params['score']);
            if ($params['score'] > 0) {
                $type = 'admin_recharge';
            } elseif ($params['score'] < 0) {
                $type = 'admin_deduct';
            } else {
                $this->error(__('Please enter the correct quantity'));
            }
            $result = Db::transaction(function () use ($params, $user, $type) {
                try {
                    return \addons\dramas\model\User::score($params['score'], $user->id, $type, 0, $params['remarks']);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            });
            if ($result) {
                $this->success(__('Operation completed'));
            } else {
                $this->error(__('Operation failed'));
            }
        }
        return $this->view->fetch();
    }

    /**
     * 用户剧场积分充值
     */
    public function usable_recharge()
    {
        if ($this->request->isAjax()) {
            $params = $this->request->post();
            $user = $this->model->get($params['user_id']);
            $params['usable'] = intval($params['usable']);
            if ($params['usable'] > 0) {
                $type = 'admin_recharge';
            } elseif ($params['usable'] < 0) {
                $type = 'admin_deduct';
            } else {
                $this->error(__('Please enter the correct quantity'));
            }
            $result = Db::transaction(function () use ($params, $user, $type) {
                try {
                    return \addons\dramas\model\User::usable($params['usable'], $user->id, $type, 0, $params['remarks']);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            });
            if ($result) {
                $this->success(__('Operation completed'));
            } else {
                $this->error(__('Operation failed'));
            }
        }
        return $this->view->fetch();
    }

    /**
     * 余额明细
     */
    public function money_log($user_id, $limit = 10)
    {
        if ($this->request->isAjax()) {
            $model = new UserWalletLog();
            $data = $model->where(['user_id' => $user_id, 'wallet_type' => 'money'])->order('id desc')->paginate($limit);
            $this->success(__('Money log'), null, $data);
        }
    }

    /**
     * 剧场积分明细
     */
    public function usable_log($user_id, $limit = 10)
    {
        if ($this->request->isAjax()) {
            $model = new UserWalletLog();
            $data = $model->where(['user_id' => $user_id, 'wallet_type' => 'usable'])->order('id desc')->paginate($limit);
            $this->success(__('Usable log'), null, $data);
        }
    }

    /**
     * 订单记录
     */
    public function vip_order_log($user_id, $limit = 10)
    {
        if ($this->request->isAjax()) {
            $this->loadlang('dramas/vip_order');
            $model = new \app\admin\model\dramas\VipOrder;
            $data = $model->where('user_id', $user_id)->order('id desc')->paginate($limit);
            $this->success(__('Order log'), null, $data);
        }
    }
    public function reseller_order_log($user_id, $limit = 10)
    {
        if ($this->request->isAjax()) {
            $this->loadlang('dramas/reseller_order');
            $model = new \app\admin\model\dramas\ResellerOrder;
            $data = $model->where('user_id', $user_id)->order('id desc')->paginate($limit);
            $this->success(__('Order log'), null, $data);
        }
    }

    /**
     * 登录记录
     */
    public function login_log($user_id, $limit = 10)
    {
        if ($this->request->isAjax()) {
        }
    }

    /**
     * 分享记录
     */
    public function share_log($user_id, $limit = 10)
    {
        if ($this->request->isAjax()) {
            $this->loadlang('dramas/share');
            $model = new \app\admin\model\dramas\Share;
            $data = $model->where('share_id', $user_id)->order('id desc')->with([
                'user' => function ($query) {
                    return $query->withField('id,nickname,avatar');
                }
            ])->paginate($limit);
            $this->success(__('Share log'), null, $data);
        }
    }


    /**
     * 删除
     */
    public function del($ids = "")
    {
        if (!$this->request->isPost()) {
            $this->error(__("Invalid parameters"));
        }
        $ids = $ids ? $ids : $this->request->post("ids");
        if ($ids) {
            $pk = $this->model->getPk();
            $list = $this->model->where($pk, 'in', $ids)->select();

            $count = 0;
            Db::startTrans();
            try {
                foreach ($list as $k => $v) {
                    // 删除这个用户关联的 dramas_user_oauth 记录
                    UserOauth::where('user_id', $v->id)->delete();

                    // 删除用户
                    $count += $v->delete();
                }
                Db::commit();
            } catch (PDOException $e) {
                Db::rollback();
                $this->error($e->getMessage());
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($count) {
                $this->success();
            } else {
                $this->error(__('No rows were deleted'));
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

    /**
     * 更换上级推荐人
     */
    public function changeParentUser($id)
    {
        $user = $this->model->get($id);
        $value = $this->request->post('value');

        if (!$user) {
            $this->error(__('No results were found'));
        }
        Db::startTrans();
        try {
            if ($user->parent_user_id) {
                throw new \Exception(__('Unable to replace recommender'));
            }
            if ($user->parent_user_id == $value) {
                throw new \Exception(__('Please do not make duplicate selections'));
            }
            if ($user->id == $value) {
                throw new \Exception(__('Unable to bind myself'));
            }
            $platform = 'Admin';
            $spm = $value.'.2.0.5.4';
            $user->parent_user_id = $value;
            $user->save();
            $share = Share::add($spm, $platform, $user);
            \addons\dramas\model\Reseller::share_user_reseller($share, $user);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }

        $this->success(__('Binding successful'));
    }

    /**
     * 设置vip
     */
    public function changeVip($id)
    {
        $user = $this->model->get($id);
        $value = $this->request->post('value');
        if (!$user) {
            $this->error(__('No results were found'));
        }
        $vip = \app\admin\model\dramas\Vip::get($value);
        if (!$vip) {
            $this->error(__('No results were found'));
        }

        Db::startTrans();
        try {
            $times = 0;
            switch ($vip['type']){
                case 'd':
                    $times = $vip['num'] * 86400;
                    break;
                case 'm':
                    $times = $vip['num'] * 86400 * 30;
                    break;
                case 'q':
                    $times = $vip['num'] * 86400 * 30 * 3;
                    break;
                case 'y':
                    $times = $vip['num'] * 86400 * 365;
                    break;

            }
            $order = new \addons\dramas\model\VipOrder();
            $orderData = [];
            $orderData['order_sn'] = $order::getSn($user->id);
            $orderData['site_id'] = $user->site_id;
            $orderData['user_id'] = $user->id;
            $orderData['vip_id'] = $value;
            $orderData['status'] = 1;
            $orderData['total_fee'] = 0;
            $orderData['times'] = $times;
            $orderData['remark'] = __('Manually added by backend administrator');
            $orderData['pay_type'] = 'system';
            $orderData['paytime'] = time();
            $order->allowField(true)->save($orderData);
            if($user['vip_expiretime'] < time()){
                $user->vip_expiretime = strtotime(date('Y-m-d', strtotime('+1 day'))) + $order->times;
            }else{
                $user->vip_expiretime = $user['vip_expiretime'] + $order->times;
            }
            $user->save();
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }

        $this->success(__('Success'));
    }

    /**
     * 设置分销商
     */
    public function changeReseller($id)
    {
        $user = $this->model->get($id);
        $value = $this->request->post('value');
        if (!$user) {
            $this->error(__('No results were found'));
        }
        $reseller = \app\admin\model\dramas\Reseller::get($value);
        if (!$reseller) {
            $this->error(__('No results were found'));
        }

        Db::startTrans();
        try {
            $order = new \addons\dramas\model\ResellerOrder();
            $orderData = [];
            $orderData['site_id'] = $user->site_id;
            $orderData['order_sn'] = $order::getSn($user->id);
            $orderData['user_id'] = $user->id;
            $orderData['reseller_id'] = $value;
            $orderData['status'] = 1;
            $orderData['total_fee'] = 0;
            $orderData['times'] = $reseller['expire'];
            $orderData['remark'] = __('Manually added by backend administrator');
            $orderData['pay_type'] = 'system';
            $orderData['paytime'] = time();
            $order->allowField(true)->save($orderData);

            // 添加reseller到期时间
            ResellerBind::add($order->site_id, $order->user_id, $order->reseller_id);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }

        $this->success(__('Success'));
    }
}
