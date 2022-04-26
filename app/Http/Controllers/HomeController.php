<?php

namespace App\Http\Controllers;

use App\Models\Asistencia_diaria;
use App\Models\Asistencia_mensual;
use App\Models\Data_file;
use Illuminate\Http\Request;
use App\Models\Empleado;

use function PHPUnit\Framework\isNull;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $request->post();
        $month = date('m');
        $month = intval($month);
        $year = date('Y');
        $year = intval($year);
        
        if (isset($_GET["agregar"]) && $_GET["agregar"] == '1') {
            $nombre = strval($_GET["nombre"]);
            $c = Empleado::where('nombre',$nombre)->first();
            if ($c == NULL || !$c->nombre == $nombre){
                $puesto = strval($_GET["puesto"]);
                $departamento = strval($_GET["departamento"]);
                $sueldo = floatval($_GET["sueldo"]);

                $d = Empleado::insert([
                    'nombre' => $nombre,
                    'puesto' => $puesto,
                    'departamento' => $departamento,
                    'sueldo' => $sueldo
                ]);

                $i = Empleado::where('nombre',$nombre)->first();

                $e = Asistencia_mensual::insert([
                    'clave' => $i->clave,
                    'mes' => $month,
                    'anno' => $year,
                    'retardos' => 0,
                    'faltas' => 0
                ]);
            }
        }

        if (isset($_GET["busqueda"])) {
            $busqueda = strval($_GET["busqueda"]);
            $empleados = Empleado::select('empleados.clave AS clave','empleados.nombre', 'asistencia.retardos', 'asistencia.faltas')
            ->join('asistencias_mensual as asistencia','empleados.clave', '=', 'asistencia.clave')
            ->where('mes',$month)
            ->where('anno',$year)
            ->where('empleados.nombre','LIKE',"%$busqueda%")
            ->orderBy('nombre')
            ->get();
        }else{
            $empleados = Empleado::select('empleados.clave AS clave','empleados.nombre', 'asistencia.retardos', 'asistencia.faltas')
            ->join('asistencias_mensual as asistencia','empleados.clave', '=', 'asistencia.clave')
            ->where('mes',$month)
            ->where('anno',$year)
            ->orderBy('nombre')
            ->get();
        }
        $month = strval($month);
        return view('index', compact('empleados','month'));
    }

    public function calendario(){
        return view('calendario');
    }

    public function add_data(){
        return view('add_data');
    }

    public function import_data_file(Request $request)
    {
        $files = $request->file('csv');
        //dd($files);
        if (($gestor = fopen($files->path(), "r")) !== FALSE)
		{
            /* $data=array(); */
            /*
            ------FORMATO-------
           
            */
            $x = 0;
	   		while (($datos = fgetcsv($gestor, 0, ",")) !== FALSE)
	   		{
                if($x > 0){
                    $datos =  $datos; //added

                    $temp = new Data_file();
                    $temp->id = (int)$datos[0];
                    $temp->name = $datos[3];
                    $temp->date = date("Y-m-d",strtotime($datos[5])); //date
                    $temp->onDuty = $datos[7]; //time
                    $temp->offDuty = $datos[8]; //time
                    $temp->clockIn = $datos[9]; //time
                    $temp->clockOut = $datos[10]; //time
                    $temp->late = $datos[13]; //time
                    $temp->early = $datos[14]; //time

                    if(strtolower($datos[15]) == "true")
                        $temp->absent =boolval(1); //boolean
                    else
                        $temp->absent = boolval(0); //boolean

                    $temp->workTime = $datos[17]; //time

                    if(strtolower($datos[19]) == "true")
                        $temp->must_c_in =boolval(1); //boolean
                    else
                        $temp->must_c_in = boolval(0); //boolean
                        
                    if(strtolower($datos[20]) == "true")
                        $temp->must_c_out =boolval(1); //boolean
                    else
                        $temp->must_c_out = boolval(0); //boolean
                    
                    //dd($temp);
                    $temp->save();
                }
                $x++;

               /*  $datatemp=array(
                    'user_id'=>$temp->id,
                    'nombre'=>$datos[0],
                    'claveLarga'=>$datos[2],
                    'claveUnica'=>$datos[1],
                    'tipo'=>$temp->tipo,
                    'brigada'=> $datos[4],
                    'materia'=>$datos[6],
                    'claveMateria'=>(int)$datos[0],
                    'evaluacion'=>false,
                    'calificacionFinal'=>NULL,
                    'imagen'=>"",
                    'idPeriodo'=>NULL,);

                array_push($data,$datatemp); */

                if($datos[0]==""){break;}
            }
             //Alumnos::insert($data);
            return redirect('index');
        }
    }
}
