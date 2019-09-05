<?php


class RoleController
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /***
     * Notes:角色列表
     * Name: index
     * User: LiYi
     * Date: 2019/8/17
     * Time: 19:00
     * @return mixed
     */
    public function index()
    {
        $roles = Role::all();;
        return view($this->role->getTable() . '.' . __FUNCTION__)->with([$this->role->getTable() => $roles]);
    }

    /**
     * Notes:创建角色表单
     * Name: create
     * User: LiYi
     * Date: 2019/8/17
     * Time: 19:00
     * @return mixed
     */
    public function create()
    {
        $permissions = Permission::all();
        return view($this->role->getTable() . '.' . __FUNCTION__)->with( ['permissions'=>$permissions]);
    }

    /**
     * Notes:创建角色提交
     * Name: store
     * User: LiYi
     * Date: 2019/8/17
     * Time: 19:00
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        /**
         * 验证参数
         */
        $request->validate([
                'name'=>'required|unique:roles|max:10',
                'permissions' =>'required',
            ]
        );

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();//保存角色

        /**
         * 得到权限数组
         */
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            //给对应的角色赋权
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role'. $role->name.' added!');
    }

    /**
     * Notes:编辑角色表单
     * Name: edit
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:59
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view($this->role->getTable() . '.' . __FUNCTION__, compact('role', 'permissions'));
    }

    /**
     * Notes:查看角色
     * Name: show
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:59
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return redirect($this->role->getTable());
    }

    /**
     * Notes:更新角色信息
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:59
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);//得到角色信息

        /**
         * 验证参数
         */
        $request->validate([
            'name'=>'required|max:10|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);//去掉权限参数
        $permissions = $request['permissions'];
        $role->fill($input)->save();//保存角色

        $p_all = Permission::all();//得到全部权限

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //删除对应角色所拥有的权限
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //得到权限信息
            $role->givePermissionTo($p);  //权限角色关联
        }

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role'. $role->name.' updated!');
    }

    /**
     * Notes:删掉角色
     * Name: destroy
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:59
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')
            ->with('flash_message',
                'Role deleted!');
    }
}