<?php


class PermissionController
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Notes: 列表
     * Name: index
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:50
     * @return mixed
     */
    public function index()
    {
        $result =  $permissions = Permission::all();
        return view($this->permission->getTable() . '.' . __FUNCTION__)
            ->with([$this->permission->getTable() => $result]);
    }

    /**
     * Notes:创建 form
     * Name: create
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:50
     * @return mixed
     */
    public function create()
    {
        $roles = Role::get();
        return view($this->permission->getTable() . '.' . __FUNCTION__)->with('roles', $roles);
    }

    /**
     * Notes:创建提交数据
     * Name: store
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:50
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        /**
         * 参数验证
         */
        $request->validate([
            'name'=>'required|max:40',
        ]);

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();//保存权限

        if (!empty($request['roles'])) {//判断角色是否存在
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail();
                $permission = Permission::where('name', '=', $name)->first();
                $r->givePermissionTo($permission);//给每个角色和权限绑定
            }
        }

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission'. $permission->name.' added!');

    }

    /**
     * Notes:编辑form
     * Name: edit
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:50
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view($this->permission->getTable() . '.' . __FUNCTION__)
            ->with([$this->permission->getTable() => $permission]);
    }

    /**
     * Notes:查看
     * Name: show
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:49
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return redirect($this->permission->getTable());
    }

    /**
     * Notes:更新
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:49
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        /**
         *
         * 验证参数
         */
        $request->validate($request, [
            'name'=>'required|max:40',
        ]);
        $input = $request->all();
        $permission->fill($input)->save();//保存权限

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission'. $permission->name.' updated!');

    }

    /**
     * Notes:
     * Name: destroy
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:49
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        /**
         * 是管理员就不让删除
         */
        if ($permission->name == "Administer") {
            return redirect()->route('permissions.index')
                ->with('flash_message',
                    'Cannot delete this Permission!');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission deleted!');
    }
}