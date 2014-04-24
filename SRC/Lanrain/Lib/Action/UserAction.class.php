<?php
class UserAction extends BaseAction{
	protected function _initialize(){
		parent::_initialize();
		$userinfo=M('User_group')->where(array('id'=>session('gid')))->find();
		$users=M('Users')->where(array('id'=>$_SESSION['uid']))->find();
		$this->assign('thisUser',$users);
		//dump($users);
		$this->assign('viptime',$users['viptime']);
		if(session('uid')){
			if($users['viptime']<time()){
				session(null);
				session_destroy();
				unset($_SESSION);
				$this->error('您的帐号已经到期，请联系您的总代理。');
			}
		}
		
		$this->assign('userinfo',$userinfo);
		if(session('uid')==false){
			$this->redirect('Home/Index/login');
		}
		
		$allfunction = M('Function')->where(array('belonguser'=>session('belonguser')))->select();
		$allfunctiontype = M('Function')->Distinct(true)->field('funtype')->where(array('belonguser'=>session('belonguser'),'funtype'=>array('neq','默认')))->order('usenum')->select();
		$this->assign('allfunction',$allfunction);
		$this->assign('allfunctiontype',$allfunctiontype);
		
		$where['uid']=session('uid');
		$info=M('Wxuser')->where($where)->find();
		session('token',$info['token']);
		session('wxid',$info['id']);
		
		$wecha=M('Wxuser')->field('wxname,wxid,headerpic,weixin')->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		$this->assign('wecha',$wecha);
		$this->assign('token',session('token'));
		
		
		//dump(session('token'));exit;
		
	}
	
	public function checkauth($funname, $modname){
		//dump($_SESSION);exit;
		//检查权限
		$func = M('Function')->where(array('funname'=>$funname,'belonguser'=>session('belonguser')))->find();
		if ($func) {
			if ($func['gid'] > session('gid')) {
				$this->error('您没有该模块的使用权限,请升级您的账号！');
			}
		}else{
			$this->error('您没有配置该模块,请联系您的总代理！');
		}
		
		/*
		//检查模块是否勾选
		$token_open=M('token_open')->field('queryname')->where(array('token'=>session('token')))->find();
		if(!strpos($token_open['queryname'],$modname)){
			$this->error('您还未开启该模块的使用,请到功能模块中添加！',U('Function/index',array('token'=>session('token'),'id'=>session('wxid'))));
		}
		*/
	}
}
