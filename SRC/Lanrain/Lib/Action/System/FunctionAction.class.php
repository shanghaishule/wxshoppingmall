<?php
class FunctionAction extends BackAction{
	public function index(){
		//$map = array();
		$map = $this->belong_where;
		
		$UserDB = D('Function');
		$count = $UserDB->where($map)->count();
		$Page       = new Page($count,5);// 实例化分页类 传入总记录数
		// 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
		$nowPage = isset($_GET['p'])?$_GET['p']:1;
		$show    = $Page->show();// 分页显示输出
		$list = $UserDB->where($map)->order('id ASC')->limit($Page->firstRow.','.$Page->listRows)->select();			
		
		$group=M('User_group')->field('id,name')->order('id desc')->select();
		foreach($group as $key=>$val){
			$g[$val['id']]=$val['name'];
		}
		unset($group);
		
		$belong=M('User')->field('id, username')->order('id desc')->select();
		foreach($belong as $key=>$val){
			$be[$val['id']]=$val['username'];
		}
		unset($belong);
		
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('group',$g);
		$this->assign('belong',$be);
		$this->display();
	}
	public function add(){
		if(IS_POST){
			//dump($_POST);exit;
			$p = $_POST;
			if ($p['belonguser'] == '0') {
				$user = M('user')->where(array('status'=>1))->select();
				$db = M('Function');
				foreach ($user as $val){
					$p['belonguser'] = $val['id'];
					if ($db->add($p)){
						continue;
					} else {
						$this->error('操作失败');
					}
				}
				$this->success('操作成功', U('Function/index'));
			}else{
				$this->all_insert();
			}
		}else{
			$group=D('User_group')->getAllGroup('status=1');
			$this->assign('group',$group);
			$userinfo = M('User')->field('id, username')->where('status = 1')->select();
			$this->assign('userinfo',$userinfo);
			$this->display();
		}
	}
	public function edit(){
		if(IS_POST){
			$this->all_save();
		}else{
			$id=$this->_get('id','intval',0);
			if($id==0)$this->error('非法操作');
			$this->assign('tpltitle','编辑');
			$fun=M('Function')->where(array('id'=>$id))->find();
			$this->assign('info',$fun);
			$group=D('User_group')->getAllGroup('status=1');
			$this->assign('group',$group);
			$userinfo = M('User')->field('id, username')->where('status = 1')->select();
			$this->assign('userinfo',$userinfo);
			$this->display('add');
		}
	}	
	public function del(){
		if(IS_POST){
			$this->all_save();
		}else{
			$id=$this->_get('id','intval',0);
			if($id==0)$this->error('非法操作');
			$this->assign('tpltitle','编辑');
			$fun=M('Function')->where(array('id'=>$id))->delete();
			if($fun==false){
				$this->error('删除失败');
			}else{
				$this->success('删除成功');
			}
		}
	}
}
?>