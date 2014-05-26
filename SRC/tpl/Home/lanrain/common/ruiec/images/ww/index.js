 
//tab
var curPortflioi = "page21";
var nn;
var curNumi=1;
var jj=0;
function showPagei(idi,nn,i){
	for(var j=1;j<=nn;j++){
		if(j==idi) {
			$("#box"+i+j).removeClass ();	
			$("#box"+i+j).addClass ("tab1");
			$("#page"+i+j).fadeIn(400);
			if(i==2) {
				//var hhh = $("#page"+i+j).height();
				//$("#page"+i+j).height($("#"+curPortflioi).height());
				//$("#page"+i+j).animate({height: hhh},400,'', function(){ if(curPortflioi != $(this).attr("id"))$(this).hide(); } );
				curPortflioi = "page"+i+j;
			}
		} else {
			$("#box"+i+j).removeClass ();	
			$("#box"+i+j).addClass ("tab2");	
			//$("#page"+i+j).fadeOut("fast");
			$("#page"+i+j).hide();
		}
	}
	
}
//services
$(".serBox").hover(
  function () {
	 $(this).children().stop(false,true);
	 $(this).children(".serBoxOn").fadeIn("slow");
     $(this).children(".pic1").animate({right: -110},400);
     $(this).children(".pic2").animate({left: 41},400);
     $(this).children(".txt1").animate({left: -240},400);
     $(this).children(".txt2").animate({right: 0},400);	 
	 }, 
  function () {
	 $(this).children().stop(false,true);
	 $(this).children(".serBoxOn").fadeOut("slow");
	 $(this).children(".pic1").animate({right:41},400);
     $(this).children(".pic2").animate({left: -110},400);
     $(this).children(".txt1").animate({left: 0},400);
     $(this).children(".txt2").animate({right: -240},400);	
  }
);




