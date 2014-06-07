<?php
/**
 *语音回复
**/
class ClassifyAction extends UserAction{
	public function index(){
		//检查权限和功能
		$this->checkauth('Classify','Classify');
		
		$db=D('Classify');
		$where['token']=session('token');
		$count=$db->where($where)->count();
		$page=new Page($count,25);
		$infotmp=$db->where($where)->order('id asc')->limit($page->firstRow.','.$page->listRows)->select();
		$info = $infotmp;
		foreach ($infotmp as $onekey=>$oneval){
			$i = $onekey + 1;
			$info[$onekey]["sorts"] = $i;
		}
		$this->assign('page',$page->show());
		$this->assign('info',$info);
		//dump($info);exit;
		$this->display();
	}
	
	public function add(){
		$this->display();
	}
	
	public function edit(){
		$id=$this->_get('id','intval');
		$info=M('Classify')->find($id);
		$this->assign('info',$info);
		$this->display();
	}
	
	public function del(){
		$where['id']=$this->_get('id','intval');
		$where['uid']=session('uid');
		if(D(MODULE_NAME)->where($where)->delete()){
			
			
				//同步到商品分类
				$itemcatewhere['tags'] = $where['id'];
				$itemcatewhere['tokenTall'] = session('token');
				M('item_cate')->where($itemcatewhere)->delete();
			
			
			
			$this->success('操作成功',U(MODULE_NAME.'/index'));
		}else{
			$this->error('操作失败',U(MODULE_NAME.'/index'));
		}
	}
	public function insert(){
		$this->all_insert();
	}
	public function upsave(){
		$this->all_save();
	}
}
?>