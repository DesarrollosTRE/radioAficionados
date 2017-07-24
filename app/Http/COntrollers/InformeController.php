<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Ejercicio;
use Response;
class InformeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $datos=array();
      $datos['user']=Auth::user();
      return view('informes.menu')->with($datos);
    }
    private function anteponerCero($numero){
      if($numero<9){
        return '0'.$numero;
      }
      return $numero;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     private function saberUsuario($dia,$mes,$ano){
       $usuarioAnterior="";
       $usuariosNuevos="";
       $datos=Ejercicio::saberUsuario($dia,$mes,$ano);
       foreach ($datos as $usuarios) {
         if($usuarios->name !== $usuarioAnterior && $usuarioAnterior!==""){
           $usuariosNuevos.=" ".$usuarios->name;
         }
         $usuarioAnterior=$usuarios->name;
       }
       $usuariosNuevos.=" ".$datos[0]->name;
       return trim($usuariosNuevos);
     }
     private function saberBanda($dia,$mes,$ano){
       $resul="";
       $bandaVHF=Ejercicio::saberBanda($dia,$mes,$ano,"VHF");
       $bandaUHF=Ejercicio::saberBanda($dia,$mes,$ano,"UHF");
       if(count($bandaVHF) > 0) $resul = "VHF";
       if(count($bandaUHF) > 0) $resul .= " UHF";
       return $resul;

     }
    public function store(Request $request)
    {
        if($request->ajax()){
          $json=array();
          $json_array=array();
          $datos=Ejercicio::ejercicios($request->dia,$request->mes,$request->ano);
          foreach ($datos as $lista) {
            $json['banda']=$lista->banda;
            $json['indicativo']=$lista->operador->indicativo;
            $json['fecha']=$this->anteponerCero($lista->dia)."-".$this->anteponerCero($lista->mes).'-'.$lista->ano;
            $json['hora']=$lista->hora;
            $json['operador']=$lista->operador->nombre;
            $json['observacion']=$lista->observacion;
            $json['usuario']=$lista->user->name;
            $json['comuna']=$lista->comuna->nombre;
            $json_array[]=$json;
          }
          //dd($json_array);
          return Response::json($json_array);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listaGeneral(Request $request)
    {
      //lista cuando seleccionar el mes.
        if($request->ajax()){
          $json=array();
          $json_array=array();
          $datos=Ejercicio::informe($request->mes,$request->ano);
          if($datos!==null){
            foreach ($datos as $lista) {
              $json['banda']=$this->saberBanda($lista->dia,$lista->mes,$lista->ano);
              $json['fecha']=$this->anteponerCero($lista->dia)."-".$this->anteponerCero($lista->mes).'-'.$lista->ano;
              $json['usuario']=$this->saberUsuario($lista->dia,$lista->mes,$lista->ano);
              $json['mes']=$lista->mes;
              $json['dia']=$lista->dia;
              $json['ano']=$lista->ano;
              $json['registros']=$lista->total;
              $json_array[]=$json;
            }
            return Response::json($json_array);
          }
          return false;
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
