<?php
class UserAction extends BackAction{
	public function _initialize() {
        parent::_initialize();  //RBAC 验证接口初始化
    }
	public function index(){
        $role = M('Role')->getField('id,name');
        $map = array();
        $map['role'] = array('neq','0');
        $UserDB = D('User');
        $count = $UserDB->where($map)->count();
        $Page       = new Page($count);// 实例化分页类 传入总记录数
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        $show       = $Page->show();// 分页显示输出
        $list = $UserDB->where($map)->order('id ASC')->page($nowPage.','.C('PAGE_NUM'))->select();
        $this->assign('role',$role);
        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }

    // 添加用户
    public function add(){
    	//$this->error('新增用户将新增一套功能列表，因此关闭此功能!');
    	
        $UserDB = D("User");
        if(isset($_POST['dosubmit'])) {
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if(empty($password) || empty($repassword)){
                $this->error('密码必须填写！');
            }
            if($password != $repassword){
                $this->error('两次输入密码不一致！');
            }
            if(! is_numeric($_POST['remark'])){
            	$this->error('可建用户数必须为数字！');
            }
            //根据表单提交的POST数据创建数据对象
            if($UserDB->create()){
                $user_id = $UserDB->add();
                if($user_id){
                    $data['user_id'] = $user_id;
                    $data['role_id'] = $_POST['role'];
                    if (M("role_user")->data($data)->add()){
                    	//新建用户时，以admin所拥有的模块为模板，批量添加所属功能模块
                    	$funmodel = M('Function');
                    	$allfun = $funmodel->where(array('belonguser'=>1))->select();
                    	foreach ($allfun as $val){
                    		$d = $val;
                    		unset($d['id']);
                    		$d['belonguser']=$user_id;
                    		$funmodel->add($d);
                    	}
                    	
                    	
                        $this->assign("jumpUrl",U('User/index'));
                        $this->success('添加成功！');
                    }else{
                        $this->error('用户添加成功,但角色对应关系添加失败!');
                    }
                }else{
                     $this->error('添加失败!');
                }
            }else{
                $this->error($UserDB->getError());
            }
        }else{
            $role = D('Role')->getAllRole(array('status'=>1),'sort DESC');
            $this->assign('role',$role);
            $this->assign('tpltitle','添加');
            $this->display();
        }
    }

    // 编辑用户
    public function edit(){
         $UserDB = D("User");
        if(isset($_POST['dosubmit'])) {
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if(!empty($password) || !empty($repassword)){
                if($password != $repassword){
                    $this->error('两次输入密码不一致！');
                }
                $_POST['password'] = md5($password);
            }
            if(! is_numeric($_POST['remark'])){
            	$this->error('可建用户数必须为数字！');
            }
            if(empty($password) && empty($repassword)) unset($_POST['password']);   //不填写密码不修改
            //根据表单提交的POST数据创建数据对象
            if($UserDB->create()){
                if($UserDB->save()){
                    $where['user_id'] = $_POST['id'];
                    $data['role_id'] = $_POST['role'];
                    M("role_user")->where($where)->save($data);
                    $this->assign("jumpUrl",U('User/index'));
                    $this->success('编辑成功！');
                }else{
                     $this->error('编辑失败!');
                }
            }else{
                $this->error($UserDB->getError());
            }
        }else{
            $id = $this->_get('id','intval',0);
            if(!$id)$this->error('参数错误!');
            $role = D('Role')->getAllRole(array('status'=>1),'sort DESC');
            $info = $UserDB->getUser(array('id'=>$id));
            $this->assign('tpltitle','编辑');
            $this->assign('role',$role);
            $this->assign('info',$info);
            $this->display('add');
        }
    }

    //ajax 验证用户名
    public function check_username(){
        $userid = $this->_get('userid');
        $username = $this->_get('username');
        if(D("User")->check_name($username,$userid)){
            echo 1;
        }else{
            echo 0;
        }
    }

    //删除用户
    public function del(){
        $id = $this->_get('id','intval',0);
        if(!$id)$this->error('参数错误!');
        $UserDB = D('User');
        $info = $UserDB->getUser(array('id'=>$id));
        if($info['username']==C('SPECIAL_USER')){     //无视系统权限的那个用户不能删除
           $this->error('禁止删除此用户!');
        }
        //删除所属的前端用户、公众号、功能列表
        //删除公众号
        $model=new Model();
        $querystr = "delete a from tp_wxuser a, tp_users b where a.uid=b.id and b.belonguser=".$id;
        //dump($querystr);exit;
        $res=$model->execute($querystr);
    	if ($res===false) {
        	$this->error('删除所管理的公众号失败!');
        }
        //删除前端用户
        $res=M('users')->where(array('belonguser'=>$id))->delete();
        if ($res===false) {
        	$this->error('删除所管理的前端用户失败!');
        }
        //删除功能列表
        $res=M('Function')->where(array('belonguser'=>$id))->delete();
        if ($res===false) {
        	$this->error('删除所拥有的功能列表失败!');
        }
        
        //删除本表
        if($UserDB->delUser('id='.$id)){
            if(M("role_user")->where('user_id='.$id)->delete()){
                $this->assign("jumpUrl",U('User/index'));
                $this->success('删除成功！');
            }else{
                $this->error('用户成功,但角色对应关系删除失败!');
            }
        }else{
            $this->error('删除失败!');
        }
    }
}