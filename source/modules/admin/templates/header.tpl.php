<?php defined('IN_ADMIN') or exit('No permission resources.'); //模板 ?>
<!DOCTYPE html>
<!-- PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"-->
<html xmlns="http://www.w3.org/1999/xhtml"<?php if(isset($addbg)) { ?> class="addbg"<?php } ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<title><?php echo admin::$sitename; ?></title>
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css" />
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH?>daterangepicker-bs3.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH?>master.css" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	<script type="text/javascript" src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
	<script type="text/javascript" src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
<?php if(strstr($soblock,'003')) { ?>
<script type="text/javascript">
window.focus();
var pc_hash = '<?php echo $_SESSION['pc_hash'];?>';
<?php if(!isset($show_pc_hash)) { ?>
window.onload = function(){
	/*var html_a = document.getElementsByTagName('a');
	var num = html_a.length;
	for(var i=0;i<num;i++) {
		var href = html_a[i].href;
		if(href && href.indexOf('javascript:') == -1) {
			if(href.indexOf('?') != -1) {
				html_a[i].href = href+'&pc_hash='+pc_hash;
			} else {
				html_a[i].href = href+'?pc_hash='+pc_hash;
			}
		}
	}

	var html_form = document.forms;
	var num = html_form.length;
	for(var i=0;i<num;i++) {
		var newNode = document.createElement("input");
		newNode.name = 'pc_hash';
		newNode.type = 'hidden';
		newNode.value = pc_hash;
		html_form[i].appendChild(newNode);
	}*/
}
<?php } ?>


$(document).ready(function(){
	<?php if(isset($page)) { ?>
	$('body').keydown(function(evt){
		evt = evt||window.event;
		var keyc=evt.which||evt.keyCode;
		if(keyc==37) window.location.href='<?php echo $prevpage; ?>';
		if(keyc==39) window.location.href='<?php echo $nextpage; ?>';
	});
	<?php } ?>

	<?php if(strstr($soblock, '006')) { //Ajax回访记录 //##后面考虑用plugin js方法重构?>
	var ajaxrevisit=function(ele, cid, gid, revisit_e){
		var revisit_s=$(revisit_e).val();
		if(revisit_s==''){
			$.zoombox.show('ajax',{'statusCode':300,'message':'回访结果不能为空！'});
			return false;
		}
		$.post('./?m=admin&c=main&a=revisit&dosubmit=1', { rid: cid, uid: gid, cdata: revisit_s },
				function(data){
					if(data=='succeed'){
						if(gid==0){
							$(ele).val('已保存');
							$(ele).css('color','#999999');
							$(ele).attr('disabled','disabled');
							$(revisit_e).attr('readonly','readonly');
							$.zoombox.show('ajaxOK',{'statusCode':200,'message':'操作成功！'});
							setTimeout(function(){window.location.reload();}, 2000);
						}else{
							$.zoombox.show('ajaxOK',{'statusCode':200,'message':'操作成功！'});
						}
					}else if(data=='error1'){
						$.zoombox.show('ajax',{'statusCode':300,'message':'会话过期请重试！'});
						setTimeout(function(){window.location.reload();}, 2000);
					}else{
						$.zoombox.show('ajax',{'statusCode':300,'message':'未知错误！'});
					}
				},'text');
	};
	$('#ajax_saverevisit').click(function(){
		var ele=this;
		var cid_n=$('#recid').val();
		var gid_n=0;
		var revisit_e='#revisit';
		ajaxrevisit(ele, cid_n, gid_n, revisit_e);
	});
	$('#ajax_editrevisit').click(function(){
		var ele=this;
		var cid_n=$('#recid').val();
		var gid_n=$(this).attr('bd');
		var revisit_e='#revisit';
		ajaxrevisit(ele, cid_n, gid_n, revisit_e);
	});
	<?php } ?>
	
	<?php if(strstr($soblock,'007')) { //表格排序 ?>
	$('.tablesorter').tablesorter({sortList:[[2,1]] ,textExtraction:function(node){if(node.innerHTML.indexOf('%')!=-1){return node.innerHTML.replace('%','')}return node.innerHTML}});//0为升序1降序。
	<?php } ?>

	<?php if(strstr($soblock,'008')) { //信息反馈 ?>
	var msdialog = function(data){
		var tmp = null;
		try{
			tmp = $.parseJSON(data);
		}catch(e){

		}finally{
			if(tmp){
				data = tmp;
				$.zoombox.hide();
				if(parseInt(data.statusCode) == 200){
					$.zoombox.show('ajaxOK',data);
				}else if(parseInt(data.statusCode) == 300){
					$.zoombox.show('ajax',data);
				}else{
					$.zoombox.show('ajax',data);
				}
				//注意和plugin.js方法的区别
				setTimeout(function(){
					if(data.callbackType == 'forward'){
						if(data.forwardUrl && data.forwardUrl != '')
						{
							if(data.forwardUrl == 'reload')
							window.location.reload();
							else
							window.location.href = data.forwardUrl;
						}
					}
				},2000);
				
			}else{
				//if(data && data.substring(0,6) != 'error:')
			}
			return data.statusCode;
		}
	};
	msdialog('<?php echo $MESSDATA ?>');
	<?php } ?>
});


</script>
<?php } ?>

