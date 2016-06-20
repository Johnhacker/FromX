<?php
defined('IN_ADMIN') or exit('No permission resources.'); //模板
$soblock='000-003-007';
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>
<div id="mainpage">

	<?php
	include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'navier.tpl.php';
	?>
	<div class="cs_container"><!-- container -->
		<div class="cs_navbar col-sm-12">
			<h4 class="pull-left v1"><span class="label label-primary"><?php echo $actioname ?></span></h4>
			<div class="pull-left v2">
				<?php if($action=='public_bzhong'||$action=='public_zzbi'){ ?>
				<span class="cs_navbar_span-sele">选择 -&gt;</span>
				<?php if(isset($depart)){ ?>
				<div class="btn-group cs_navbar_btn-group">
					<button type="button" class="btn btn-info btn-sm"><?php echo $depart ?></button>
					<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<?php 
						if(is_array($depart_list)){
							foreach($depart_list as $k=>$info){
							?>
							<li<?php if($depart==$info['explains']){ echo ' class="disabled"'; } ?>><a href="./?m=admin&c=repo&a=<?php echo $action ?>&depart=<?php echo $info['explains'] ?>"><?php echo $info['explains'] ?></a></li>
							<?php
							}
						}
						?>
					</ul>
				</div><!--btn-group-->
				<?php } ?>
				<?php } ?>

				<?php if(isset($stdate)&&isset($endate)){ ?>
				日期范围[<span class="red"><?php echo $stdate ?>至<?php echo $endate ?></span>]
				<?php } ?>

				<a href="<?php echo get_url() ?>&echo=export" target="_blank" class="navbar-link"><i class="fa fa-download"></i> 导出excel</a>
			</div>
			<div class="pull-right v3">
				<?php if(!isset($sedate)){ $cs_vis='visibility: hidden;'; } ?>
				<form class="navbar-form navbar-left" role="search" noajax="noajax" style="width: 540px;<?php echo $cs_vis ?>" method="post" action="./?m=admin&c=quer&fromer=<?php echo ROUTE_C ?>&ctrl=<?php echo $ctrl ?>">
					<div class="col-sm-6"></div>
					<div class="col-sm-6">
						<input type="hidden" name="p[stdate]" value="<?php echo $stdate ?>" />
						<input type="hidden" name="p[endate]" value="<?php echo $endate ?>" />
						<button class="btn btn-default sc_fithd_btn mdatepicker dropens-left" type="button" bind="p[stdate]|p[endate]|date-title" autoact="autopost"><span class="date-title" id="date-title"><?php echo $sedate ?></span> <i class="fa fa-caret-down"></i></button>
					</div>
				</form>
				
			</div><!-- pull-right -->
		</div><!-- cs_navbar -->
		<div class="col-sm-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
					if(isset($comingsoon)){
						echo $comingsoon;
					}else{
					?>
					<form name="myform" id="myform" method="post" action="">
					<div class="table-responsive">
					<table class="table table-bordered table-condensed table-striped cs_table-st1 tablesorter">
						<thead>
							<tr>
								<?php 
								if(is_array($arr_thead)){
									foreach($arr_thead as $info){
									?>
									<th><?php echo $info ?></th>
									<?php
									}
								}
								?>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(is_array($infos)){
								foreach($infos as $info){
								?>
								
								<?php 
								if($info[0]=='合计') echo '<tfoot>';
								?>
								
								<tr>
									<?php 
									if($info[0]=='合计'){
										$boldst='<b>{$1}</b>';
									}else{
										$boldst='{$1}';
									}
									if(is_array($info)){
										foreach($info as $arr){
										?>
										<td><?php echo str_replace('{$1}', $arr, $boldst) ?></td>
										<?php
										}
									}
									?>
								</tr>
								
								<?php 
								if($info[0]=='合计') echo '</tfoot>';
								?>
								
								<?php
								}
							}
							?>
						</tbody>
					</table>
					</div><!--table-responsive-->
					</form>
					<?php
					}
					?>
				</div>
			</div>
		</div><!-- col-sm-12 -->
		<footer class="col-sm-12">
			<p>&copy; Bootstrap Company 2013</p>
		</footer>
	</div>
	<!-- /.container -->
</div>
<?php
$JSCSS='<script type="text/javascript" src="'.JS_PATH.'jquery.tablesorter.js"></script>';
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'footer.tpl.php';
?>