@extends('Layouts.template')

@section('content')

<div id="content">
	<!-- row -->
	<div class="row">
		<!-- col -->
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
			<h1 class="page-title txt-color-blueDark">

				<!-- PAGE HEADER -->
				<i class="fa-fw fa fa-home"></i>
					Ejercicio
				<span>>
					Ingreso
				</span>
			</h1>
		</div>
	</div>
	@if(Session::has('message'))
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			 <div class="alert {{Session::get('class')}} fade in">
								<button class="close" data-dismiss="alert">
									×
								</button>
							<h3><i class="fa-fw fa fa-info"></i>{{Session::get('message')}}.</h3>
				</div>
		</div>
	</div>
	{{Session::forget('message')}}
	@endif
  <section id="widget-grid" class="">
    <!-- row -->
    <div class="row">
      <!-- NEW WIDGET START -->
      <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-deletebutton="false" data-widget-editbutton="false">
          <header>
            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
          </header>

          <!-- widget div-->
          <div>
            <!-- widget content -->
            <div class="widget-body">
              <div class="table-responsive">

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Nombre Comuna</th>
                      <th>Modo</th>
                    </tr>
                  </thead>
                  <tbody>
                      @for ($i = 1; $i < 10; $i++)
                        <tr>
                            <td>
                            {!!Form::text('nombreComuna'.$i,null,['data-number'=>$i,'id'=>'nombrComuna'.$i,'class'=>'prefijoComuna autocompleteVariasComunas form-control'])!!}
                            {!!Form::hidden('codigoComuna'.$i,null,['id'=>'codigoComuna'.$i])!!}
                          </td>
                          <td>
                            <a href="javascript:void(0);" data-number="{{$i}}" class="apunte btn btn-primary"><i class="fa fa-hand-o-right" aria-hidden="true"></i></a>
                            {!!Form::radio('modo'.$i,'P',null,['id'=>'modo'.$i.'P'])!!} Portatil
                            {!!Form::radio('modo'.$i,'M',null,['id'=>'modo'.$i.'M'])!!} Movil
                            {!!Form::radio('modo'.$i,'B',true,['id'=>'modo'.$i.'B','class'=>'radioBase'])!!} Base
                          </td>
                        </tr>
                      @endfor
                  </tbody>
                </table>
              </div>
            </div>
            <!-- end widget content -->

          </div>
          <!-- end widget div -->

        </div>
        <!-- end widget -->
      </article>

      <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-deletebutton="false" data-widget-editbutton="false">
          <header>
            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
          </header>

          <!-- widget div-->
          <div>
            <!-- widget content -->
            <div class="widget-body no-padding">
              <div class="table-responsive">
                {!!Form::open(['route'=>'ejercicio.store','method'=>'POST','name'=>'formEjercicio'])!!}
                <table class="table table-bordered table-striped">
                  <tbody>
                    <tr>
                      <!-- messages-->
                      <td colspan="3">
                        <div id="messages"></div>
                      </td>
                    </tr>
                    <tr>
                      <td>{!!Form::label('Indicativo ')!!}</td>
                      <td colspan="2">
                        <div id="labelIndicativo" class="">
                            {!!Form::text('indicativoEjercicio',null,['maxlength'=>'7','id'=>'location','class'=>'form-control autocompleteOperador','placeholder'=>'Indicativo Persona'])!!}
                            {!!Form::hidden('comuna',null)!!}
                            {!!Form::hidden('banda',Session::get('banda'))!!}
                            <div id="spanNuevoIngresoIndicativo"></div>
                            <div class="indicativoEjercicio error"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        {!!Form::label('Datos Operador')!!}
                      </td>
                      <td colspan="2">
                          {!!Form::textarea('datosOperador',null,['maxlength'=>'90','size'=>'10x2','id'=>'datosOperador','class'=>'form-control','placeholder'=>'Datos Operador'])!!}
                          {!!Form::hidden('operador',null)!!}
                          <div class="datosOperador error"></div>
                      </td>
                    </tr>
                    <tr>
                      <td>{!!Form::label('Comuna: ')!!}</td>
                      <td colspan="2">{!!Form::text('comunaEjercicio',null,['maxlength'=>'60','class'=>'autocompleteComuna form-control'])!!}
                          {!!Form::hidden('user',$user->id)!!}
                          <div class="comunaEjercicio error"></div>
                      </td>
                    </tr>
                    <tr>
                      <td>{!!Form::label('Modo: ')!!}</td>
                      <td colspan="2">
                      <table>
                        <tr>
                          <td>
                            {!!Form::radio('modo','P',null,['id'=>'modoEnviarP'])!!} Portatil
                          </td>
                          <td>
                            {!!Form::radio('modo','M',null,['id'=>'modoEnviarM'])!!} Movil
                          </td>
                          <td>
                            {!!Form::radio('modo','B',true,['id'=>'modoEnviarB'])!!} Base
                          </td>
                        </tr>
                      </table>
                      </td>
                    </tr>
                    <tr>
                      <td>{!!Form::label('Observaciones: ')!!}</td>
                      <td>
                          <table class=" ">
                            <tr>
                              <td>
                              {!!Form::checkbox('tipoObservacion[]', 'INCENDIO', null)!!} INCENDIO
                              <div id="observacionEjercicio"></div>
                              </td>
                            </tr>
                            <tr>
                              <td>
                              {!!Form::checkbox('tipoObservacion[]', 'SIN ENERGIA',null)!!} SIN ENERGIA
                              </td>
                            </tr>
                            <tr>
                              <td>
                              {!!Form::checkbox('tipoObservacion[]', 'SIN AGUA',null)!!} SIN AGUA
                              </td>
                            </tr>
                            <tr>
                              <td>
                              {!!Form::checkbox('tipoObservacion[]', 'ACCIDENTE',null)!!} ACCIDENTE
                              </td>
                            </tr>
                            <tr>
                              <td>
                                {!!Form::label('PERCEPCIÓN MERCALLI: ')!!}
                                <select name="mercalli">
                                <option selected="" disabled="" value="0">0</option>
                                @for ($i = 3; $i <= 12; $i++)
                                   <option value="{!!$i!!}">{!!$i!!}</option>
                                @endfor
                                </select>
                              </td>
                            </tr>
                          </table>
                      </td>
                      <td>
                          <table class=" ">
                            <tr>
                              <td id="inputNumAfectados">
                              {!!Form::text('numeroAfectados', null,['maxlength'=>'7','class'=>'form-control'])!!}
                              </td>
                              <td>_{!!Form::label('AFECTADOS ')!!}
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2">
                              {!!Form::label('ENTIDAD EMERGENCIA EN LUGAR')!!}
                              <table>
                                <tr>
                                  <td>
                                  {!!Form::checkbox('entidad[]', 'CARAB',null)!!} CARAB
                                  </td >
                                  <td>
                                  {!!Form::checkbox('entidad[]', 'AMBUL',null)!!} AMBUL
                                  </td>
                                  <td>
                                  {!!Form::checkbox('entidad[]', 'BOMBE',null)!!} BOMBE
                                  </td>
                                  <td>
                                  {!!Form::checkbox('entidad[]', 'CONAF',null)!!} CONAF
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    {!!Form::checkbox('entidad[]', 'MUNIC',null)!!} MUNIC
                                  </td>
                                  <td>
                                    {!!Form::checkbox('entidad[]', 'ONEMI',null)!!} ONEMI
                                  </td>
                                  <td>
                                    {!!Form::checkbox('entidad[]', 'PDI',null)!!} PDI
                                  </td>
                                </tr>
                              </table>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                {!!Form::label('DESCRIPCION: ')!!}
                              </td>
                              <td>
                                {!!Form::textarea('descripcion', null, ['size' => '20x5'])!!}
                              </td>
                            </tr>
                          </table>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3" class="text-center">{!!Form::submit('Registrar',['class'=>'btn btn-primary'])!!}</td>
                    </tr>
                  </tbody>
                </table>
                {!!Form::close()!!}
              </div>
            </div>
            <!-- end widget content -->

          </div>
          <!-- end widget div -->

        </div>
        <!-- end widget -->
      </article>
      <!-- WIDGET END -->
    </div>
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-2" data-widget-deletebutton="false" data-widget-editbutton="false">
              <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
              </header>
              <!-- widget div-->
              <div>
                <!-- widget content -->
                <div class="widget-body">
                      <div>
                        <p>Registro de Ejercicio Fecha:<b><code>{{$fecha}}</code></b>, Operador:<b><code>{{$user->name}}</code></b><a href="javascript:void(0)" data-banda="{{Session::get('banda')}}" id="finalizarEjercicio" class='btn btn-success'>Terminar Ejercicio <i class="fa fa-plus" aria-hidden="true"></i></a></p>
                      </div>
                      <div id="principalPanel">
                        @yield('contenidoRecarga')
                        <div class="table-responsive">
                          <table id="tabla-ejercicio" class="table table-bordered">
                            <thead>
                               <th class="ancho-columnas-ejercicio-input">
                                  INDICATIVO
                               </th>
                               <th class="ancho-columnas-ejercicio-input">
                                 NOMBRE
                               </th>
                               <th class="ancho-columnas-ejercicio-input">
                                 MODO
                               </th>
                               <th class="ancho-columnas-ejercicio-input">
                                COMUNA
                               </th>
                               <th class="ancho-columnas-ejercicio-textarea">
                                OBSERVACIONES
                               </th>
                            </thead>
                            <tbody>
															@foreach($lista as $list)
																											<tr>
																													<td class="ancho-columnas-ejercicio-input">
																														<input id="{{$list->operador->nombre}}" oninput="autoCom(this)" class="modificar-input-ejercicio autocompleteModificarEjercicio ejercicio-input" type="text" data-valor="{{$list->operador->indicativo}}" value="{{$list->operador->indicativo}}" name="indicativo" data-id="{{$list->idEjercicio}}"/>
																														<input type="hidden" data-name="user"/>
																														<input type="hidden" data-name="banda"/>
																														<input type="hidden" id="datosOperadorModificado" data-name="datosOperador"/>
																													</td>
																													<td class="ancho-columnas-ejercicio-input">
																														<input class="ejercicio-input" id="inputOperadorModificado" readonly="" type="text" value="{{$list->operador->nombre}}" name="nombre" data-id="{{$list->idEjercicio}}"/>
																														<input type="hidden" data-name="operadorNuevo"/>
																													</td>
																													 @if($list->modo==='B')
																													<td class="ancho-columnas-ejercicio-input">
																														<input id="Base" class="ejercicio-input" type="text" data-valor="Base" value="Base" name="modo" data-id="{{$list->idEjercicio}}"/>
																													</td>
																													 @elseif($list->modo==='M')
																													<td class="ancho-columnas-ejercicio-input">
																														<input id="Movil" class="ejercicio-input" type="text" data-valor="Movil" value="Movil" name="modo" data-id="{{$list->idEjercicio}}"/>
																													</td>
																													 @else
																													<td class="ancho-columnas-ejercicio-input">
																														<input id="Portatil" class="ejercicio-input" type="text" data-valor="Portatil" value="Portatil" name="modo" data-id="{{$list->idEjercicio}}"/>
																													</td>
																													 @endif
																													<td class="ancho-columnas-ejercicio-input">
																														<input id="{{$list->comuna->nombre}}" class="ejercicio-input" type="text" data-valor="{{$list->comuna->nombre}}" value="{{$list->comuna->nombre}}" name="nombreComuna" data-id="{{$list->idEjercicio}}"/>
																													</td>
																													<td class="ancho-columnas-ejercicio-textarea">
																														<input id="{{$list->observacion}}" class="modificar-input-ejercicio inputObservacionModificar ejercicio-textarea" type="text" data-valor="{{$list->observacion}}" value="{{$list->observacion}}" name="observacion" data-id="{{$list->idEjercicio}}"/>
																													</td>
																											</tr>
															@endforeach
                            </tbody>
                          </table>
                      </div>
                  </div>
                </div>
                <!-- end widget content -->
              </div>
              <!-- end widget div -->

            </div>
            <!-- end widget -->
        </article>
    </div>
</div>
<!-- END #MAIN CONTENT -->
@endsection
