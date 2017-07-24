@section('contenidoRecarga')
<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
       <th>
          INDICATIVO
       </th>
       <th>
         NOMBRE
       </th>
       <th>
         MODO
       </th>
       <th>
        COMUNA
       </th>
       <th>
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
@endsection
