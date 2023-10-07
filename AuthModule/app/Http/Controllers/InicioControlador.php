<?php

namespace App\Http\Controllers;

use App\Services\PaypalService;
use Illuminate\Http\Request;

class InicioControlador extends Controller
{
    public function index()
    {
        // $servicio  = new  PaypalService;
        // $data = $servicio->ListarPlanes();
        // $planesPaypal = $data['plans'];
        $planesPaypal = $this->planes();
        return view('welcome', compact('planesPaypal'));
    }


    public function planes()
    {
        $servicio  = new  PaypalService;
        $data = $servicio->ListarPlanes();
        $planesPaypal = $data['plans'];
        return $planesPaypal;
    }
}
