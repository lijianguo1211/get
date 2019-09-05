<?php


class MiddlewareModel
{
    protected $obj;

    /**
     * 注入具体的model
     * MiddlewareModel constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->obj = $model;
    }

    /**
     * Notes:添加
     * Name: add
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:21
     * @param array $data
     * @return array
     */
    public function add(array $data)
    {
        try {
            $result = $this->obj->create($data);
        } catch (\Exception $e) {
            \Log::error($this->obj->getTable() . ' create error :' . $e->getMessage());
            $result = ['error' => $e->getMessage()];
        }
        return $result;
    }

    /**
     * Notes:列表
     * Name: getList
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:21
     * @return mixed
     */
    public function getList()
    {
        return $this->obj->orderby('id', 'desc')->paginate(5);
    }

    /**
     * Notes:根据id查看
     * Name: getIndex
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:20
     * @param int $id
     * @return mixed
     */
    public function getIndex(int $id)
    {
        return $this->obj->findOrFail($id);
    }

    /**
     * Notes:删除
     * Name: delete
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:20
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        try {
            $result = $this->getIndex($id);
            $result->delete();
        } catch (\Exception $e) {
            \Log::error('delete error :' . $e->getMessage());
            $result = ['error' => $e->getMessage()];
        }

        return $result;
    }

    /**
     * Notes:更新
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:20
     * @param array $data
     * @param int $id
     * @return array
     */
    public function update(array $data, int $id)
    {
        try {
            $result = $this->getIndex($id);
            foreach ($data as $k => $item) {
                $result->$k = $item;
            }
            $result->save();
        } catch (\Exception $e) {
            \Log::error('update error:' . $e->getMessage());
            $result = ['error' => $e->getMessage()];
        }

        return $result;
    }
}