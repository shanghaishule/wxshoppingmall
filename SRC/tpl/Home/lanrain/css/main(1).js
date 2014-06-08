$(document).ready(function(){
	var r=$(window);
	var A=document;
	var v=A.body;
	var c=window.Math;
	var n=$.browser.msie;
	var G=parseInt($.browser.version,10);
	var l=n&&G==6;
	var k=n&&G==7;
	var i=n&&G==8;
	var H=$.browser.mozilla&&G<19;
	var D="";
	
	if(l){D+=" ua-ie6"}else{D+=" ua-notIE6"}
	if(k){D+=" ua-ie7"}
	if(i){D+=" ua-ie8"}
	if(H){D+=" ua-ltff19"}
	
	var o=false;
	var a=Browser.os;
	var C=Browser.system;
	var h=(a=="windows"&&(C=="5.1"||C=="5.2"))||(a=="macintosh");
	if(h){D+=" ua-noYahei"}
	if(D){$("html").addClass(D)}
	
	$(v).mousewheel(function(U,X,S,R){
			U.preventDefault();
			if(o||R==0){return false}
			var V=0;
			var T=true;
			var W=R>0?true:false;
			var Q=R<0?true:false;
			if(l||k||i){W=(R>0||X>0)?true:false;Q=(R<0||X<0)?true:false}
			if(W){if(O===0){T=false}else{V=O-1}}else{if(Q){if(O==null){V=0}else{if(O>=N-1){T=false}else{V=O+1}}}}
			if(T){p(V);o=true}
	});
	
	var B="http://mimg.127.net/hd/all2/140115_ntesmail6/lib/";
	var L={};
	var M=false;
	var d=v.scrollHeight;
	var w;
	var x;
	
	function P(){
		var Q=r;var R=A.documentElement;w=typeof Q.innerWidth=="undefined"?R.clientWidth:Q.innerWidth();
		x=typeof Q.innerHeight=="undefined"?R.clientHeight:Q.innerHeight()
	}
	
	P();
	
	var K=$("#js-nav");
	if(l){F()}
	function F(){var Q=r.scrollTop();K.css({top:Q+x/2+"px"})}
	
	var z=$(".section");
	var N=z.length;
	z.each(function(Q,S){
		var V=$(S);
		var T=V.find(".imgList");
		L[Q]={};
		L[Q]["jqo"]=V;
		var U=V.offset().top;
		var R=V.height();
		var W=r.scrollTop();
		L[Q]["jqImg"]=T.find(".img");
		if(Q==0){
			if(!L[Q]["bgInit"]){
				J(
					B+"img/"+(l?"ie6/pic_1_1.jpg":"modern/pic_1_2.jpg"),
					function(Y){
						L[Q]["jqo"].fadeOut(0);
						var Z={"background-image":"url("+Y+")"};
						if(l){Z={"background-image":"url("+Y+")"};L[Q]["bgInit"]=true}
						L[Q]["jqo"].find(".inner").css(Z);
						var X=L[Q]["jqo"].find("#MailBig");
						var aa=L[Q]["jqo"].find("#MailSmall");
						L[Q]["jqo"].fadeIn(500);
						X.animate({top:"473"},800,"easeOutCubic");
						aa.animate({top:"369"},1200,"easeOutCubic",function(){L[Q]["bgInit"]=true;if(!l){$("#SKY-star").fadeIn();e();s()}})
					}
				)
			}
			if(!L[Q]["imgInit"]&&!l){
				L[Q]["imgInit"]=true;
				L[Q]["jqImg"].each(
					function(){
						var Y=$(this);
						var X=Y.attr("data-bg");
						J(B+"img/section"+(Q+1)+"/"+X,function(Z){Y.css("background-image","url("+Z+")");if(typeof fCall=="function"){e()}})
					}
				)
			}
		}else{
			if((R+U)>=W&&(W+x)>=U){I(Q)}else{r.bind("scroll",function(){var X=r.scrollTop();if((R+U)<X||(X+x)<U){return}I(Q)})}
		}
	});
	
	function I(Q,S){
		var R;
		if(!L[Q]["bgInit"]){
			L[Q]["bgInit"]=true;
			R="pic_"+(Q+1);
			if(Q==8){R+="_1"}
			J(B+"img/"+(l?"ie6":"modern")+"/"+R+".jpg",function(T){L[Q]["jqo"].find(".inner").css("background-image","url("+T+")")})
		}
		if(!L[Q]["imgInit"]&&!l){
			L[Q]["imgInit"]=true;
			L[Q]["jqImg"].each(
					function(){
						var U=$(this);
						var T=U.attr("data-bg");
						J(B+"img/section"+(Q+1)+"/"+T,function(V){U.css("background-image","url("+V+")");if(typeof S=="function"){S()}})
					}
			)
		}
	}
	
	function e(){
		if(!L[0]["imgInit"]||!L[0]["bgInit"]||l){return}
		var R=$("#SKY-logo");
		var T=$("#SKY-slogan2");
		var U=$("#SKY-subTitle").find("p");
		var S=2;
		T.css({width:554*S+"px",height:176*S+"px","margin-left":-554*(S-1)/2+"px","margin-top":-176*(S-1)/2+"px",opacity:"0"});
		R.hide();
		T.show();
		T.animate({width:"554px",height:"176px","margin-left":"0px","margin-top":"0px",opacity:"1"},"slow","easeOutBounce",function(){R.fadeIn("slow",function(){Q()})});

		function Q(){
			window.setTimeout(function(){
				U.eq(0).fadeIn("slow",function(){
					U.eq(1).fadeIn("slow",function(){
						U.eq(2).fadeIn("slow",function(){
							var X=location.hash.substr(1).split("&");
							for(var W=0,V=X.length;W<V;W++){
								var Y=X[W].split("=");
								if(Y[0]=="node"&&Y[1]!="index"&&!!(Y[1]-0)==true&&Y[1]>0&&Y[1]<z.length){
									p(Y[1]);M=true;break
								}
							}
						})
					})
				})
			},200)
		}
	}
	
	function J(R,S){
		var R=R||"";
		var S=typeof S=="function"?S:"";
		if(!R){return}
		var Q=document.createElement("img");
		Q.onload=function(){if(S){S(R)}};
		Q.src=R
	}
	
	var f=false;
	var b=0;
	r.bind("scroll",function(){if(!f){t()}});
	var E=K.find(".item");
	var O=0;
	E.on("mouseover",function(Q){var R=$(this);R.addClass("item-hover")});
	E.on("mouseout",function(Q){var R=$(this);R.removeClass("item-hover")});
	
	function t(){
		var R=r.scrollTop();
		var Q;
		if(R==(d-x)){Q=N-1}else{Q=parseInt(R/851)}
		if(l){F()}
		if(O&&Q==O){return}
		if(typeof O=="number"){E.eq(O).removeClass("item-active")}
		E.eq(Q).addClass("item-active");
		O=Q;
		if(!M){location.hash="#node="+O;M=false}
	}
	
	K.bind("click",function(S){var R=S.target;while(!R.className||(R.className!="navigation"&&R.className.indexOf("item")==-1)){R=R.parentNode}var Q=R.getAttribute("data-for");if(Q){f=true;p(Q)}});
	
	function p(Q){
		f=true;
		var R=parseInt(Q,10)*851;
		$.scrollTo(R,{duration:1400,easing:"easeInOutExpo",axis:"y",onAfter:function(){t();f=false;M=false;o=false}})
	}
	
	var j=false;
	function s(){
		if(j){return}
		j=true;
		z.each(Q);
		function Q(R,aa){
			var Y=$(aa);
			var Z=Y.offset().top;
			var ac=Y.height();
			var W=Y.find(".topic");
			var ad=Y.find(".desc");
			var ab=Y.find(".title");
			var U=Y.find(".pic");
			var X=Y.find(".pic1");
			var V=Y.find(".pic2");
			var T=Y.find(".pic3");
			var S=Y.find(".pic4");
			if(R==0){y(Y)}else{
				if(R==9){u(Y)}else{
					W.each(function(ae){
						var ag=$(this);
						var af={dom:ag,sectionHeight:ac,positionTop:parseInt(ag.css("top"),10),topBorderPos:Z,speed:0.5};
						q(af)
					});
					ab.each(function(ae){
						var ag=$(this);
						if(ag.attr("data-default")!="false"){
							var af={dom:ag,sectionHeight:ac,positionTop:parseInt(ag.css("top"),10),topBorderPos:Z,speed:0.5};
							q(af)
						}
					});
					if(ad.attr("data-default")!="false"){
						ad.each(function(ae){
							var ag=$(this);
							var af={dom:ag,sectionHeight:ac,positionTop:parseInt(ag.css("top"),10),topBorderPos:Z,speed:2};
							q(af)
						})
					}
					if(R==1){
						g({dom:X,sectionHeight:ac,topBorderPos:Z,positionTop:-95,speed:4});
						m({dom:X,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:40});
						g({dom:V,sectionHeight:ac,topBorderPos:Z,positionTop:839,trsans:true,speed:4});
						m({dom:V,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:40});
						q({dom:T,sectionHeight:ac,topBorderPos:Z,positionTop:412,speed:3});
						m({dom:T,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:20})
					}else{
						if(R==2){
							g({dom:T,sectionHeight:ac,topBorderPos:Z,positionTop:504,speed:4});
							m({dom:T,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:20});
							q({dom:S,sectionHeight:ac,topBorderPos:Z,positionTop:304,speed:0.4});
							m({dom:S,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:40});
							q({dom:X,sectionHeight:ac,topBorderPos:Z,positionTop:707,speed:6});
							m({dom:V,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:4});
							g({dom:ad,sectionHeight:ac,topBorderPos:Z,positionTop:30,trsans:true,speed:3});
							m({dom:ad,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:20})
						}else{
							if(R==3){
								m({dom:V,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:20});
								q({dom:X,sectionHeight:ac,topBorderPos:Z,positionTop:427,speed:2});
								q({dom:V,sectionHeight:ac,topBorderPos:Z,positionTop:300,speed:5});
								q({dom:T,sectionHeight:ac,topBorderPos:Z,positionTop:367,speed:1})
							}else{
								if(R==4){
									g({dom:X,sectionHeight:ac,topBorderPos:Z,positionTop:7,trsans:true,speed:1});
									g({dom:ad.eq(0),sectionHeight:ac,topBorderPos:Z,positionTop:-3,trsans:true,speed:1});
									g({dom:V,sectionHeight:ac,topBorderPos:Z,positionTop:281,trsans:true,speed:0.4});
									g({dom:ad.eq(1),sectionHeight:ac,topBorderPos:Z,positionTop:279,trsans:true,speed:0.4});
									g({dom:T,sectionHeight:ac,topBorderPos:Z,positionTop:562,speed:0.4});
									g({dom:ad.eq(2),sectionHeight:ac,topBorderPos:Z,positionTop:562,speed:0.4});
									g({dom:S,sectionHeight:ac,topBorderPos:Z,positionTop:843,speed:1});
									g({dom:ad.eq(3),sectionHeight:ac,topBorderPos:Z,positionTop:838,speed:1});
									m({dom:X,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
									m({dom:ad.eq(0),sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
									m({dom:V,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
									m({dom:ad.eq(1),sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
									m({dom:T,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
									m({dom:ad.eq(2),sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
									m({dom:S,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
									m({dom:ad.eq(3),sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10})
								}else{
									if(R==5){
										q({dom:V,sectionHeight:ac,topBorderPos:Z,trsans:true,positionTop:0,max:0,speed:3});
										g({dom:X,sectionHeight:ac,topBorderPos:Z,trsans:true,positionTop:-4,speed:3});
										m({dom:X,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:20});
										g({dom:ad,sectionHeight:ac,topBorderPos:Z,positionTop:606,speed:3});
										m({dom:ad,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:20})
									}else{
										if(R==6){
											q({dom:T,sectionHeight:ac,topBorderPos:Z,positionTop:462,speed:4});
											q({dom:S,sectionHeight:ac,topBorderPos:Z,positionTop:362,speed:4});
											m({dom:S,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:50})
										}else{
											if(R==7){
												g({dom:V,sectionHeight:ac,topBorderPos:Z,positionTop:239,speed:4});
												q({dom:V,sectionHeight:ac,topBorderPos:Z,positionTop:490,speed:4});
												g({dom:T,sectionHeight:ac,topBorderPos:Z,positionTop:88,speed:4});
												q({dom:T,sectionHeight:ac,topBorderPos:Z,positionTop:464,speed:4});
												g({dom:S,sectionHeight:ac,topBorderPos:Z,positionTop:5,speed:4});
												q({dom:S,sectionHeight:ac,topBorderPos:Z,positionTop:430,speed:4})
											}else{
												if(R==8){
													g({dom:X,sectionHeight:ac,topBorderPos:Z,positionTop:-53,trsans:true,speed:2});
													g({dom:ad.eq(0),sectionHeight:ac,topBorderPos:Z,positionTop:-4,trsans:true,speed:2});
													g({dom:T,sectionHeight:ac,topBorderPos:Z,positionTop:763,speed:2});
													g({dom:ad.eq(2),sectionHeight:ac,topBorderPos:Z,positionTop:833,speed:2});
													m({dom:X,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
													m({dom:ad.eq(0),sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
													m({dom:V,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
													m({dom:ad.eq(1),sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
													m({dom:T,sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10});
													m({dom:ad.eq(2),sectionHeight:ac,opacity:1,topBorderPos:Z,speed:10})
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	function y(T){
		var R=T;
		var S=R.offset().top;
		var W=R.height();
		var Y=R.find("#SKY-slogan2");
		var U=R.find("#SKY-logo");
		var V=R.find("#SKY-subTitle");
		var X=R.find("#MailSmall");
		var Q=R.find("#MailBig");
		q({dom:U,sectionHeight:W,positionTop:29,topBorderPos:S,speed:0.5});
		q({dom:Y,sectionHeight:W,positionTop:0,topBorderPos:S,speed:0.5});
		q({dom:V,sectionHeight:W,positionTop:416,topBorderPos:S,speed:0.5});
		q({dom:X,sectionHeight:W,positionTop:369,topBorderPos:S,speed:3});
		m({dom:X,sectionHeight:W,opacity:1,topBorderPos:S,speed:10});
		q({dom:Q,sectionHeight:W,positionTop:473,topBorderPos:S,speed:2});
		m({dom:Q,sectionHeight:W,opacity:1,topBorderPos:S,speed:10})
	}

function u(V){
	var W=V;
	var R=W.offset().top;
	var T=W.height();
	var Q=W.find(".title-1");
	var X=W.find(".title-2");
	var U=W.find(".btn");
	var S=W.find(".pic");
	q({dom:Q,sectionHeight:T,positionTop:parseInt(Q.css("top"),10),topBorderPos:R,speed:1});
	q({dom:X,sectionHeight:T,positionTop:parseInt(X.css("top"),10),topBorderPos:R,speed:2});
	q({dom:U,sectionHeight:T,positionTop:parseInt(U.css("top"),10),topBorderPos:R,speed:4});
	q({dom:S,sectionHeight:T,positionTop:parseInt(S.css("top"),10),topBorderPos:R,speed:0.1})
}

function q(V){
	var Q=V.speed||0.1;
	var U=V.dom;
	var W=V.sectionHeight;
	var R=V.topBorderPos;
	var T=typeof V.positionTop=="number"?V.positionTop:U.position().top;
	var S=V.fix||0;
	var X=null;
	if(typeof V.call=="function"){X=V.call}
	r.bind("scroll",function(){
		var aa=r.scrollTop();
		if((W+R)<aa||(aa+x)<R){return}
		if(X){X(aa)}
		var Y=(R-aa)*Q+S;
		if(V.trsans){Y=-Y}
		var Z=V.max;
		if(typeof Z=="number"){Y=(Y+T)>Z?-Y:Y}
		U.css("top",(T+Y)+"px")
	})
}

function g(V){
	var Q=V.speed||0.1;
	var U=V.dom;
	var W=V.sectionHeight;
	var R=V.topBorderPos;
	var T=typeof V.positionTop=="number"?V.positionTop:U.position().top;
	var S=V.fix||0;
	var X=null;
	if(typeof V.call=="function"){X=V.call}
	r.bind("scroll",function(){
		var Z=r.scrollTop();
		if((W+R)<Z||(Z+x)<R){return}
		if(X){X(Z)}
		var Y=(R-Z)*Q+S;
		if(V.trsans){Y=-Y}
		U.css("left",(T+Y)+"px")
	})
}

function m(V){
	if(k||i||l){return}
	var R=V.speed||1;
	var U=V.dom;
	var W=V.sectionHeight;
	var S=V.topBorderPos;
	var Q=V.opacity;
	var T=V.fix||0;
	var X=null;
	if(typeof V.call=="function"){X=V.call}
	r.bind("scroll",function(){
		var Z=r.scrollTop();
		if((W+S)<Z||(Z+x)<S){return}
		if(X){X(Z)}
		var Y=((S-Z)/W)*R;
		U.css("opacity",(Q+(Y>0?-Y:Y)))
	})
}

r.bind("resize",P)

});

(function(){
	if(!window.Browser){
		window.Browser={};
		if(!Browser._isInited){
			var l=f;var b=window.navigator.userAgent;var e="";var h="";var i="";var g="";var j="";var k="";
			if((/windows|win32/i).test(b)){
				e="windows";
				try{h=b.match(/Windows\sNT\s(\d+\.\d+)/)[1]}
				catch(c){}
			}else{
				if((/linux/i).test(b)){e="linux";try{h=b.match(/Linux\s([^;]+)/)[1]}catch(c){}}else{
					if((/macintosh/i).test(b)){e="macintosh";try{h=b.match(/Mac\sOS\sX\s(\d+\.\d+)/)[1]}catch(c){}}else{
						if((/rhino/i).test(b)){e="rhino"}else{if((/ipad/i).test(b)){e="ipad"}else{
							if((/iphone/i).test(b)){e="iphone"}else{if((/ipod/i).test(b)){e="ipod"}else{
								if((/android/i).test(b)){e="android"}else{if((/adobeair/i).test(b)){e="adobeair"}else{
									try{e=navigator.platform.toLowerCase()}catch(c){}}}}}}}}}
			}
			Browser.os=e;Browser.system=h;
			try{a()}catch(c){}
			try{d()}catch(c){}
			Browser.appName=l(i).toLowerCase();
			Browser.version=l(g).toLowerCase();
			Browser.shell=l(j).toLowerCase();
			Browser.screenWidth=window.screen.width;
			Browser.screenHeight=window.screen.height;
			try{m()}catch(c){}
			Browser.hasFlash=!!k;Browser.flashVersion=k;Browser._isInited=true
		}
	}
	
	function f(o,n){
		if(arguments.length===0){return""}
		if(String.prototype.trim&&!n){o=String.prototype.trim.call(o)}else{
			var p=n?(/(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g):(/(^(\s|　)+)|((\s|　)+$)/g);
			o=o.replace(p,"")
		}
		return o
	}
	
	function a(){
		var n;n=b.match(/MSIE ([^;]*)|Trident.*; rv(?:\s|:)?([0-9.]+)/);
		if(n&&(n[1]||n[2])){i="MSIE";g=n[1]||n[2];return}
		n=b.match(/Firefox\/([^\s]*)/);
		if(n&&n[1]){i="Firefox";g=n[1];return}
		n=b.match(/Chrome\/([^\s]*)/);
		if(n&&n[1]){i="Chrome";g=n[1];return}
		n=b.match(/Version\/([^\s]*).+Safari/);
		if(n&&n[1]){i="Safari";g=n[1];return}
		n=b.match(/Opera.+Version[\s\/]([^\s]*)/);
		if(n&&n[1]){i="Opera";g=n[1];n=b.match(/Opera Mini[^;]*/);if(n){i=n[0]}return}
		n=b.match(/AppleWebKit\/([^\s]*)/);
		if(n&&n[1]){i="AppleWebKit";g=n[1];return}
	}
	
	function d(){
		var n;n=b.match(/MetaSr/i);
		if(n){j="Sogou";return}
		n=b.match(/Maxthon/i);
		if(n){j="Maxthon";return}
		n=b.match(/TencentTraveler/i);
		if(n){j="TencentTraveler";return}
		n=b.match(/QQBrowser/i);
		if(n){j="QQBrowser";return}
		n=b.match(/TheWorld/i);
		if(n){j="TheWorld";return}
		n=b.match(/360[S|E]E/i);
		if(n){j="360";return}
	}
	
	function m(){
		var q;
		if(i==="MSIE"){
			q=new window.ActiveXObject("ShockwaveFlash.ShockwaveFlash");
			if(q){k=q.getVariable("$version").split(" ")[1]}
		}else{
			if(navigator.plugins&&navigator.plugins.length>0){
				q=navigator.plugins["Shockwave Flash"];
				if(q){var p=q.description.split(" ");
					for(var o=0,n=p.length;o<n;o++){if(Math.floor(p[o])>0){k=p[o];break}}
				}
			}
		}
	}
	
})();





