<?php


class PostController
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Notes:posts 列表数据
     * Name: index
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:18
     * @return mixed
     */
    public function index()
    {
        $result = (new MiddlewareModel($this->post))->getList();
        return view($this->post->getTable() . '.' . __FUNCTION__)->with([$this->post->getTable() => $result]);
    }

    /**
     * Notes: 添加文章 form
     * Name: create
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:18
     * @return mixed
     */
    public function create()
    {
        return view($this->post->getTable() . '.' . __FUNCTION__);
    }

    /**
     * Notes: 添加文章form 提交
     * Name: store
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:18
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:100',
            'body' =>'required',
        ]);

        $result = (new MiddlewareModel($this->post))->add($request->only('title', 'body'));

        return redirect()->route($this->post->getTable() . 'index')
            ->with('flash_message', 'Article,
             '. $result['title'].' created');
    }

    /**
     * Notes: 编辑文章页面
     * Name: edit
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:19
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $result = (new MiddlewareModel($this->post))->getIndex($id);
        return view($this->post->getTable() . '.' . __FUNCTION__)
            ->with([$this->post->getTable() => $result]);
    }

    /**
     * Notes: 查看文章
     * Name: show
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:19
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $result = (new MiddlewareModel($this->post))->getIndex($id);
        return view($this->post->getTable() . '.' . __FUNCTION__)
            ->with([$this->post->getTable() => $result]);
    }

    /**
     * Notes: 更新文章
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:19
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required|max:100',
            'body' =>'required',
        ]);
        $result = (new MiddlewareModel($this->post))->update($request->only('title', 'body') ,$id);

        if (isset($result['error'])) {
            return redirect()->route('posts.show',
                $id)->with('flash_message',
                'Article, '. $result['error'].' updated');
        }
        return redirect()->route('posts.show',
            $result->id)->with('flash_message',
            'Article, '. $result->title.' updated');
    }

    /**
     * Notes: 删除文章
     * Name: destroy
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:20
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        (new MiddlewareModel($this->post))->delete($id);

        return redirect()->route($this->post->getTable() . '.index')
            ->with('flash_message',
                'Article successfully deleted');
    }
}