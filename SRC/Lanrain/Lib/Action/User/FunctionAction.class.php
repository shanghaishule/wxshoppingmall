<?php
class FunctionAction extends UserAction{
	function index(){
		$id=$this->_get('id','intval');
		$token=$this->_get('token','trim');	
		$info=M('Wxuser')->find($id);
		if($info==false||$info['token']!==$token){
			$this->error('非法操作',U('Home/Index/index'));
		}
		session('token',$token);
		session('wxid',$info['id']);

		//遍历功能列表
		$token_open=M('Token_open');
		$toback=$token_open->field('id,queryname')->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		if (! $toback) {
			$allfun=M('Function')->where(array('belonguser'=>session('belonguser')))->select();
			//$allfun=$model->table('tp_function a, tp_user b, tp_users c')->where('a.belonguser = b.id and b.id = c.belonguser and c.id = '.session('uid'))->field('a.*')->select();
			$queryname = '';
			foreach ($allfun as $value){
				$queryname .= $value['funname'].',';
			}
			$queryname=rtrim($queryname,',');
			$token_open->add(array('uid'=>session('uid'), 'token'=>session('token'), 'queryname'=>$queryname));
			$toback=$token_open->field('id,queryname')->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		}
		$check=explode(',',$toback['queryname']);
		$this->assign('check',$check);

		//
		$group=M('User_group')->field('id,name')->where('status=1')->select();
		//dump($group);exit;
		foreach($group as $key=>$vo){
			$fun=M('Function')->where(array('status'=>1,'gid'=>$vo['id'],'belonguser'=>session('belonguser')))->select();
			foreach($fun as $vkey=>$vvo){
				$function[$vo['id']][$vkey]=$vvo;
			}
		}
		//dump($function);exit;
		
		$this->assign('fun',$function);
		//
		$wecha=M('Wxuser')->field('wxname,wxid,headerpic,weixin')->where(array('token'=>session('token'),'uid'=>session('uid')))->find();
		$this->assign('wecha',$wecha);
		$this->assign('token',session('token'));
		//
		
		
		
		$this->display();
	}
}

?>