<?php
class Wetall_orderAction extends UserAction{
	public function _initialize() {
		parent::_initialize();
		$this->_mod = D('item_order');
        $order_status=array(1=>'待付款',2=>'待发货',3=>'待收货',4=>'完成',5=>'关闭');
        $this->assign('order_status',$order_status);
        $supportmetho=array(1=>'支付宝个人转账支付',2=>'货到付款',3=>'银联支付',4=>'微信支付',5=>'支付宝商家即时到帐支付');
        $this->assign('supportmetho',$supportmetho);
        $freetype=array(0=>'卖家包邮',1=>'平邮',2=>'快递',3=>'EMS');
        $this->assign('freetype',$freetype);
        
	}
	
	
	public function index(){
		$tokenTall = $this->getTokenTall();
		$map = array();
		$map['tokenTall'] = $tokenTall;
		
		if(IS_POST){
			$orderId = $this->_post('orderId');
			if ($orderId != "") {
				$map['orderId'] = array('like',"%$orderId%");
			}
			$search['orderId'] = $orderId;
			
			$status = $this->_post('status');
			if ($status == "") {
				$map['status'] = array('neq', 0);
			}else{
				$map['status'] = $status;
			}
			$search['status'] = $status;
			//dump($map);exit;
			
		}else{
			//兼容URL传参
			$get_status = $this->_get('status');
			if ($get_status == "") {
				$map['status'] = array('neq', 0);
			}else{
				$map['status'] = $get_status;
			}
			$search['status'] = $get_status;
			
		}
		$this->assign('searcharr',$search);
		
		$mod = $this->_mod;
		!empty($mod) && $this->_list($mod, $map);
		$this->display();
	}

	public function update() {
		if (IS_POST) {
			$itemprice["id"] = $_POST["id"];
			$itemprice["order_sumPrice"] = $_POST["order_sumPrice"];
			//dump($itemprice);exit;
			if(false !== M("item_order")->save($itemprice)){
				$this->success('成功');
			}else {
				$this->error('失败');
			}
		} else {
			$id = $this->_get('id','intval');
			$item = $this->_mod->where(array('id'=>$id))->find();
			$this->assign('info', $item); // 订单详细信息
			$this->display();
		}
	}
	
	public function edit() {
		$id = $this->_get('id','intval');
		$item = $this->_mod->where(array('id'=>$id))->find();
		 
		$order_detail=M('order_detail')->where("orderId='".$item['orderId']."'")->select();
		
		$fahuoaddress=M('address')->find($item['fahuoaddress']);

		$this->assign('fahuoaddress',$fahuoaddress);//发货地址
		$this->assign('order_detail',$order_detail);//订单商品信息
		$this->assign('info', $item); // 订单详细信息
		$this->display();
	}
	
	public function del()
	{
		$id = $this->_get('id');
		$item = $this->_mod->where(array('id'=>$id))->find();
		if ($item) {
			M('order_detail')->where(array('orderId'=>$item['orderId']))->delete();
			M('order_merge')->where(array('orderid'=>$item['orderId']))->delete();
			$this->_mod->where(array('orderId'=>$item['orderId']))->delete();
			
			$this->success('删除成功！');
		} else {
			$this->error('找不到这个订单！');
		}
	}
	
	public function status()
	{
		$orderId= $this->_get('orderId', 'trim');
		!$orderId && $this->_404();
		$status= $this->_get('status', 'intval');
		!$status && $this->_404();
	
		if($status==4){
			$data['status']=$status;
			if($this->_mod->where("orderId='".$orderId."'")->save($data))
			{
				$order_detail=M('order_detail');
				$item=M('item');
				$order_details = $order_detail->where("orderId='".$orderId."'")->select();
				foreach ($order_details as $val)
				{
					$item->where("id='".$val['itemId']."'")->setInc('buy_num',$val['quantity']);
				}
				$dataTall["tokenTall"]=$this->_get("tokenTall","trim");
				$shopcredit=M("wecha_shop");
				$shopDetail=$shopcredit->where($dataTall)->find();
				$updateCredit["credit"]=$shopDetail["credit"]+1;
				if($shopcredit->where($dataTall)->save($updateCredit)){
					$this->success('修改订单状态成功!');
				}
			}else
			{
				$this->error('修改订单状态失败!');
			}
		}else{
			$data['status']=$status;
			if($this->_mod->where("orderId='".$orderId."'")->save($data)){
				$this->success('修改订单状态成功!');
			}else{
				$this->error('修改订单状态失败!');
			}
		}
	}
	
	public function fahuo()
	{
		$mod = $this->_mod;
		if (IS_POST && $this->_post('orderId','trim')) {
			//dump($_POST);exit;
			
			if (false === $data = $mod->create()) {
				$this->error($mod->getError());
			}
			
			if($_POST['delivery']=='0')
			{
				$date['userfree']=0;
			}else
			{
				$date['userfree']=$_POST['delivery'];
				$date['freecode']=$_POST['deliverycode'];
				$date['fahuoaddress']=$data['address'];
			}
			$date['fahuo_time']=time();
			$date['status']=3;
			if($mod->where("orderId='".$data['orderId']."'")->data($date)->save()){
				$this->success('发货成功！', U('Wetall_order/index'));
			} else {
				$this->error('发货失败！');
			}
		} else {
			$id= $this->_get('id','trim');//订单号ID
			$info= $this->_mod->find($id);
			$this->assign('info',$info);
			$deliveryList=	M('delivery')->where('status=1')->order('ordid asc,id asc')->select();//快递方式
			$this->assign('deliveryList',$deliveryList);
			$addressList=M('address')->where('status=1')->order('ordid asc,id asc')->select();//发货地址
			$this->assign('addressList',$addressList);
			$this->display();
		}
	}
	
}
?>