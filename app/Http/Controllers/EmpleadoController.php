<?php

namespace App\Http\Controllers;

use App\Models\Asistencia_diaria;
use App\Models\Asistencia_mensual;
use App\Models\Empleado;
use App\Models\Hora_clase;
use App\Models\Horario;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class EmpleadoController extends Controller
{
    public function ver_empleado($clave){
        if(isset($_GET["borrarHora"]) && $_GET["borrarHora"] == "on"){ //eliminar el horario del empleado
            $d = intval($_GET["dia"]);
            $h = intval($_GET["hora"]);
            $e = intval($_GET["clave"]);
            Horario::where('dia',$d)->where('hora',$h)->where("clave",$e)->delete();
        }
        elseif(isset($_GET["clase"]) && isset($_GET["salon"])){ 
            
            $d = intval($_GET["dia"]);
            $h = intval($_GET["hora"]);
            $e = intval($_GET["clave"]);
            $s = strval($_GET["salon"]);
            $c = strval($_GET["clase"]);
            //dd($d,$h,$e,$c,$s);
            $x = Horario::where('clave',$e)->where('dia',$d)->where('hora',$h)->first();
            //dd($h);
            if ($x == NULL || !$x->clave == $e) { //si no encuentra el horario mandado por el formulario, crea uno nuevo para el empleado
                $n = Horario::insert([
                    'clave' => $e,
                    'dia' => $d,
                    'hora' => $h,
                    'salon' => $s,
                    'clase' => $c
                ]);
            }else{ //si lo encuentra, acutaliza el horario del empleado
                $n = Horario::where('dia',$d)->where('hora',$h)->where("clave",$e)->update([
                    'dia' => $d,
                    'hora' => $h,
                    'salon' => $s,
                    'clase' => $c
                ]);
            }
        }
        elseif(isset($_GET["eliminar"])){
            $e = intval($_GET["eliminar"]);
            Asistencia_mensual::where('clave',$e)->delete();
            Asistencia_diaria::where('clave',$e)->delete();
            Horario::where('clave',$e)->delete();
            Empleado::where('clave',$e)->delete();

            $month = date('m');
            $month = intval($month);
            $empleados = Empleado::select('empleados.clave AS clave','empleados.nombre', 'asistencia.retardos', 'asistencia.faltas')
            ->join('asistencias_mensual as asistencia','empleados.clave', '=', 'asistencia.clave')
            ->where('mes',$month)
            ->orderBy('nombre')
            ->get();
            $month = strval($month);
            return view('index', compact('empleados','month')); 
        }
        elseif(isset($_GET["editar"])){
            $nombre = strval($_GET["nombre"]);
            $puesto = strval($_GET["puesto"]);
            $departamento = strval($_GET["departamento"]);
            $sueldo = floatval($_GET["sueldo"]);
            Empleado::where('clave',$clave)->update([
                'nombre' => $nombre,
                'puesto' => $puesto, 
                'departamento' => $departamento,
                'sueldo' =>$sueldo
            ]);
        }
        $clave = intval($clave);
        $empleado = Empleado::where('clave',$clave)->first();
        $asistencia_m = Asistencia_mensual::where('clave',$clave)->get();
        $asistencia_d = Asistencia_diaria::where('clave',$clave)->get(); 
        $horasclase = Horario::where('clave',$clave)->orderby('hora')->orderby('dia')->get();
        $horario = Hora_clase::orderBy('id')->get();

        return view('empleado',compact('empleado','asistencia_m','asistencia_d','horario','horasclase'));
    }
}
