<?php
function strExists($haystack, $needle)
{
	return !(strpos($haystack, $needle) === FALSE);
}
class IndexAction extends BaseAction{
	private $tpl;	//微信公共帐号信息
	private $info;	//分类信息
	private $wecha_id;
	private $copyright;
	public $company;
	public $token;
	public $weixinUser;
	public $homeInfo;
	public function _initialize(){
		parent::_initialize();
		$agent = $_SERVER['HTTP_USER_AGENT']; 
		
/* xxl just for test 		
		if(!strpos($agent,"icroMessenger")&&!isset($_GET['show'])) {
			echo '此功能只能在微信浏览器中使用';exit;
		}
*/		
		//
		$Model = new Model();
		$rt=$Model->query("CREATE TABLE IF NOT EXISTS `tp_site_plugmenu` (
  `token` varchar(60) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '',
  `url` varchar(100) DEFAULT '',
  `taxis` mediumint(4) NOT NULL DEFAULT '0',
  `display` tinyint(1) NOT NULL DEFAULT '0',
  KEY `token` (`token`,`taxis`,`display`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		//
		$this->token=$this->_get('token','trim');
		if (!isset($_SESSION['token'])){
			$_SESSION['token']=$this->token;
		}
		$where['token']=$this->token;
		
		$tpl=D('Wxuser')->where($where)->find();
		$this->weixinUser=$tpl;
		
		if (isset($_GET['wecha_id'])&&$_GET['wecha_id']){
			$_SESSION['wecha_id']=$_GET['wecha_id'];
			$this->wecha_id=$this->_get('wecha_id');
		}
		if (isset($_SESSION['wecha_id'])){
			$this->wecha_id=$_SESSION['wecha_id'];
		}
		//dump($where);
		$info=M('Classify')->where(array('token'=>$this->_get('token'),'status'=>1))->order('id asc')->select();
		$info=$this->convertLinks($info);//加外链等信息
		$gid=D('Users')->field('gid')->find($tpl['uid']);
		$this->userGroup=M('User_group')->where(array('id'=>$gid['gid']))->find();
		$this->copyright=$this->userGroup['iscopyright'];
		
		$this->info=$info;
		$tpl['color_id']=intval($tpl['color_id']);
		$this->tpl=$tpl;
		$company_db=M('company');
		$this->company=$company_db->where(array('token'=>$this->token,'isbranch'=>0))->find();
		$this->assign('company',$this->company);
		//
		$homeInfo=M('home')->where(array('token'=>$this->token))->find();
		$this->homeInfo=$homeInfo;
		$this->assign('iscopyright',$this->copyright);//是否允许自定义版权
		$this->assign('siteCopyright',C('copyright'));//站点版权信息
		$this->assign('homeInfo',$homeInfo);
		//
		$this->assign('token',$this->token);
		//
		
		$this->assign('copyright',$this->copyright);
		//plugmenus
		$plugMenus=$this->_getPlugMenu();
		$this->assign('plugmenus',$plugMenus);
		$this->assign('showPlugMenu',count($plugMenus));
	}
	
	
	public function classify(){
		$this->assign('info',$this->info);
		
		$this->display($this->tpl['tpltypename']);
	}
	
	public function index(){
		//是否是高级模板
		if ($this->homeInfo['advancetpl']){
			echo '<script>window.location.href="/cms/index.php?token='.$this->token.'&wecha_id='.$this->wecha_id.'";</script>';
			exit();
		}
		$where['token']=$this->_get('token');		
		$flash=M('Flash')->where($where)->select();
		$flash=$this->convertLinks($flash);
		$count=count($flash);
		$this->assign('flash',$flash);
		$this->assign('info',$this->info);
		$this->assign('num',$count);
		$this->assign('info',$this->info);
		$this->assign('tpl',$this->tpl);

		//$this->addGuide();
		$this->addHead();
		
		$this->display($this->tpl['tpltypename']);
	}

	
	public function addHead(){
echo <<< EOT
<style type="text/css">
#nav_zcb {width:100%; min-width:320px; max-width:640px; position: relative; margin: 0 auto; left:0px; top:0px; z-index: 100; display:block; box-shadow:0 1px 1px #d9d9d9;}
#nav_zcb ul.navlist_zcb { position: relative; z-index:9999; height:45px; margin:0 auto; border-bottom:1px solid #ccc;box-shadow:0 1px 1px #d9d9d9;}
#nav_zcb .navlist_zcb li { float: left; width:25%; height:45px;  position:relative;}
#nav_zcb .navlist_zcb li span{ display:inline-block; width:100%; height:45px; cursor:pointer;}
#nav_zcb .navlist_zcb li a{ display:block; height:45px;}
#nav_zcb .navlist_zcb li#n_0 span{ background:url(./weTall/static/weixin/images/dingcan/bg1.png) no-repeat center center;}
#nav_zcb .navlist_zcb li#n_1 span{ background:url(./weTall/static/weixin/images/dingcan/bg2.png) no-repeat center center;}
#nav_zcb .navlist_zcb li#n_2 span{ background:url(./weTall/static/weixin/images/dingcan/bg3.png) no-repeat center center;}
#nav_zcb .navlist_zcb li#n_3 span{ background:url(./weTall/static/weixin/images/dingcan/bg4.png) no-repeat center center;}


</style>
<div id="nav_zcb">
	<ul class="navlist_zcb">
    	<li id="n_0">
    		<a href="weTall/index.php?g=home&m=book&a=allcate&token={$this->token}" ><span ></span></a>
        </li>
        <li class="r active" id="n_1">
            <a href="index.php?g=Wap&m=Index&a=index&token={$this->token}"><span></span></a>
        </li>
        <li class="r" id="n_2"><a href="weTall/index.php?g=home&m=user&a=index&token={$this->token}"><span></span></a></li>
        <li class="r" id="n_3"><a href="weTall/index.php?g=home&m=shopcart&a=index&token={$this->token}"><span></span></a><i></i></li>
    </ul>
    <script type="text/javascript">
    	$(".navlist > li#n_0").click(function(){
			$(this).toggleClass("active");
		});
		$(".navlist > li.r a").each(function() {
            href="index.php-app=member&act=login&ret_url=-index.php-app=member.htm"+$(this).attr("href");
			whref=window.location.href;
			if(whref.indexOf(href)!='-1'){
				$(this).parent("li").addClass("active");
			}
        });
    </script>
</div>


EOT;
	}
	
	
//xxl start	
	public function addGuide(){		

		$where['token']=$this->_get('token');
		$where['upd_type']="1";
		$music=M('Guide')->where($where)->select();
		$this->assign('music',$music);
		$imgJs = __ROOT__."/tpl/static/jquery.min.js";		
		
		$isMusic = False;
		$isAnimation = False;
		
	    if($music != null)
	    {
	    	$musicPath = __ROOT__.$music[0]['guide'];
	    	$imgPath = __ROOT__."/tpl/static/images/v72_2.png";
	    	$isMusic = TRUE;
	    }
	    
	    $animation=M('Animation')->where($where)->find();
	    $open_animation = 0;
	    if($animation != null){
	    	if ($animation['open_animation'] == "1" ){
	    		$open_animation = 1;
	    	}
	    }
	    
	    $animationPath =__ROOT__."/tpl/Wap/default/animation.html";
		
//xxl start
echo <<< EOT
<script src="{$imgJs}"  type="text/javascript" ></script>
		
<style type="text/css">
#iframe_screen{
    background:#fff;
    position:absolute;
    width:100%;
    height:100%;
    left:0;
    top:0;
    z-index:30000;
    overflow:hidden;
}
.music_blk{
	z-index: 99999;
	position:absolute;
}
		
a.btn_music{
	display:inline-block;
	width:25px;
	height:25px;
	margin:5px 10px;
	min-width:25px;
	background:url("{$imgPath}") no-repeat right center;
	background-size:auto 100%;
}
a.btn_music.on{
	background-position:0 center!important;
}
</style>
		
<script>
$().ready(function(){
		
   $("#playoff").hide();
   $("#playon").hide();
   $("#audio").attr("src","null");
   if("{$open_animation}" == 1){
		run(); //加载页面时启动定时器
		var interval;
		function run() {
			interval = setInterval(chat, "3000");
		}
		function chat() {
			clearTimeout(interval);  //关闭定时器
			$("#iframe_screen").hide();
			$("#playon").show();
			$("#audio").attr("src","{$musicPath}");
	    }
    }else{
			$("#iframe_screen").hide();
			$("#playon").show();
			$("#audio").attr("src","{$musicPath}");
	}
});
function musicClick(param)
{
	if(param == "off"){
		$("#playoff").hide();
		$("#playon").show();
		$("#autoMusic").show();
		$("#audio").attr("src","{$musicPath}");
		
	}else{
		$("#playoff").show();
		$("#playon").hide();
		$("#autoMusic").hide();
		$("#audio").attr("src","null");
	}
}
</script>
		
<iframe id="iframe_screen" src="{$animationPath}" frameborder="0"></iframe>
		
<div id="bkmusic" class="music_blk">
	<a href="javascript:;" id="playoff" class="btn_music" onclick="musicClick('off');"></a>
	<a href="javascript:;" id="playon" class="btn_music on" onclick="musicClick('on');"></a>
	<div id="autoMusic">
		<audio src="{$musicPath}"  loop="" id="audio" autoplay="autoplay" ></audio>
	</div>
</div>
EOT;
		
	}	
//xxl end
	
	public function lists(){
		$where['token']=$this->_get('token','trim');
		$db=D('Img');	
		if($_GET['p']==false){
			$page=1;
		}else{
			$page=$_GET['p'];			
		}		
		$where['classid']=$this->_get('classid','intval');
		$count=$db->where($where)->count();	
		$pageSize=8;	
		$pagecount=ceil($count/$pageSize);
		if($page > $count){$page=$pagecount;}
		if($page >=1){$p=($page-1)*$pageSize;}
		if($p==false){$p=0;}
		$res=$db->where($where)->order('createtime DESC')->limit("{$p},".$pageSize)->select();
		$res=$this->convertLinks($res);
		$this->assign('page',$pagecount);
		$this->assign('p',$page);
		$this->assign('info',$this->info);
		$this->assign('tpl',$this->tpl);
		$this->assign('res',$res);
		$this->assign('copyright',$this->copyright);
		if ($count==1){
			$this->content($res[0]['id']);
			exit();
		}
		$this->display($this->tpl['tpllistname']);
	}
	
	public function content($contentid=0){
		$db=M('Img');
		$where['token']=$this->_get('token','trim');
		if (!$contentid){
			$contentid=intval($_GET['id']);
		}
		$where['id']=array('neq',$contentid);
		$lists=$db->where($where)->limit(5)->order('uptatetime')->select();
		$where['id']=$contentid;
		$res=$db->where($where)->find();
		$this->assign('info',$this->info);	//分类信息
		$this->assign('lists',$lists);		//列表信息
		$this->assign('res',$res);			//内容详情;
		$this->assign('tpl',$this->tpl);				//微信帐号信息
		$this->assign('copyright',$this->copyright);	//版权是否显示
		$this->display($this->tpl['tplcontentname']);
	}
	
	public function flash(){
		$where['token']=$this->_get('token','trim');
		$flash=M('Flash')->where($where)->select();
		$count=count($flash);
		$this->assign('flash',$flash);
		$this->assign('info',$this->info);
		$this->assign('num',$count);
		$this->display('ty_index');
	}
	/**
	 * 获取链接
	 *
	 * @param unknown_type $url
	 * @return unknown
	 */
	public function getLink($url){
		$urlArr=explode(' ',$url);
		$urlInfoCount=count($urlArr);
		if ($urlInfoCount>1){
			$itemid=intval($urlArr[1]);
		}
		//会员卡 刮刮卡 团购 商城 大转盘 优惠券 订餐 商家订单 表单
		if (strExists($url,'刮刮卡')){
			$link='/index.php?g=Wap&m=Guajiang&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
			if ($itemid){
				$link.='&id='.$itemid;
			}
		}elseif (strExists($url,'大转盘')){
			$link='/index.php?g=Wap&m=Lottery&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
			if ($itemid){
				$link.='&id='.$itemid;
			}
		}elseif (strExists($url,'砸金蛋')){
			$link='/index.php?g=Wap&m=Zadan&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
			if ($itemid){
				$link.='&id='.$itemid;
			}
		}elseif (strExists($url,'优惠券')){
			$link='/index.php?g=Wap&m=Coupon&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
			if ($itemid){
				$link.='&id='.$itemid;
			}
		}elseif (strExists($url,'刮刮卡')){
			$link='/index.php?g=Wap&m=Guajiang&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
			if ($itemid){
				$link.='&id='.$itemid;
			}
		}elseif (strExists($url,'商家订单')){
			if ($itemid){
				$link=$link='/index.php?g=Wap&m=Host&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id.'&hid='.$itemid;
			}else {
				$link='/index.php?g=Wap&m=Host&a=Detail&token='.$this->token.'&wecha_id='.$this->wecha_id;
			}
		}elseif (strExists($url,'万能表单')){
			if ($itemid){
				$link=$link='/index.php?g=Wap&m=Selfform&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id.'&id='.$itemid;
			}
		}elseif (strExists($url,'相册')){
			$link='/index.php?g=Wap&m=Photo&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
			if ($itemid){
				$link='/index.php?g=Wap&m=Photo&a=plist&token='.$this->token.'&wecha_id='.$this->wecha_id.'&id='.$itemid;
			}
		}elseif (strExists($url,'全景')){
			$link='/index.php?g=Wap&m=Panorama&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
			if ($itemid){
				$link='/index.php?g=Wap&m=Panorama&a=item&token='.$this->token.'&wecha_id='.$this->wecha_id.'&id='.$itemid;
			}
		}elseif (strExists($url,'会员卡')){
			$link='/index.php?g=Wap&m=Card&a=vip&token='.$this->token.'&wecha_id='.$this->wecha_id;
		}elseif (strExists($url,'商城')){
			$link='/index.php?g=Wap&m=Product&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
		}elseif (strExists($url,'订餐')){
			$link='/index.php?g=Wap&m=Product&a=dining&dining=1&token='.$this->token.'&wecha_id='.$this->wecha_id;
		}elseif (strExists($url,'团购')){
			$link='/index.php?g=Wap&m=Groupon&a=grouponIndex&token='.$this->token.'&wecha_id='.$this->wecha_id;
		}elseif (strExists($url,'留言')){
			$link='/index.php?g=Wap&m=Liuyan&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
		}elseif (strExists($url,'首页')){
			$link='/index.php?g=Wap&m=Index&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
		}else {
			if (strpos($url,'?')){
				$link=str_replace('{wechat_id}',$this->wecha_id,$url).'&wecha_id='.$this->wecha_id;
			}else {
				$link=str_replace('{wechat_id}',$this->wecha_id,$url).'?wecha_id='.$this->wecha_id;
			}
			
		}
		return $link;
	}
	public function convertLinks($arr){
		$i=0;
		foreach ($arr as $a){
			if ($a['url']){
				$arr[$i]['url']=$this->getLink($a['url']);
			}
			$i++;
		}
		return $arr;
	}
	public function _getPlugMenu(){
		$company_db=M('company');
		$this->company=$company_db->where(array('token'=>$this->token,'isbranch'=>0))->find();
		$plugmenu_db=M('site_plugmenu');
		$plugmenus=$plugmenu_db->where(array('token'=>$this->token,'display'=>1))->order('taxis ASC')->limit('0,4')->select();
		if ($plugmenus){
			$i=0;
			foreach ($plugmenus as $pm){
				switch ($pm['name']){
					case 'tel':
						if (!$pm['url']){
							$pm['url']='tel:'.$this->company['tel'];
						}else {
							$pm['url']='tel:'.$pm['url'];
						}
						break;
					case 'memberinfo':
						if (!$pm['url']){
							$pm['url']='/index.php?g=Wap&m=Userinfo&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
						}
						break;
					case 'nav':
						if (!$pm['url']){
							$pm['url']='/index.php?g=Wap&m=Company&a=map&token='.$this->token.'&wecha_id='.$this->wecha_id;
						}
						break;
					case 'message':
						break;
					case 'share':
						break;
					case 'home':
						if (!$pm['url']){
							$pm['url']='/index.php?g=Wap&m=Index&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
						}
						break;
					case 'album':
						if (!$pm['url']){
							$pm['url']='/index.php?g=Wap&m=Photo&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
						}
						break;
					case 'email':
						$pm['url']='email:'.$pm['url'];
						break;
					case 'shopping':
						if (!$pm['url']){
							$pm['url']='/index.php?g=Wap&m=Product&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id;
						}
						break;
					case 'membercard':
						$card=M('member_card_create')->where(array('token'=>$this->token,'wecha_id'=>$this->wecha_id))->find();
						if (!$pm['url']){
							if($card==false){
								$pm['url']=rtrim(C('site_url'),'/').U('Wap/Card/get_card',array('token'=>$this->token,'wecha_id'=>$this->wecha_id));
							}else{
								$pm['url']=rtrim(C('site_url'),'/').U('Wap/Card/vip',array('token'=>$this->token,'wecha_id'=>$this->wecha_id));
							}
						}
						break;
					case 'activity':
						$pm['url']=$this->getLink($pm['url']);
						break;
					case 'weibo':
						break;
					case 'tencentweibo':
						break;
					case 'qqzone':
						break;
					case 'wechat':
						$pm['url']='weixin://addfriend/'.$this->weixinUser['wxid'];
						break;
					case 'music':
						break;
					case 'video':
						break;
					case 'recommend':
						$pm['url']=$this->getLink($pm['url']);
						break;
					case 'other':
						$pm['url']=$this->getLink($pm['url']);
						break;
				}
				$plugmenus[$i]=$pm;
				$i++;
			}
			
		}else {//默认的
			$plugmenus=array();
			/*
			$plugmenus=array(
			array('name'=>'home','url'=>'/index.php?g=Wap&m=Index&a=index&token='.$this->token.'&wecha_id='.$this->wecha_id),
			array('name'=>'nav','url'=>'/index.php?g=Wap&m=Company&a=map&token='.$this->token.'&wecha_id='.$this->wecha_id),
			array('name'=>'tel','url'=>'tel:'.$this->company['tel']),
			array('name'=>'share','url'=>''),
			);
			*/
		}
		return $plugmenus;
	}
}
