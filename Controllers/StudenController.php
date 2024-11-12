<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        // Si no hay estudiantes, podrías retornar un mensaje (comentado por ahora)
        // if ($students->isEmpty()) {
        //     $data = [
        //         'mensaje' => 'No hay estudiantes registrados',
        //         'status' => 200
        //     ];
        //     return response()->json($data, 404);
        // }

        $data = [
            "students" => $students,
            "status" => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'correo' => 'required|email|unique:student',
            'celular' => 'required|digits:10',
            'lenguaje' => 'required|in:Ingles,Español,Frances',
        ]);

   
        if ($validator->fails()) {
            $data = [
                'mensaje' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

 
        $student = Student::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'celular' => $request->celular,
            'lenguaje' => $request->lenguaje,
        ]);

 
        if (!$student) {
            $data = [
                'mensaje' => 'Error al crear un estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }


        $data = [
            'student' => $student,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show ($id)

    {
$student=Student::find($id);

if (!$student) {

  $data= [
    'mensaje'=>  'Estudiante no encontrado',
    'status'=> 404
  ];

  return response()->json ($data,404);
}

$data= [
  'student'=> $student,
  'status'=>200
];
return response()->json($data,200);
}

public function destroy ($id)
{
  $student= Student::find ($id);

  if (!$student){
    $data=[
      'mensaje'=> 'Estudiante no encontrado',
      'status'=>404
    ];
    return response()->json ($data, 404);
  }

  $student->delete ();

  $data=[
    "mensaje"=> "Estudiante eliminado",
    'status'=>200
  ];
  return response()->json ($data, 200);
}
public function update(Request $request, $id)
{
  $student =Student::find($id);

  if (!$student){
    $data =[
      'mensaje' => 'Estudiante no encontrado',
      'status' =>404
    ];
    return response()->json ($data,404);

  }
  $validator = Validator::make($request->all(), [
    'nombre' => 'required|max:255',
    'correo' => 'required|email|unique:student',
    'celular' => 'required|digits:10',
    'lenguaje' => 'required|in:Ingles,Español,Frances',
]);
if ($validator->fails()){
  $data =[
    'mensaje' => "Error en la validacion de datos",
    'errors' => $validator->errors(),
    'status' => 400
  ];
  return response ()->json($data, 400);
}
$student->nombre =$request->nombre;
$student->correo =$request->correo;
$student->celular =$request->celular;
$student->lenguaje =$request->lenguaje;

$student->save ();

$data =[
  'mensaje'=> "Estudiante actualizado ",
  "student" => $student,
 "status" =>200
];
return response()->json ($data, 200);
}
}
