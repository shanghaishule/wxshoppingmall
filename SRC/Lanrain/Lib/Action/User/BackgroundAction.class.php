<?php
/**
 *首页背景图片
**/
class BackgroundAction extends UserAction{
	public $token;
	public $home_db;
	public $back_db;

	public function _initialize() {
		parent::_initialize();
		$this->token=$this->_session('token');
		$this->home_db=M('home');
		$this->back_db=D('Background');
		
	}
	
	public function index(){
		//检查权限和功能
		$this->checkauth('Background','Background');
		
		$db=$this->back_db;
		$where['uid']=session('uid');
		$where['token']=$this->token;
		$count=$db->where($where)->count();

		$page=new Page($count,25);
		$info=$db->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('page',$page->show());
		$this->assign('info',$info);
		$this->display();
	}
	public function add(){
		$where['uid']=session('uid');
		$where['token']=$this->token;
		$count=$this->back_db->where($where)->count();
		
		if ($count) {
			$this->error('背景只能有一张！');
		}else{
			$this->display();
		}
	}
	public function edit(){
		$where['id']=$this->_get('id','intval');
		$where['uid']=session('uid');
		$res=D('Background')->where($where)->find();
		$this->assign('info',$res);
		$this->display();
	}
	public function del(){
		$where['id']=$this->_get('id','intval');
		$where['uid']=session('uid');
		if(D(MODULE_NAME)->where($where)->delete()){
			$this->home_db->where(array('token'=>$this->token))->save(array('homeurl'=>''));
			$this->success('操作成功',U(MODULE_NAME.'/index'));
		}else{
			$this->error('操作失败',U(MODULE_NAME.'/index'));
		}
	}
	public function insert(){
		$home=$this->home_db->where(array('token'=>$this->token))->find();
		if ($home) {
			$this->home_db->where(array('token'=>$this->token))->save(array('homeurl'=>$_POST['img']));
			$this->all_insert();
		}else{
			$this->error('请先进行首页设置！', U('Home/set'));
		}
	}
	public function upsave(){
		$home=$this->home_db->where(array('token'=>$this->token))->find();
		if ($home) {
			$this->home_db->where(array('token'=>$this->token))->save(array('homeurl'=>$_POST['img']));
			$this->all_save();
		}else{
			$this->error('请先进行首页设置！', U('Home/set'));
		}
	}
	
}
?>