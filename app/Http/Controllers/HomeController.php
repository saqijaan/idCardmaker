<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
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
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $view = \View::make('frontend.index', [
            'data' => 'Hello World !'
        ]);
        $view = $view->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view );
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
        // return view('home');
    }
}
