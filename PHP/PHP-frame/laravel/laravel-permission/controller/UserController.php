<?php


class UserController
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Notes:用户列表
     * Name: index
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:34
     * @return mixed
     */
    public function index()
    {
        $result = User::all();
        return view($this->user->getTable() . '.' . __FUNCTION__)->with([$this->user->getTable() => $result]);
    }

    /**
     * Notes:创建用户form
     * Name: create
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:35
     * @return mixed
     */
    public function create()
    {
        $roles = Role::get();//得到角色列表
        return view($this->user->getTable() . '.' . __FUNCTION__)
            ->with(['roles'=>$roles]);
    }

    /**
     * Notes:创建用户form提交
     * Name: store
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:35
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        /**
         * 验证参数
         */
        $request->validate([
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);

        $data = ['password' => Hash::make($request->only('email', 'name', 'password')['password'])];

        /**
         * 用户数据MySQL提交
         */
        $user = User::create(array_merge($request->only('email', 'name', 'password'), $data)); //Retrieving only the email and password data

        $roles = $request['roles']; //Retrieving the roles field
        //验证角色id是否存在
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //给用户赋权
            }
        }
        //Redirect to the users.index view and display message
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully added.');
    }

    /**
     * Notes:编辑用户
     * Name: edit
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:35
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); //得到用户星系
        $roles = Role::get(); //得到全部权限
        return view($this->user->getTable() . '.' . __FUNCTION__, compact('user', 'roles'));
    }

    /**
     * Notes:查看
     * Name: show
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:35
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return redirect($this->user->getTable());
    }

    /**
     * Notes:编辑用户提交
     * Name: update
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:36
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); //得到用户信息

        //验证参数
        $request->validate([
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required|min:6|confirmed'
        ]);
        $input = $request->only(['name', 'email', 'password']); //Retreive the name, email and password fields
        $data = ['password' => Hash::make($input['password'])];
        $roles = $request['roles']; //Retreive all roles
        $user->fill(array_merge($input, $data))->save();//保存用户信息修改

        if (isset($roles)) {
            $user->roles()->sync($roles);  //判断权限是否存在，存在重新赋权
        } else {
            $user->roles()->detach(); //不存在，把之前的权限全部删除
        }
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully edited.');
    }

    /**
     * Notes:删除用户
     * Name: destroy
     * User: LiYi
     * Date: 2019/8/17
     * Time: 18:34
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully deleted.');
    }
}