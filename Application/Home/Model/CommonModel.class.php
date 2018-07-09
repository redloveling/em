<?php
namespace Home\Model;

use Think\Model;

class CommonModel extends Model
{
    protected $connection = "DB_CONFIG";
    public $isCache = false; //默认不缓存

    /**
     * 插入数据
     * @author Red
     * @date 2016年10月14日11:43:07
     * @param null $data
     * @return mixed
     */
    public function insert($data = null)
    {
        $result = $this->add($data);
        saveLog(get_user_id() . ' 更新 ' . $this->getStatus($result) . ' ==>' . $this->getLastSql(), 'updateLogs');

        return $result;
    }

    /**
     * 根据主键获取一条数据
     * @author Red
     * @date 2016年10月14日11:43:48
     * @param $id
     * @param string $field
     * @return mixed
     */
    public function getById($id, $field = "*")
    {
        $map [$this->getPk()] = $id;

        return $this->where($map)->field($field)->find();
    }

    /**
     * 根据条件获取一条数据
     * @author Red
     * @date 2016年10月14日11:45:40
     * @param null $map
     * @param string $field
     * @return mixed
     */
    public function getOne($map = null, $field = "*")
    {
        return $this->where($map)->field($field)->find();
    }

    /**
     * 根据条件获取所有的数据
     * @author Red
     * @date 2016年10月14日11:45:40
     * @param null $map
     * @param string $field
     * @param string $order
     * @return mixed
     */
    public function getAll($map = null, $field = "*", $order = '')
    {
        if (!empty($order)) {
            return $this->where($map)->field($field)->order($order)->select();
        } else {
            return $this->where($map)->field($field)->select();
        }
    }

    /**
     * 分页查询数据或单条数据
     *
     * @param null $map 查询条件
     * @param string $field 查询字段
     * @param bool $isAll 是否查询多条
     * @param string $join 连接查询
     * @param string $joinType 连接类型
     * @param string $order 排序
     * @param string $limit 区间
     * @return mixed 查询结果
     */
    public function get($map = null, $field = "*", $isAll = false, $join = '', $joinType = '', $order = '', $limit='')
    {
        $field = $this->isCache ? '*' : $field;
        if ($isAll) {
            if (!empty($order)) {
                return $this->where($map)->field($field)->join($join, $joinType)->order($order)->limit($limit)->select();
            } else {
                $result = $this->where($map)->field($field)->join($join, $joinType)->limit($limit)->select();

                if ($this->isCache) {
                    $result = $this->getCacheByIdArr($result);
                }

                return $result;
            }
        } else {
            if (!empty($order)) {
                $result = $this->where($map)->field($field)->join($join, $joinType)->order($order)->find();
            } else {
                $result = $this->where($map)->field($field)->join($join, $joinType)->find();
            }

            $this->isCache === true ? S($this->getTableName() . $result[$this->getPk()], $result) : '';

            return $result;
        }
    }

    /**
     * 更新数据
     * @author Red
     * @date 2016年10月19日16:02:08
     * @param null $data
     * @param null $where
     * @return bool
     */
    public function update($data = null, $where = null)
    {
        if ($where) {
            $result = $this->where($where)->save($data);
        } else {
            $result = $this->save($data);
        }
        saveLog(get_user_id() . ' 更新 ' . $this->getStatus($result) . ' ==>' . $this->getLastSql(), 'updateLogs');

        return $result;

    }

    /**
     * 删除数据
     * @author Red
     * @date 2016-10-19 16:02:11
     * @param array $map
     * @return mixed
     */
    public function del($map = array())
    {
        $result = $this->where($map)->delete();
        saveLog(get_user_id() . ' 删除 ' . $this->getStatus($result) . ' ==>' . $this->getLastSql(), 'delLogs');

        return $result;

    }


    public function getSum($map, $field)
    {
        if ($map && $field) {
            return $this->where($map)->sum($field);
        } else {
            return false;
        }
    }

    /**
     * 单张表数据总数
     * @author Red
     * @date 2016-10-19 10:58:57
     * @param $map
     * @param string $field
     * @return mixed
     */
    public function getCount($map, $field = '*')
    {
        return $this->where($map)->count($field);
    }



    /**
     * 判断状态
     * @author Red
     * @date
     * @param $result
     * @return string
     */
    private function getStatus($result)
    {
        return $result === false ? '失败' : '成功';
    }
}

?>