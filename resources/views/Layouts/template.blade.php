<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title> .:Intranet:. </title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="_token" content="{!! csrf_token() !!}"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- #CSS Links -->
		<!-- Basic Styles -->
    	{!!Html::style('css/all.css')!!}
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	</head>
	<body class="">

		<!-- #HEADER -->
		<header id="header">
			<div id="logo-group">
				<!-- PLACE YOUR LOGO HERE -->
				<span id="logo"> RADIOAFICIONADOS </span>
				<!-- END LOGO PLACEHOLDER -->
			</div>
			<div class="project-context hidden-xs">

				<span class="label">Usuarios</span>
				<span class="project-selector dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Menú Usuario <i class="fa fa-angle-down"></i></span>

				<!-- Suggestion: populate this list with fetch and push technique -->
				<ul class="dropdown-menu">
					<li>
						<a href="{{url('profile')}}">Ver Perfil</a>
					</li>
					<li>
						<a href="{{url('password')}}">Cambiar Contraseña</a>
					</li>
					@if($user->admin==1)
					<li>
						<a href="{{url('crear-usuario')}}">Crear Usuario</a>
					</li>
				  <li class="divider"></li>
					<li>
					<a href="{{url('admin/user')}}">Grupo De Usuarios</a>
				 </li>
					@endif
				</ul>
				<!-- end dropdown-menu-->

			</div>
			<div class="pull-right">

				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->
				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="{{url('logout')}}" title="Cerrar Sesi&oacute;n" data-action="userLogout" data-logout-msg="&iquest Desea Salir del sistema ?"><i class="fa fa-sign-out"></i></a> </span>
				</div>
				<!-- end logout button -->
				<!-- fullscreen button -->
				<div id="fullscreen" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
				</div>
				<!-- end fullscreen button -->
			</div>
			<!-- end pulled right: nav area -->

		</header>
		<aside id="left-panel">

			<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as is -->

					<a href="{{url('home')}}">
						<img src="{{url('img/avatars/sunny.png')}}" alt="me" class="online" />
						<span>
							{{ $user->name }}
						</span>
					</a>

				</span>
			</div>
			<nav>
				<ul>
					<li>
						<a href="{{'home'}}" title="Home"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Home</span><b class="collapse-sign"></b></a>
					</li>
					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i> <span class="menu-item-parent">Ejercicio</span><b class="collapse-sign"><em class="fa fa-plus-square-o"></em></b></a>
							<ul>
								<li>
									<a href="{{url('ingreso-vhf')}}">Inicio VHF</a>
								</li>
								<li>
									<a href="{{url('ingreso-uhf')}}">Inicio UHF</a>
								</li>
								<li>
									<a href="{{url('subir-planilla')}}">Subir Planilla</a>
								</li>
							</ul>
					</li>
					<li>
						<a href="{{url('informes')}}"><i class="fa fa-lg fa-fw fa fa-file-text-o"></i> <span class="menu-item-parent">Informes</span><b class="collapse-sign"></b></a>
					</li>
				</ul>
			</nav>

			<span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
		</aside>
		<!-- END NAVIGATION -->
    <main id="main" role="main">
			<!-- #MAIN CONTENT -->
			<div id="content">
	      @yield('content')
			</div>
		<!-- END #MAIN CONTENT -->
    </main>
		<!-- #PAGE FOOTER -->
		<div class="page-footer">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<span class="txt-color-white">Intranet <span class="hidden-xs"> - RADIOAFICIONADOS</span> -- Tomás Rosales (tomas.escalona24@gmail.com) © 2016</span>
				</div>
			</div>
			<!-- end row -->
		</div>
		<!-- END FOOTER -->
    {!!Html::script('js/libs/jquery-2.1.1.min.js')!!}
    {!!Html::script('js/libs/jquery-ui-1.10.3.min.js')!!}
    {!!Html::script('js/libs/jquery.validate.min.js')!!}

		<!-- IMPORTANT: APP CONFIG -->
    {!!Html::script('js/app.config.js')!!}
		<!-- BOOTSTRAP JS -->
	{!!Html::script('js/bootstrap/bootstrap.min.js')!!}
	 <!-- CUSTOM NOTIFICATION -->
	{!!Html::script('js/notification/SmartNotification.min.js')!!}
	 <!-- JARVIS WIDGETS -->
	 	{!!Html::script('js/smartwidgets/jarvis.widget.min.js')!!}

		{!!Html::script('js/app.min.js')!!}
		<script>
		var BASEURL = '{{ url() }}/';
		</script>
		{!!Html::script('js/radio.js')!!}
		@yield('datatables')
		<script type="text/javascript">
		$(document).ready(function() {
			$('.prefijoComuna').attr('maxlength','7');
			$.ajaxSetup({
				headers: { 'X-CSRF-TOKEN' : $('meta[name=_token]').attr('content') }
			});
		});
		</script>
	</body>

</html>
