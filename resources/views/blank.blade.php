<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Phần Mềm Vận Tải Quốc Huy</title>
	<link rel="shortcut icon" type="../image/x-icon" href="{{asset('img/web/LogoQuocHuy.png')}}" />
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{ asset('libs/bootstrap/dist/css/bootstrap.min.css') }}">
	<!-- Font Awesome -->

	<link rel="stylesheet" href="{{ asset('libs/font-awesome/css/font-awesome.min.css') }}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{ asset('libs/Ionicons/css/ionicons.min.css') }}">
	<!-- Theme style -->
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{asset('libs/iCheck/all.css')}}">
	<!-- select2 -->
	<link rel="stylesheet" href="  {{ asset('libs/select2/dist/css/select2.min.css') }}">
	<!-- style LTE -->
	<link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="{{ asset('css/skins/_all-skins.css') }}">
		<!-- item List style -->
		<link rel="stylesheet" href="{{ asset('css/itemList.css') }}">
		<!-- Data table -->
		<link rel="stylesheet" href="{{ asset('libs/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"> {{--
		<!-- iCheck for checkboxes and radio inputs -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"> --}}
		<!-- DieuXe style -->
		<link rel="stylesheet" href="{{ asset('css/DieuXe.css') }}">
		<link rel="stylesheet" href="{{ asset('css/lenhtong.css') }}">
	<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
.required {
	color: red;
}
</style>
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script -->


			<!-- jQuery 3 -->
			<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
			<!-- Bootstrap 3.3.7 -->
			<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

			<!-- Select2 -->
			<script src="{{ asset('libs/select2/dist/js/select2.full.min.js') }}"></script>

			<!-- <script src="../../bower_components/fastclick/lib/fastclick.js"></script> -->
			<!-- AdminLTE App -->
			<script src="{{ asset('js/adminlte.js') }}"></script>
			<!-- AdminLTE for demo purposes -->
			<script src="{{ asset('js/demo.js') }}"></script>
			<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
			<!-- bootstrap datepicker -->
			<!-- {{ asset('libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }} -->
			<script src="{{ asset('libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
			<script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
			<script src="{{ asset('libs/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
			<!-- Sweet alert -->
			<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
			<!-- NotifyJS -->
			<script src="{{ asset('libs/notifyjs/notify.js') }}"></script>
			<!-- iCheck 1.0.1 -->
			<script src="{{ asset('libs/iCheck/icheck.min.js') }}"></script>

			<style>
			@media only screen and (min-width: 600px) {
				.rowPadding {
					padding-left: 40px;
				}
			}
		</style>
	</head>
	<?php
	if(!session()->has('email')){
		echo "Chưa đăng nhập";
		exit();

	}
	$currentUser = null;
	if(session()->has('email'))
	{
		$tmpemail = Session::get('email');
		$email = end($tmpemail);
		$users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $email)->get();
		$currentUser =$users[0];
		$user = $users[0]->user_id;
		$currentUser_name = $users[0]->full_name;

	}


	?>

	<body class="skin-blue sidebar-mini">
		<div class="wrapper">

			<header class="main-header">
				<!-- Logo -->
				<a href="#" class="logo" data-toggle="push-menu" role="button">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini">
						<b>QH</b></span>
						<!-- logo for regular state and mobile devices -->
						<span class="logo-lg">
							<b>QUỐC HUY</b></span>
						</a>
						<!-- Header Navbar: style can be found in header.less -->
						<nav class="navbar navbar-static-top">
							<!-- Sidebar toggle button-->
							<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</a>

							<div class="navbar-custom-menu">
								<ul class="nav navbar-nav">
									<!-- Messages: style can be found in dropdown.less-->

									<!-- User Account: style can be found in dropdown.less -->
									<li class="user user-menu">
										<a class="dropdown-toggle" data-toggle="dropdown">
											<img src="../../img/user.png" class="user-image" alt="User Image">
											<span class="hidden-xs">{{$currentUser_name}}</span>
										</a>
									</li>
									<!-- Control Sidebar Toggle Button -->
									<li>
										<a href="#" onclick="logout()">
											<i class="glyphicon glyphicon-log-out"></i>
											<span class="hidden-xs">Đăng xuất</span>
										</a>
									</li>

								</ul>
							</div>
						</nav>
					</header>
					<!-- Left side column. contains the logo and sidebar -->
					<!-- =================================== MENU - START================================================ -->

					<aside class="main-sidebar">
						<section class="sidebar">
							<?php

							function canAccess($arrMenu, $menu_id, $user_role){
								foreach ($arrMenu as $menu) {
									if($menu['menu_id'] == $menu_id){
										$strRoles = $menu['roles'];

										$arrRole =array_filter( explode("::",$strRoles));
										if (in_array($user_role, $arrRole)){
											return true;
										}
									}
								}
								return false;
							} 
							$arrMenu = App\Menu::select('menu_id', 'title', 'menu_parent_id', 'url', 'url2', 'url3', 'roles','css_class')->where('is_show', '=', '1')->orderBy('order_by')->get()->toArray();
							foreach ($arrMenu as $key => $menu) {
								$checkAccess = canAccess($arrMenu,$menu['menu_id'],$currentUser->user_type);
								if($checkAccess == false)
								{
									unset($arrMenu[$key]);
								}
							}
				// $tong = 0;

				// function subMenuBaoTri($item,$parent){
					// bn Nguyên mần cái này 
					// if($item['menu_parent_id'] == $parent){

					// 	// function show alert accessary

					// 	if($item['url'] == 'accessary'){
					// 		$alert = DB::select("SELECT COUNT(*) AS count FROM tbl_accessary WHERE amount <= remain_alert AND need_import = 0");

					// 		$count = $alert[0]->count;
							
					// 		$notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].'<span class="badge bg-red" style="float:right;">'.$count.'</span> </a>';
					// 		if($count==0){
					// 			$notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].'</a>';
					// 		}
					// 		if($count > 10) $count = "10+";
					// 		print($notify);
							
					// 	}

					// 	// note bảo dưỡng
					// 		if($item['url'] == 'maintenance'){
					// 			$baoduong_bd = DB::table('tbl_maintenance')
					// 			->select('tbl_maintenance.expiration_date')
					// 			->get();
					// 			$bd_all = 0; 
					// 			foreach($baoduong_bd  as $bd){
					// 					$date1=date_create(date('Y-m-d'));
					// 					$date2=date_create($bd->expiration_date);
					// 					$diff=date_diff($date1,$date2);
					// 					if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7) $bd_all++;
					// 			}
					// 			$notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].'<span class="badge bg-red" style="float:right;">'.$bd_all.'</span> </a>';
					// 			if($bd_all == 0) $notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].' </a>';
					// 			if($bd_all > 10) $bd_al = "10+";
					// 			print($notify);
					// 		}
					// 	// note bảo hiểm
					// 		if($item['url'] == 'insurance'){
					// 			$baoduong_bh = DB::table('tbl_insurance')
					// 			->select('tbl_insurance.expiration_date')
					// 			->get();
					// 			$bd_all = 0; 
					// 			foreach($baoduong_bh  as $bh){
					// 					$date1=date_create(date('Y-m-d'));
					// 					$date2=date_create($bh->expiration_date);
					// 					$diff=date_diff($date1,$date2);
					// 					if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7) $bd_all++;
					// 			}
					// 			$notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].'<span class="badge bg-red" style="float:right;">'.$bd_all.'</span> </a>';
					// 			if($bd_all == 0) $notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].' </a>';
					// 			if($bd_all > 10) $bd_al = "10+";
					// 			print($notify);
					// 		}
					// 	// note chungnhan
					// 		if($item['url'] == 'fire-certificate'){
					// 			$chungnhan = DB::table('tbl_fire_certificate')
					// 			->select('tbl_fire_certificate.expiration_date')
					// 			->get();
					// 			$bd_all = 0; 
					// 			foreach($chungnhan  as $cn){
					// 					$date1=date_create(date('Y-m-d'));
					// 					$date2=date_create($cn->expiration_date);
					// 					$diff=date_diff($date1,$date2);
					// 					if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7) $bd_all++;
					// 			}
					// 			$notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].'<span class="badge bg-red" style="float:right;">'.$bd_all.'</span> </a>';
					// 			if($bd_all == 0) $notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].' </a>';
					// 			if($bd_all > 10) $bd_al = "10+";
					// 			print($notify);
					// 		}
					// 	// kiểm định
					// 		if($item['url'] == 'verify'){
					// 			$kiemdinh = DB::table('tbl_verify')
					// 			->select('tbl_verify.expiration_date')
					// 			->get();
					// 			$bd_all = 0; 
					// 			foreach($kiemdinh  as $kd){
					// 					$date1=date_create(date('Y-m-d'));
					// 					$date2=date_create($kd->expiration_date);
					// 					$diff=date_diff($date1,$date2);
					// 					if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7) $bd_all++;
					// 			}
					// 			$notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].'<span class="badge bg-red" style="float:right;">'.$bd_all.'</span> </a>';
					// 			if($bd_all == 0) $notify = '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].' </a>';
					// 			if($bd_all > 10) $bd_al = "10+";
					// 			print($notify);
					// 		}
					// }

					// if($item['url'] != 'maintenance' && $item['url'] != 'insurance' && $item['url'] != 'fire-certificate' && $item['url'] != 'verify' && $item['url']!='accessary'){
					// 	print('<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].'</a>');
					// }
				// end Nguyên
				//}
				// // alert bảo trì  menu 
				// 		$baoduong_bd = DB::table('tbl_maintenance')
				// 			->select('tbl_maintenance.expiration_date')
				// 			->get();
				// 			$bd_all = 0; 
				// 			foreach($baoduong_bd  as $bd){
				// 					$date1=date_create(date('Y-m-d'));
				// 					$date2=date_create($bd->expiration_date);
				// 					$diff=date_diff($date1,$date2);
				// 					if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7) $bd_all++;
				// 			}
				// 			$tong += $bd_all;
				// 			$kiemdinh = DB::table('tbl_verify')
				// 					->select('tbl_verify.expiration_date')
				// 					->get();
				// 					$bd_all = 0; 
				// 					foreach($kiemdinh  as $kd){
				// 							$date1=date_create(date('Y-m-d'));
				// 							$date2=date_create($kd->expiration_date);
				// 							$diff=date_diff($date1,$date2);
				// 							if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7) $bd_all++;
				// 					}
				// 					$tong += $bd_all;
				// 			$chungnhan = DB::table('tbl_fire_certificate')
				// 					->select('tbl_fire_certificate.expiration_date')
				// 					->get();
				// 					$bd_all = 0; 
				// 					foreach($chungnhan  as $cn){
				// 							$date1=date_create(date('Y-m-d'));
				// 							$date2=date_create($cn->expiration_date);
				// 							$diff=date_diff($date1,$date2);
				// 							if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7) $bd_all++;
				// 					}
				// 					$tong += $bd_all;
				// 			$baoduong_bh = DB::table('tbl_insurance')
				// 					->select('tbl_insurance.expiration_date')
				// 					->get();
				// 					$bd_all = 0; 
				// 					foreach($baoduong_bh  as $bh){
				// 							$date1=date_create(date('Y-m-d'));
				// 							$date2=date_create($bh->expiration_date);
				// 							$diff=date_diff($date1,$date2);
				// 							if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7) $bd_all++;
				// 					}
				// 					$tong += $bd_all;
				// end alert 	

							function subMenu($data , $id){
								foreach($data as $item){
									if($item['menu_parent_id'] == $id)
									{
										$curentURL = $_SERVER['REQUEST_URI'];
										$childMenuURL = $item['url'];
										if (strpos($curentURL, $childMenuURL) !== false ) {
                // if( substr($curentURL,-strlen($childMenuURL))==$childMenuURL || strpos($curentURL, $childMenuURL."/") !== false)
                // &&  strcmp(substr($curentURL,-strlen($childMenuURL)+1), "/") == 0 
                // echo "$childMenuURL";
                // echo "lol cc ".substr($curentURL,-strlen($childMenuURL)-1);

										}
				// subMenuBaoTri($item,$item['menu_parent_id']);
										echo '<li><a href="../../'.$item['url'].'"><i class="fa fa-circle-o"></i> '.$item['title'].' </a>';
										subMenu($data ,$item['menu_id']);
										echo "</li>";
									}
								}
							}
							?>
							<ul class="sidebar-menu" data-widget="tree">
								<?php
								$url = $_SERVER['REQUEST_URI'];
								?>
								@foreach($arrMenu as $menu) @if($menu['menu_parent_id'] == 0)
								<li class="<?php // lấy url kiểm tra url trong dâtbase
								$urlMenu = $menu['url'];


								$flagHasChildMenu =false;
								foreach ($arrMenu as $key => $value){
									$urlSub = $value['url'];
          // $tmpLeght = 0 - strlen($urlSub);
          // $subURL = substr($url, $tmpLeght);
          // echo " cc ".$subURL;
          //if($value['menu_parent_id'] == $menu['menu_id'] && strcmp($subURL, $urlSub) == 0) 

									if($value['menu_parent_id'] == $menu['menu_id'])
										$flagHasChildMenu =true;
								}
								if($flagHasChildMenu ==true)
									echo "treeview ";
								?> ">
								<?php $flagCheck =false;  
								?>
								<a style=" text-decoration: none;" href="
								<?php foreach ($arrMenu as $key => $value)
								{ if($value['menu_parent_id'] == $menu['menu_id'])
								{ $flagCheck =true;
								}
							} if($flagCheck===true){echo '#';}else{echo $menu['url'];}?>">
							<i class="fa {{ $menu['css_class'] }}"></i> <span>{{$menu['title']}}</span>
							@foreach($arrMenu as $subMenu)
							@if($subMenu['menu_parent_id'] == $menu['menu_id'])
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
							@endif
							@endforeach
						</a>
						<ul class="treeview-menu">
							<?php 
							subMenu($arrMenu, $menu['menu_id']);
      // $kkk=  $menu['menu_id'];
      // $cc = $menu->subMenu($arrMenu, $kkk);
      // echo $cc;
							?>
						</ul>
					</li>
					@endif @endforeach
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>
		<!-- =================================== MENU - END ================================================ -->

		<!-- Content Wrapper. Contains page content -->
		<!-- // ======================================================================================================================= -->
		<div class="content-wrapper">
			@yield('content')
		</div>
		<!-- /.content-wrapper -->
		<!-- // ============================================================ -->
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 2.4.0
			</div>
			<strong>Copyright &copy; 2018
				<a href="http://tnk.com.vn">TNK</a>.</strong> All rights reserved.
			</footer>



		</body>

		</html>

		<script type="text/javascript">
			function logout(){
				swal({
					title: "Đăng xuất",
					text: "Bạn đang đăng xuất khỏi hệ thống",
					icon: "warning",
					buttons: {
						confirm: 'Có',
						cancel: 'Hủy'
					},
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						if (typeof(Storage) !== "undefined") {
							localStorage.removeItem('operatingPagi');
						}
						document.location.href="/logout";
					}
				});
			}
			$(function($) {
				var path = window.location.href;
				if(path.indexOf('?') > -1){
					path = path.substring(0,path.indexOf('?'));
				}
				if(path.indexOf('#') > -1){
					path = path.substring(0,path.indexOf('#'));
				}
				if(path.split("/").length - 1 == 4) {
					path = path.substring(0,path.lastIndexOf('/'));
				}else if(path.split("/").length - 1 == 5) {
					path_tmp = path.substring(0,path.lastIndexOf('/'))
					path = path_tmp.substring(0,path_tmp.lastIndexOf('/'));
				}
				$('.sidebar ul li a').each(function() {
					$(this).parents('.treeview').find('span.pull-right-container').remove(':not(span:first)')
					if (this.href === path) {
						$(this).parents('li').addClass('active');
					}
					if($(this).parents('li').children('.treeview-menu').text().trim() == '') {
						$(this).parents('li').children('.treeview-menu').remove();
					}
				});
			});
		</script>