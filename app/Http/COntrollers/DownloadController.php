<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EjercicioCreateRequest;
use Auth;
use Session;
use Redirect;
use View;
class DownloadController extends Controller {

	protected function descargaDocumentos($src){
		if(is_file($src))
		{
			$finfo=finfo_open(FILEINFO_MIME_TYPE);
			$content_type=finfo_file($finfo,$src);
			finfo_close($finfo);
			$file_name=basename($src).PHP_EOL;
			$size=filesize($src);
			header("Content-Type: $content_type");
			header("Content-Disposition: attachment; filename= $file_name");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: $size");
			readfile($src);
			return true;
		}else{
			return false;
		}

	}
	public function downloadWord(){
		if(!$this->descargaDocumentos(app_path()."/documentos/Instrucciones a Operadores de ejercicios diarios - CE3SER 03-07-16.docx")){
			return redirect()->back();
		}
	}
	public function downloadExcel(){
		if(!$this->descargaDocumentos(app_path()."/documentos/CE3SER_PLANILLA_CARGA_MANUAL.xlsm")){
			return redirect()->back();
		}
	}

} 