<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

use addons\dramas\exception\Exception;

/**
 * 流水
 * Class UserWalletLog
 * @package addons\dramas\controller
 */
class UserWalletLog extends Base
{

    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];


    /**
     * 流水记录
     * @ApiParams   (name="wallet_type", type="string", required=true, description="标识：usable 剧场积分记录")
     * @ApiParams   (name="status", type="string", required=true, description="收支：all全部add收入reduce支出")
     * @ApiParams   (name="date", type="string", required=true, description="时间：格式(20230501-20230531)默认当月月")
     */
    public function index()
    {
        $params = $this->request->get();
        $params = array_filter($params);
        $wallet_type = $params['wallet_type'] ?? 'usable';
        if (!in_array($wallet_type, ['money', 'score', 'usable'])) {
            $this->error(__('Error parameters'));
        }
        $wallet_name = [
            'money'=>'Wallet records',
            'score'=>'Integral record',
            'usable'=>'Theater Points Record'
        ];
        $this->success(__($wallet_name[$wallet_type]), \addons\dramas\model\UserWalletLog::getList($params));
    }

}
