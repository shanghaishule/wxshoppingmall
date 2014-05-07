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
				$orderinfo = $mod->where("orderId='".$data['orderId']."'")->find();
				if ($orderinfo['supportmetho'] == 4) {
					if($this->orderWxDeliver($data['orderId'])){
						$this->success('发货成功！', U('Wetall_order/index'));
					}else{
						$this->error('微信发货通知失败');
					}
				} else {
					$this->success('发货成功！', U('Wetall_order/index'));
				}
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
	
	

	/*订单微信发货接口*/
	public function orderWxDeliver($num="")
	{
	
		if ($num != "") {
			header('Content-Type:text/html;charset=utf-8');
			$wetallroute = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
			//dump($wetallroute);exit;
			include $wetallroute."/weTall/wxpay/config.php";
			//dump($config);exit;
			include $wetallroute."/weTall/wxpay/lib.php";
	
			//取支付信息
			$zhifuhaoArr = M('order_merge')->where(array('orderid'=>$num))->find();
			$zhifuhao = $zhifuhaoArr['mergeid'];
			$payinfoArr = M('wxpay_history')->where(array('out_trade_no'=>$zhifuhao))->find();
			$parameter = array(
					'appid' => $config['appId'],
					'openid' => $payinfoArr['openid'], // 购买用户的 OpenId，这个已经放在最终支付结果通知的 PostData 里了
					'transid' => $payinfoArr['transaction_id'], // 交易单号
					'out_trade_no' => $payinfoArr['out_trade_no'], // 本站订单号
					'deliver_timestamp' => mktime(), // 发货时间戳，这里指得是 linux 时间戳
					'deliver_status' => '1', // 发货状态，1 表明成功，0 表明失败，失败时需要在 deliver_msg 填上失败原因
					'deliver_msg' => 'ok' // 是发货状态信息，失败时可以填上 UTF8 编码的错误提示信息，比如“该商品已退款”
			);
			//dump($parameter);exit;
			$wechat = new Wechat;
			//dump($wechat);exit;
				
			$result = $wechat->delivernotify($config, $parameter);
			//dump($result);exit;
			if (($result['errcode'] == 0) && ($result['errmsg'] == 'ok')) { //成功
				return true;
			}else{
				return false;
			}
		}else {
			return false;
		}
	}
	
	 
	/*订单微信查询接口*/
	public function orderWxQuery($num="")
	{
		$num = $num == "" ? $_GET['orderId'] : $num;
		 
		$zhifuhao=M('order_merge')->where(array('orderid'=>$num))->getField('mergeid');
		 
		if ($zhifuhao != "") {
			header('Content-Type:text/html;charset=utf-8');
			$wetallroute = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
			include $wetallroute."/weTall/wxpay/config.php";
			//dump($config);exit;
			include $wetallroute."/weTall/wxpay/lib.php";
			$wechat = new Wechat;
			$result = $wechat->orderquery($config, $zhifuhao);
			if (($result['errcode'] == 0) && ($result['errmsg'] == 'ok')) { //成功返回
				if ($result['order_info']['ret_code'] == 0 && $result['order_info']['trade_state'] == "0") {
					$this->success('该订单已支付成功！');
				}else{
					$this->error('该订单支付失败！'.'['.$result['order_info']['ret_code'].']'.$result['order_info']['ret_msg']);
				}
	
			}else{
				$this->error('该订单查询失败！'.'['.$result['errcode'].']'.$result['errmsg']);
			}
		}else {
			$this->error("没有取到订单号！");
		}
	}
	
	
}
?>