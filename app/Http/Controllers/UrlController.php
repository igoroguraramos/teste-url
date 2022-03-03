<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UrlController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except' => 'lista']);
        $this->middleware('auth:api',['only' => 'lista']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls =  Url::where('id_usuario',Auth::id())->get();
        return view('lista',['urls' => $urls]);
    }

    public function lista(){
        $urls =  Url::where('id_usuario', auth('api')->id())->get();
        return response($urls);
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
    public function store(Request $request)
    {
        $requestNew = $request->all();
        $response = Http::withOptions(['verify' => false])->get($request->url);
        $requestNew['id_usuario'] = Auth::id();
        $requestNew['resposta'] = $response->body();
        $requestNew['status_code'] = $response->status();
        $url = Url::create($requestNew);
        return $url;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
