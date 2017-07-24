@extends('Layouts.template')

@section('content')
<!-- #MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @if(Session::has('message'))
            <div class="alert {{Session::get('class')}} fade in">
              <button class="close" data-dismiss="alert">
                ×
              </button>
              <h3>{{Session::get('message')}}</h3>
            </div> 
            {{Session::forget('message')}}
            @endif
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1>Planilla Offline</h1>
        <div class="well">
<!--Upload excel drop and drog-->
          <form method="post" name="form-upload-csv" action="cargar-excel" enctype="multipart/form-data" class="smart-form form-upload">
            <section class="col col-4 input-dropzone">
                <label class="input"> 
                    <input type="text" name="indicativo" class="autocompleteOperador" placeholder="Indicativo">
                    <input type="hidden" name="operador">
                </label>
            </section>
            <section class="col col-4 input-dropzone">
                <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                     <input readonly="" type="text" name="fecha" id="datepicker" placeholder="Fecha">
                     <input type="hidden" id="fechaFormateda" name="fechaFormateda">
                </label>
            </section>
            <section class="col col-4 input-dropzone">
                <label class="label">Seleccione Banda</label>
                <label class="toggle">
                  <input type="radio" name="banda" data-text="VHF">
                  <i data-swchon-text="ON" data-swchoff-text="OFF"></i>VHF</label>
                <label class="toggle">
                <input type="radio" data-text="UHF" name="banda">
                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>UHF</label>
                <input type="hidden" name="bandaSeleccionada">
            </section>
              <input type="hidden" name ="_token" value="{!!csrf_token()!!}" />
              <div class="nombreDocumento"></div>
              <div class="zona-drop-interna">
              <input class="inputefile"  type="file" name="planillaExcel" id="file_input" />
                <label class="file-label">
                  <figure>
                    <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                  </figure>
                  <span class="iborrainputfile">Seleccionar archivo</span>
                </label>
                <div class="text-center" id="error-input"></div>
              </div>
              <div class="boxes box__uploading">          
                <div class="progress progress-lg">
                    <div class="progress-bar bg-color-blueLight" id="barraProgresoPlanilla" role="progressbar"></div>
                </div>
              </div>
              <div class="boxes box__success"></div>
              <div class="boxes box__error"></div>
              <div class="text-center">Archivo Soportado <b>xlsm</b></div>
          </form>
        </div>
        </div>
    </div>
</div>
<!-- END #MAIN CONTENT -->
@endsection
