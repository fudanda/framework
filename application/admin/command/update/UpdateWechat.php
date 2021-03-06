<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\admin\command\update;

use app\admin\command\Update;

/**
 * 更新微信模块指令
 * Class UpdateWechat
 * @package app\admin\logic\update
 */
class UpdateWechat extends Update
{
    /**
     * 配置入口
     */
    protected function configure()
    {
        $this->modules = ['application/wechat/'];
        $this->setName('update:wechat')->setDescription('Sync Update Wechat Files for ThinkAdmin');
    }
}