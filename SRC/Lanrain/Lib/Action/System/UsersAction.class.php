<?php
class UsersAction extends BackAction{
	
	public function index(){
		$db=D('Users');
		$group=M('User_group')->field('id,name')->order('id desc')->select();
		$count= $db->count();
		$Page= new Page($count,25);
		$show= $Page->show();
		$list = $db->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->where($this->belong_where)->select();
		foreach($group as $key=>$val){
			$g[$val['id']]=$val['name'];
		}
		unset($group);
		$belong=M('User')->field('id, username')->order('id desc')->select();
		foreach($belong as $key=>$val){
			$be[$val['id']]=$val['username'];
		}
		unset($belong);
		//dump($list);exit;
		$this->assign('info',$list);
		$this->assign('page',$show);
		$this->assign('group',$g);
		$this->assign('belong',$be);
		$this->display();
	}
	
	// 添加用户
    public function add(){
    	//检查是否可以创建用户
    	$current_user = M('User')->where(array('id'=>$_SESSION['userid']))->find();
    	$has_create_cnt = M(Users)->where(array('belonguser'=>$_SESSION['userid']))->count();
    	//dump($current_user['remark']); dump($has_create_cnt); exit;
    	if ($current_user['remark'] != "" && $has_create_cnt >= $current_user['remark']) {
    		$this->error('您不能创建更多的前台用户！（最多创建'.$current_user['remark'].'个）');
    	}
    	
        $UserDB = D("Users");
        if(isset($_POST['dosubmit'])) {
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if(empty($password) || empty($repassword)){
                $this->error('密码必须填写！');
            }
            if($password != $repassword){
                $this->error('两次输入密码不一致！');
            }
            //根据表单提交的POST数据创建数据对象
			$_POST['viptime']=strtotime($_POST['viptime']);
            if($UserDB->create()){				
                $user_id = $UserDB->add();
                if($user_id){
					$this->success('添加成功！',U('Users/index'));                    
                }else{
                     $this->error('添加失败!');
                }
            }else{
                $this->error($UserDB->getError());
            }
        }else{
            $role = M('User_group')->field('id,name')->where('status = 1')->select();
            $this->assign('role',$role);
            
            //dump($_SESSION);exit;
            if ($_SESSION["username"] == "admin") {
            	$wherestr = " 1=1 ";
            }else{
            	$wherestr = " username = '".$_SESSION["username"]."' ";
            }            
            $userinfo = M('User')->field('id, username')->where('status = 1 and '.$wherestr)->select();
            $this->assign('userinfo',$userinfo);
            
            $this->assign('tpltitle','添加');
            $this->display();
        }
    }
	public function search(){
		$name=$this->_post('name');
		$type=$this->_post('type');
		switch($type){
			case 1:
			$data['username']=$name;
			break;
			case 2:
			$data['id']=$name;
			break;
			case 3:
			$data['email']=$name;
		}
		//dump($where);
		$list=M('Users')->where($data)->select();
		$this->assign('info',$list);
		$this->display('index');
	
	}
    // 编辑用户
    public function edit(){
         $UserDB = D("Users");
        if(isset($_POST['dosubmit'])) {
            $password = $this->_post('password','trim',0);
            $repassword = $this->_post('repassword','trim',0);
			$users=M('Users')->field('gid')->find($_POST['id']);
            if($password != $repassword){
                $this->error('两次输入密码不一致！');
            }
            if($password==false){ 
				unset($_POST['password']);
				unset($_POST['repassword']);
			}else{
				$_POST['password']=md5($password);
			}
			unset($_POST['dosubmit']);
			unset($_POST['__hash__']);
            //根据表单提交的POST数据创建数据对象
				$_POST['viptime']=strtotime($_POST['viptime']);
                if($UserDB->save($_POST)){
					if($_POST['gid']!=$users['gid']){
						$fun=M('Function')->field('funname,gid,isserve')->where('`gid` <= '.$_POST['gid'])->select();
						foreach($fun as $key=>$vo){
							$queryname.=$vo['funname'].',';
						}
						$open['queryname']=rtrim($queryname,',');
						$uid['uid']=$_POST['id'];
						$token=M('Wxuser')->field('token')->where($uid)->select();
						if($token){
							$token_db=M('Token_open');
							foreach($token as $key=>$val){
								$wh['token']=$val['token'];
								$token_db->where($wh)->save($open);
							}
						}
					}
                    $this->success('编辑成功！',U('Users/index'));
                }else{
                     $this->error('编辑失败!');
                }
            
        }else{
            $id = $this->_get('id','intval',0);
            if(!$id)$this->error('参数错误!');
            $role = M('User_group')->field('id,name')->where('status = 1')->select();
            $info = $UserDB->find($id);
            $this->assign('tpltitle','编辑');
            $this->assign('role',$role);
            $userinfo = M('User')->field('id, username')->where('status = 1')->select();
            $this->assign('userinfo',$userinfo);
            $this->assign('info',$info);
            $this->display('add');
        }
    }
	
	public function addfc(){
		$token_open=M('Token_open');
		$open['uid']=session('uid');
		$open['token']=$_POST['token'];
		$gid=session('gid');
		$fun=M('Function')->field('funname,gid,isserve')->where('`gid` <= '.$gid)->select();
		foreach($fun as $key=>$vo){
			$queryname.=$vo['funname'].',';
		}
		$open['queryname']=rtrim($queryname,',');
		$token_open->data($open)->add();
	}
	
	//删除用户
    public function del(){
        $id = $this->_get('id','intval',0);
        if(!$id)$this->error('参数错误!');
        $UserDB = D('Users');
        if($UserDB->delete($id)){
			$where['uid']=$id;
			M('wxuser')->where($where)->delete();
			M('token_open')->where($where)->delete();
			M('text')->where($where)->delete();
			M('img')->where($where)->delete();
			M('member')->where($where)->delete();
			M('indent')->where($where)->delete();
			M('areply')->where($where)->delete();
			$this->success('删除成功！');            
        }else{
            $this->error('删除失败!');
        }
    }
    
    //冻结、取消冻结
    public function set(){
    	$id = $this->_get('id','intval',0);
    	if(!$id)$this->error('参数错误!');
    	$status = $this->_get('status','intval',0);
    	
    	$UserDB = D('Users');
    	if($UserDB->save(array('id'=>$id, 'status'=>$status))){
    		$this->success('操作成功！');
    	}else{
    		$this->error('操作失败!');
    	}
    }
}