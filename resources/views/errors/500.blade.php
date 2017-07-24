<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title> Error 500 </title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- #CSS Links -->
		<!-- Basic Styles -->
	  {!!Html::style('css/all.css')!!}
	</head>
	<body class="">

		<!-- #HEADER -->
		<header id="header">
			<div id="logo-group">

				<!-- PLACE YOUR LOGO HERE -->
				<a href='{{url('/')}}'><span id="logo"> RADIOAFISIONADOS </span></a>
				<!-- END LOGO PLACEHOLDER -->
			</div>
		</header>
    <main role="main">
      <!-- MAIN CONTENT -->
			<div id="content">

				<!-- row -->
				<div class="row">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<div class="row">
							<div class="col-sm-12">
								<div class="text-center error-box">
									<h1 class="error-text tada animated"><i class="fa fa-times-circle text-danger error-icon-shadow"></i> Error 500</h1>
									<h2 class="font-xl"><strong>Oooops, Ha Ocurrido un Error</strong></h2>
									<div class="alert alert-danger">{{Crypt::decrypt($e)}}</div>
									<br />
									<p class="lead semi-bold">
										<strong>El sistema ha experimentado un error interno.</strong><br><br>
										<small>
											Realize una de estas opciones
										</small>
									</p>
									<ul class="error-search text-left font-md">
							            <li><a href="{{url('home')}}"><small>Ir a la Pag&iacute;na Principal <i class="fa fa-arrow-right"></i></small></a></li>
							            <li><a href="{{url('enviar-email-admin/'.$e)}}"><small>Contactar con Administrador <i class="fa fa-mail-forward"></i></small></a></li>
							            <li><a href="javascript:void(0);" onclick="javascript:history.back(1);"><small>Volver Atr&aacute;s</small></a></li>
							        </ul>
								</div>

							</div>

						</div>

					</div>

				</div>
				<!-- end row -->

			</div>
			<!-- END MAIN CONTENT -->
      </main>
      <!-- #PAGE FOOTER -->
      <div class="page-footer">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <span class="txt-color-white">Intranet <span class="hidden-xs"> - Radio Afisionados</span> -- Tomás Rosales © 2016</span>
          </div>
        </div>
        <!-- end row -->
      </div>
  	{!!Html::script('js/bootstrap/bootstrap.min.js')!!}
  </body>
</html>
 