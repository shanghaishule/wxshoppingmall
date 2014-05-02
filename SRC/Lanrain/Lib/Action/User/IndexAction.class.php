<?php
class IndexAction extends UserAction{
	public function index(){
		$where['id']=session('uid');
		$info = M('users')->where($where)->find();
		if ($info){
			if ($info['contact'] == "" or $info['phone'] == "" or $info['email'] == "" or $info['address'] == ""){
				$this->success('请先完善您的资料！', U('Myinfo/info'));
			}else{
				$this->display();
			}
		}
	}
}
?>