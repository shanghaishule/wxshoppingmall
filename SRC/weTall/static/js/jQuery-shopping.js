
;(function($){
	$.extend($.fn,{
		shoping:function(options){
			var self=this,
				$goods-img=$('.goods-img');
				//$title=$('.J-shoping-title'),
				//$body=$('.J-shoping-body'),
				//$num=$('.J-shoping-num'),
				$close=$('.J-shoping-close');
			var S={
				init:function(){
					$(self).data('click',true).live('click',this.addShoping);
					$(document).bind('click',S.slideBoxMini);
					$body.bind('click',this.clickOnBody);
				},
				clickOnBody:function(e){
					if(!$(e.target).hasClass('J-shoping-close')){
						e.stopPropagation(); //阻止冒泡	
					};
				},
				addShoping:function(e){
					e.stopPropagation();
					var $target=$(e.target),
						id=$target.attr('id'),
						dis=$target.data('click'),
					    x = $target.offset().left + 30,
						y = $target.offset().top + 10,
						X = $shop.offset().left+$shop.width()/2-$target.width()/2+10,
						Y = $shop.offset().top;
					if(dis){
						if ($('#floatOrder').length <= 0) {
							$('body').append('<div id="floatOrder"><img src="'+$goods-img+'" width="50" height="50" /></div');
						};
						var $obj=$('#floatOrder');
						if(!$obj.is(':animated')){
							$obj.css({'left': x,'top': y}).animate({'left': X,'top': Y-80},500,function() {
								$obj.stop(false, false).animate({'top': Y-20,'opacity':0},500,function(){
									$obj.fadeOut(300,function(){
										$obj.remove();	
										//	num=Number($num.text());
										//$num.text(num+1);
									});
								});
							});	
						};
					};
				},
			};
			S.init(); 
		}
	});	
})(jQuery);

