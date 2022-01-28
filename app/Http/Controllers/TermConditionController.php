<?php

namespace App\Http\Controllers;

use App\Models\TermCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TermConditionController extends Controller
{
    public function store(Request $request)
    {
        $termCondition = TermCondition::find(1);

        if (!$termCondition) {
            $rules = array(
                'content' => 'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $newTermCondition = new TermCondition();
            $newTermCondition->content = $request->content;

            if ($newTermCondition->save()) {
                return response()->json([
                    'res' => true,
                    'message' => 'Registros exitoso'
                ], 200);
            } else {
                return response()->json([
                    'res' => false,
                    'message' => 'Error al guardar el registro'
                ], 400);
            }
        } else {
            return response()->json([
                'res' => false,
                'message' => 'Ya hay un término y condición creado'
            ], 400);
        }
    }

    public function getById()
    {
        $termCondition = TermCondition::find(1);

        if ($termCondition) {
            return response()->json([
                'res' => true,
                'data' => $termCondition
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'data' => []
            ], 200);
        }
    }

    public function view()
    {
        $termCondition = TermCondition::find(1);

        if ($termCondition) {
            return response()->json([
                'res' => true,
                'data' => $termCondition
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'data' => []
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $termCondition = TermCondition::find($id);
        if ($termCondition) {
            $rules = array(
                'content' => 'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $termCondition->content = $request->content;

            if ($termCondition->update()) {
                return response()->json([
                    'res' => true,
                    'message' => 'Registro acutalizado con exito'
                ], 200);
            } else {
                return response()->json([
                    'res' => false,
                    'message' => 'Error al actualizar el registro'
                ], 400);
            }
        } else {
            return response()->json([
                'res' => false,
                'message' => 'No existe el registro'
            ], 400);
        }
    }
}