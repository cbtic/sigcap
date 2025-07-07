<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Encuesta;
use App\Models\Expediente;
use App\Models\Evaluadore;
use App\Models\RespuestaEncuesta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EncuestaController extends Controller
{
    public function index()
    {
        $presidentes = Evaluadore::where('tipo', 'presidente')->get();
        $delegados = Evaluadore::where('tipo', 'delegado')->get();
        $especialistas = Evaluadore::where('tipo', 'especialista')->get();
        $adHocs = Evaluadore::where('tipo', 'ad_hoc')->get();

        return view('frontend.encuesta.all', compact('presidentes', 'delegados', 'especialistas', 'adHocs'));
        
    }
/*
    public function buscarExpediente(Request $request)
    {
        $expediente = Expediente::where('numero_expediente', $request->numero_expediente)->first();

        if ($expediente) {
            return response()->json([
                'success' => true,
                'municipalidad_tramite' => $expediente->municipalidad_tramite,
                'fecha_entrevista' => $expediente->fecha_entrevista,
                'presidente_comision' => $expediente->presidente_comision,
                'delegado1' => $expediente->delegado1,
                'delegado2' => $expediente->delegado2,
                'especialista' => $expediente->especialista,
                'delegado_ad_hoc' => $expediente->delegado_ad_hoc
            ]);
        }

        return response()->json(['success' => false]);
    }
*/
    public function guardarEncuesta(Request $request)
    {
        // Validación y guardado de la encuesta
        // Aquí iría la lógica para guardar los datos del formulario
        
        return redirect()->back()->with('success', 'Encuesta enviada correctamente');
    }


       public function mostrar__($idEncuesta)
    {
        //print_r($idEncuesta); exit();
        $encuesta = Encuesta::with(['secciones.preguntas'])->findOrFail($idEncuesta);
       //print_r($encuesta); exit();
        $expedientes = Expediente::all();
        $evaluadores = Evaluadore::all();
        
        return view('frontend.encuesta.all', compact('encuesta', 'expedientes', 'evaluadores'));
    }

    public function buscarExpediente(Request $request)
    {
        $expediente = Expediente::where('numero_expediente', $request->numero_expediente)->first();

        if ($expediente) {
            return response()->json([
                'success' => true,
                'data' => $expediente
            ]);
        }

        return response()->json(['success' => false]);
    }
/*
    public function guardarRespuestas(Request $request, $idEncuesta)
    {
        $validated = $request->validate([
            'numero_expediente' => 'required|exists:expedientes,numero_expediente',
            'respuestas' => 'required|array',
            'respuestas.*' => 'required'
        ]);

        $expediente = Expediente::where('numero_expediente', $request->numero_expediente)->first();

        foreach ($request->respuestas as $preguntaId => $respuesta) {
            RespuestaEncuesta::create([
                'pregunta_id' => $preguntaId,
                'expediente_id' => $expediente->id,
                'respuesta' => is_array($respuesta) ? json_encode($respuesta) : $respuesta
            ]);
        }

        return redirect()->back()->with('success', 'Encuesta enviada correctamente');
    }
*/
    public function guardarRespuestas_(Request $request, $idEncuesta)
    {
        $validated = $request->validate([
            'numero_expediente' => 'required|exists:expedientes,numero_expediente',
            'respuestas' => 'required|array',
            'evaluador_id' => 'nullable|exists:evaluadores,id'
        ]);

        $expediente = Expediente::where('numero_expediente', $request->numero_expediente)->first();

        // Eliminar respuestas anteriores para este expediente (evitar duplicados)
        RespuestaEncuesta::where('expediente_id', $expediente->id)->delete();

        foreach ($request->respuestas as $preguntaId => $respuesta) {
            // Solo procesar si hay una respuesta
            if (!empty($respuesta) || $respuesta === '0') {
                RespuestaEncuesta::create([
                    'pregunta_id' => $preguntaId,
                    'expediente_id' => $expediente->id,
                    'evaluador_id' => $request->evaluador_id,
                    'respuesta' => is_array($respuesta) ? json_encode($respuesta) : $respuesta
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'Encuesta enviada correctamente')
            ->with('expediente', $expediente->numero_expediente);
    }

    public function create()
    {
        $presidentes = Evaluadore::where('tipo', 'presidente')->get();
        $delegados = Evaluadore::where('tipo', 'delegado')->get();
        $especialistas = Evaluadore::where('tipo', 'especialista')->get();
        
        return view('frontend.encuesta.all', compact('presidentes', 'delegados', 'especialistas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_expediente' => 'required|string',
            'municipalidad' => 'required|string',
            'fecha_entrevista' => 'required|date',
            'presidente_id' => 'required|exists:evaluadores,id',
            // Agregar más reglas de validación según sea necesario
        ]);

        // Crear registro de encuesta
        $encuesta = Encuesta::create([
            'numero_expediente' => $request->numero_expediente,
            'municipalidad_tramite' => $request->municipalidad,
            'fecha_entrevista' => $request->fecha_entrevista
        ]);

        // Guardar respuestas de la sección técnica
        $this->guardarRespuestas__($encuesta, 'tecnica', $request->only([
            'sustento_normativo',
            'especificacion_falta',
            // Agregar más campos
        ]));

        // Guardar respuestas de la sección de servicio
        $this->guardarRespuestas__($encuesta, 'servicio', $request->only([
            'aclararon_dudas',
            // Agregar más campos
        ]));

        // Guardar evaluación del presidente
        $this->guardarEvaluacion($encuesta, 'presidente', $request->presidente_id, $request->only([
            'presidente_conocimiento',
            // Agregar más campos
        ]));

        return redirect()->route('encuesta.completada')->with('success', 'Encuesta enviada correctamente');
    }

    private function guardarRespuestas__($encuesta, $seccion, $datos)
    {
        foreach ($datos as $pregunta => $respuesta) {
            $encuesta->respuestas()->create([
                'seccion' => $seccion,
                'pregunta' => $pregunta,
                'respuesta' => $respuesta
            ]);
        }
    }

    private function guardarEvaluacion__($encuesta, $tipo, $evaluadorId, $datos)
    {
        foreach ($datos as $pregunta => $respuesta) {
            $encuesta->respuestas()->create([
                'seccion' => 'evaluacion_' . $tipo,
                'pregunta' => $pregunta,
                'respuesta' => $respuesta,
                'evaluador_id' => $evaluadorId
            ]);
        }
    }





    public function mostrar($idEncuesta)
    {
        //exit();
        $encuesta = Encuesta::with(['secciones.preguntas' => function($query) {
            $query->orderBy('orden');
        }])->findOrFail($idEncuesta);
        
        $expedientes = Expediente::all();
        $evaluadores = Evaluadore::all();
        $especialistas = Evaluadore::where('tipo', 'especialista')->get();
        
        return view('frontend.encuesta.all', compact('encuesta', 'expedientes', 'evaluadores','especialistas'));
    }

    public function guardarRespuestas(Request $request, $idEncuesta)
    {
        $validated = $request->validate([
            'numero_expediente' => 'required|exists:expedientes,numero_expediente',
            'respuestas' => 'required|array',
            'evaluadores' => 'nullable|array'
        ]);

        $expediente = Expediente::where('numero_expediente', $request->numero_expediente)->first();

        foreach ($request->respuestas as $preguntaId => $respuesta) {
            $pregunta = \App\Models\PreguntaEncuesta::find($preguntaId);
            $evaluadorId = $pregunta->evaluador_asociado && isset($request->evaluadores[$preguntaId]) 
                ? $request->evaluadores[$preguntaId] 
                : null;

            \App\Models\RespuestaEncuesta::updateOrCreate(
                [
                    'pregunta_id' => $preguntaId,
                    'expediente_id' => $expediente->id
                ],
                [
                    'respuesta' => is_array($respuesta) ? json_encode($respuesta) : $respuesta,
                    'evaluador_id' => $evaluadorId
                ]
            );
        }

        return redirect()->back()->with('success', 'Encuesta enviada correctamente');
    }
}

