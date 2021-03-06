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

namespace app\store\controller\api;

use library\Controller;
use think\Db;

/**
 * 商品管理接口
 * Class Goods
 * @package app\store\controller\api
 */
class Goods extends Controller
{

    /**
     * 获取商品列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function gets()
    {
        $where = ['is_deleted' => '0', 'status' => '1'];
        $field = 'id,title,logo,specs,lists,image,content,number_sales,number_stock';
        $list = Db::name('StoreGoods')->field($field)->where($where)->order('sort asc,id desc')->select();
        $goodsList = Db::name('StoreGoodsList')->whereIn('goods_id', array_unique(array_column($list, 'id')))->select();
        foreach ($list as &$vo) {
            $vo['list'] = [];
            $vo['image'] = explode('|', $vo['image']);
            $vo['specs'] = json_decode($vo['specs'], true);
            $vo['lists'] = json_decode($vo['lists'], true);
            foreach ($goodsList as $goods) if ($goods['goods_id'] === $vo['id']) array_push($vo['list'], $goods);
        }
        $this->success('获取商品列表成功！', ['list' => $list]);
    }

    /**
     * 获取单个商品信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get()
    {
        $goods_id = input('goods_id');
        $where = ['is_deleted' => '0', 'status' => '1', 'id' => $goods_id];
        $field = 'id,title,logo,specs,lists,image,content,number_sales,number_stock';
        $goods = Db::name('StoreGoods')->field($field)->where($where)->find();
        if (empty($goods)) $this->error('指定商品不存在，请更换商品ID重试！');
        $goods['image'] = explode('|', $goods['image']);
        $goods['specs'] = json_decode($goods['specs'], true);
        $goods['lists'] = json_decode($goods['lists'], true);
        $goods['list'] = Db::name('StoreGoodsList')->where(['goods_id' => $goods_id])->select();
        if (empty($goods['list'])) $this->error('指定商品规格不存在，请更换商品ID重试！');
        $this->success('获取商品信息成功！', $goods);
    }

}