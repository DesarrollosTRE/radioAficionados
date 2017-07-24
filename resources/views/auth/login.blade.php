@extends('app')

@section('title', trans('authentication::session.create'))

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Ingreso .:Intranet:.</div>
  				<div class="panel-body">
                  @include('authentication::forms.session.create')
          </div>
    		</div>
    	</div>
    </div>
 </div>
@endsection
