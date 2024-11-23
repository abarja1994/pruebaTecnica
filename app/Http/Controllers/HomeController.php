<?php

namespace App\Http\Controllers;

use App\Enums\EstadoEnum;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $numUsuarios = 0;
        $usuarios = User::where('is_deleted', EstadoEnum::Inactivo->value)->get();
        if (count($usuarios) > 0) {
            $numUsuarios = count($usuarios);
        }
        return view('home',  compact('numUsuarios'));
    }
}