<?php if(strstr($soblock,'005')) { //排班表JS ?>
<script type="text/javascript">
var dealForm;
$(document).ready(function(){
	var mday=0;
	mday=new Date(<?php echo date('Y,m',SYS_TIME) ?>,0).getDate();
	$('#month_h').find('.sele_month').each(function(){
		$(this).click(function(){
			var m=$(this).attr('bd');
			var day = new Date(<?php echo date('Y',SYS_TIME) ?>,m,0);
			mday = day.getDate();
			var week_str=['日','一','二','三','四','五','六'];
			
			$('.sele_month').removeClass('cur_month');
			$(this).addClass('cur_month');
			$('#pbmonth').val(m);
			
			for(var i=28; i<=31; i++){
				$('#days_'+i).css('display','none');
				$('#weeks_'+i).css('display','none');
				$('.pbv_r_'+i).css('display','none');
			}
			for(var i=28; i<=mday; i++){
				$('#days_'+i).css('display','');
				$('#weeks_'+i).css('display','');
				$('.pbv_r_'+i).css('display','');
			}
			for(var i=1; i<=mday; i++){
				var week_str_html=week_str[new Date(<?php echo date('Y',SYS_TIME) ?>,m-1,i).getDay()];
				if(week_str_html=='日'){week_str_html='<strong style="color:red;">'+week_str_html+'</strong>';}
				$('#weeks_'+i).html(week_str_html);
			}
		});
	});
	
	var currRowObj;
	var currRowFn=function(elem){
		$('#mode01_data_main').find('.datarow').each(function(){
			$(this).removeClass('cellst2');
		});
		elem.addClass('cellst2');
		currRowObj=elem;
	};
	$('#mode01_data_main').find('.datarow').each(function(){
		$(this).click(function(){
			currRowFn($(this));
		});
	});
	$('#addrow').click(function(){
		var newRow=$('#mode01_data_main').find('tr:last').clone();
		newRow.find("input[bd='datais']").each(function(){$(this).val('');});
		newRow.find("button[name='delrow']").each(function(){
			$(this).click(function(){
				$(this).parents('tr:first').remove();
			});
		});
		newRow.click(function(){
			currRowFn($(this));
		});
		newRow.removeClass('cellst2');
		newRow.appendTo('#mode01_data_main');
		newRow=null;
	});
	
	$('#autorow').click(function(){
		if(currRowObj){
			currRowObj.find("input[bd='datais']").each(function(){
				if($(this).attr('name')!='pbname'){
					$(this).val($('#autoinp').val());
				}
			});
		}
	});
	
	dealForm=function(){
		var allData='';
		$('#mode01_data_main').find('.datarow').each(function(){
			var pbv='';
			var pbname=$(this).find("input[name='pbname']:first").val();
			if(pbname!=''){
				for(var i=1; i<=mday; i++){
					if(i==1){
						pbv=pbv+$(this).find("input[name='pbv"+i+"']:first").val();
					}else{
						pbv=pbv+','+$(this).find("input[name='pbv"+i+"']:first").val();
					}
				}
				allData=allData+'$'+pbname+'|'+pbv;
			}	
		});
		if(allData!=''){
			$('#pbdata').val(allData);
			return true;
		}else{
			alert('请录入排班资料！');
			return false;
		}
	}
});
</script>
<?php } ?>

</head>
<body>