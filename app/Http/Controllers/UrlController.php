<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Traits\ApiCRUDTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['only' => 'index']);
        $this->middleware('jwt',['except' => 'index']);
        $this->model = Url::class;
    }

    public function regrasDeValidacao(){
        return [
            'url' => ['required'],
        ];
    }

    public function mensagensdeValidacao(){
        return [
            'required' => 'O (A) :attribute é obrigatório (a)'
        ];
    }

    public function index()
    {
        $urls =  Url::where('id_usuario',Auth::id())->get();
        return view('index',['urls' => $urls]);
    }

    public function lista(){
        $urls =  Url::where('id_usuario', Auth::id())->get();
        return response($urls);
    }

    public function store(Request $request)
    {
        try{
            $requestNew = $request->all();
            $validator = Validator::make($request->all(), $this->regrasDeValidacao(), $message = $this->mensagensdeValidacao());
            if ($validator->fails()) {
                return response(['errors' => $validator->errors()],500);
            }
            $response = Http::withOptions(['verify' => false])->get($request->url);
            $requestNew['id_usuario'] = Auth::id();
            $requestNew['resposta'] = $response->body();
            $requestNew['status_code'] = $response->status();
            return response($this->model::create($requestNew),201);
        }catch(\Exception $e){
           return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $requestNew = $request->all();
            $validator = Validator::make($request->all(), $this->regrasDeValidacao(), $message = $this->mensagensdeValidacao());
            if ($validator->fails()) {
                return response(['errors' => $validator->errors()],500);
            }
            $model = $this->model::where('id_usuario',Auth::id())->find($id);
            if($model){
                $requestNew = $request->all();
                $response = Http::withOptions(['verify' => false])->get($request->url);
                $requestNew['resposta'] = $response->body();
                $requestNew['status_code'] = $response->status();
                $model->update($requestNew);
                return response($model,200);
            }else{
                return response([
                    'message'   => 'Registro Não Localizado',
                ],404);
            }
        }catch(\Exception $e){
           return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try{
            $model = $this->model::where('id_usuario',Auth::id())->find($id);

            if(!$model) {
                return response()->json([
                    'message'   => 'Registro Não Localizado',
                ], 404);
            }

            if($model->delete()){
                return response(['message' => 'Removido com Sucesso'],200);
            }

        }catch(\Exception $e){
           return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
