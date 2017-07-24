<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EjercicioCreateRequest;
//use Excel;
use PHPExcel;
use PHPExcel_IOFactory;
use Validator;
use DB;
use \App\Ejercicio;
use \App\Operador;
use \App\Comuna;
use Auth;
use Session;
use Redirect;
use View;
use Input;
class EjercicioController extends Controller {

	private $collectOperadores=null;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct(){
		//ini_set('max_execution_time', 180); //3 minutes
		//
		$this->crearCollectionOperador();
	}
	public function crearCollectionOperador(){
		//use
		$collectOperadores=null;
		$this->collectOperadores = collect(Operador::RetornarOperadores());
	}
	public function index()
	{
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	}
	public function buscarOperadorSegunIndicativo(){
		$results = array();
		$indicativo = strtoupper(Input::get('term'));
		$filtered = $this->collectOperadores->filter(function($item) use ($indicativo){

		if (strpos($item['value'], $indicativo) !== false) return $item['value'];

		})->values()->take(10);
		return response()->json($filtered->all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	 public function finalizarEjercicio(){
		 $datos['user']=Auth::user();
		 Ejercicio::where('dia','=',date('d'))->where('mes','=',date('m'))->where('ano','=',date('Y'))->where('estado','=','P')->update(['estado'=>'T']);
		 Session::flash('message','Ha finalizado correctamente el ejercicio.');
		 Session::flash('class', 'alert-success');
		 return view('Home.home')->with($datos);
	 }

	 public function vhf(){
		 $datos= array();
		 $user = Auth::user();
		 $datos['fecha']=date('Y-m-d');
		 $datos['user']=$user;
		 Session::flash('message','Ha ingresado con banda VHF');
		 Session::flash('class', 'alert-info');
		 Session::flash('banda', 'VHF');
		 $ListaEjerciciosPendientes=Ejercicio::recargaVistaIngreso(date('d'),date('m'),date('Y'),'VHF',$user->id,'P');
		 $datos['lista']=$ListaEjerciciosPendientes;
		 return view('Ejercicio.ingreso')->with($datos);
	 }
	 public function uhf(){
		 $datos= array();
		 $user = Auth::user();
		 $datos['fecha']=date('Y-m-d');
		 $datos['user']=$user;
		 Session::flash('message','Ha ingresado con banda UHF');
		 Session::flash('class', 'alert-info');
		 Session::flash('banda', 'UHF');
		 $ListaEjerciciosPendientes=Ejercicio::recargaVistaIngreso(date('d'),date('m'),date('Y'),'UHF',$user->id,'P');
		 $datos['lista']=$ListaEjerciciosPendientes;
		 return view('Ejercicio.ingreso')->with($datos);
	 }
	public function store(Request $res)
	{
				$observacionConcatnada="";
				if(isset($res["tipoObservacion"])){
					if(count($res["tipoObservacion"])>=1){

						foreach ($res["tipoObservacion"] as  $value) {
							$observacionConcatnada.=$value."//";
						}
					}

				}
				//
				if(isset($res["mercalli"])){
					if($res["mercalli"]!=="0"){
						$observacionConcatnada.="MERCALLI ".$res["mercalli"];
					}
				}
				//
				if(isset($res["numeroAfectados"])){
					if($res["numeroAfectados"]!==""){
						$observacionConcatnada.="//".$res["numeroAfectados"]." AFECTADOS";
					}
				}
				//
				if(isset($res["entidad"])){
					if(count($res["entidad"])>=1){

						foreach ($res["entidad"] as  $value) {
							$observacionConcatnada.="//".$value;
						}
					}
				}
				//
				if(isset($res["descripcion"])){
					if($res["descripcion"]!==""){
						$observacionConcatnada.="//".$res["descripcion"];
					}
				}
				$idComuna=($res['comuna']==="")?"347":$res['comuna'];
				$horaInicio = date("H:i:s",time());
				$user = Auth::user();
				$indicativoArreglado = strtoupper(trim($res["indicativoEjercicio"]));
			  if($res["operador"]=="")
					{
						 app('App\Http\Controllers\OperadorController')->agregarOperador(strtoupper(trim($res["datosOperador"])),$indicativoArreglado);
						 $this->collectOperadores->push(["value"=>$indicativoArreglado,"nombre"=>strtoupper(trim($res["datosOperador"]))]);
					}
					$horaInicio = date("H:i:s",time());
					$ejercicio[]=[
									'banda' => $res["banda"],
									'observacion' => $observacionConcatnada,
									'dia' => date('d'),
									'mes' => date('m'),
									'ano' => date('Y'),
									'hora' => $horaInicio,
									'modo' => $res['modo'],
									'estado' => 'P',
									'fk_ejercicioUsuarioSis' => $res["user"],
									'fk_ejercicioComuna' => $idComuna,
									'fk_ejercicioOperador' => $indicativoArreglado
										];
							DB::table('ejercicios')->insert($ejercicio);
									//render
				 $lista=Ejercicio::recargaVistaIngreso(date('d'),date('m'),date('Y'),$res['banda'],$user->id,'T');
			     $view = View::make('Ejercicio.listadoEjercicio')->with('lista',$lista);
				 $sections = $view->renderSections();
				 return response()->json($sections['contenidoRecarga']);

	}
	public function vistaPlanilla(){
		 $datos['user']=Auth::user();
		 return view('Ejercicio\Planilla.carga')->with($datos);
	}
	private function sanearComuna($nombreComuna){
		$minuscula = UCWORDS(strtolower($nombreComuna));
		return utf8_encode($minuscula);
	}
	public function cargarPlanilla(Request $res){
		$user = Auth::user();
		if(empty($res["planillaExcel"])){
			return response()->json(['st'=>2,'msg'=>'Error debe seleccionar un archivo CSV','class'=>'alert-danger']);
		}
		$arrayfecha = explode("-",$res["fechaFormateda"]);
		$arrayEjercicios= null;
		$objPHPExcel = PHPExcel_IOFactory::load($res["planillaExcel"]);
		$objPHPExcel->setActiveSheetIndex(0);
		$i=4;
		while ($objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue() != '') {
			$observacion = trim($objPHPExcel->getActiveSheet()->getCell("D" . $i)->getValue());
			$modo = trim($objPHPExcel->getActiveSheet()->getCell("C" . $i)->getValue());
			$nombrePila = trim($objPHPExcel->getActiveSheet()->getCell("H" . $i)->getOldCalculatedValue());
			$nombreComuna = $this->sanearComuna($objPHPExcel->getActiveSheet()->getCell("M" . $i)->getOldCalculatedValue());
			$indicativo = trim($objPHPExcel->getActiveSheet()->getCell("F" . $i)->getOldCalculatedValue());
		   	$id=Comuna::saberComuna($nombreComuna);
		   	if(empty($indicativo)){
					return response()->json(['st'=>1,'msg'=>'No se ha ingresado información. Falta indicativo en la fila F'. $i,'class'=>'alert-danger']);
			}
		   	if(empty($id[0])){
		   	    	$id="347";
		   	    }else{
		   	    	$id=$id[0]->idComuna;

		    }
				$arrayEjercicios[]=['banda'=>$res["bandaSeleccionada"],'observacion'=>$observacion,'dia'=>$arrayfecha[2],'mes'=>$arrayfecha[1],'ano'=>$arrayfecha[0],'hora'=>date("H:i:s",time()),'modo'=>$modo,'estado'=>'T','fk_ejercicioUsuarioSis'=>$user->id,'fk_ejercicioComuna'=>$id,'fk_ejercicioOperador'=>$indicativo];
			$i++;
		}
		Ejercicio::insert($arrayEjercicios);
		return response()->json(['st'=>1,'msg'=>'Se ha ingresado correctamente','class'=>'alert-success']);

}
public function modificarEjercicio(Request $res){
		if ($res->ajax())
			{
			//verificar que no cambien el name del form
			if(!($res["columna"]==="indicativo" || $res["columna"]==="modo" || $res["columna"]==="nombreComuna" || $res["columna"]==="observacion" || $res["columna"]==="hora")){
				return response()->json(['st'=>3,'msg'=>null,]);
			}
			$idEjercicio = $res["id"];
		    $columna= $res["columna"];
			$valor=$res["valor"];
			if($res["columna"]==="nombreComuna"){
				$columna="fk_ejercicioComuna";
			}
			  if($columna==="indicativo"){
			  	//en este caso debo tomar el idOperador que no es null
			  	$idOperador=$res["idOperador"];
			  	$respuesta=Ejercicio::ModificarOperadorEjercicio($idOperador,$idEjercicio);
			  	return response()->json(['st'=>1,'msg'=>null,]);
			  }
			  $resultado=Ejercicio::ModificarColumnaEjercicio($idEjercicio,$valor,$columna);
			  return response()->json(['st'=>1,'msg'=>null,]);
			}

}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
