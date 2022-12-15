<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class EventController extends Controller
{
    //

    public function index(){

        $nome = "Luiz";
        $idade = 29;

        $arr = [10,20,30,40];

        $nomes = ["Luiz", "Fernando", "Ribeiro", "Vargas"];

        return view('welcome',
        [
            'nome' => $nome,
            'idade2' => $idade,
            'profissao' => "Programador",
            'arr' => $arr,
            'nomes' => $nomes
        ]);
    }

    public function create(){
        return view('events.create');
    }

    public function search(){
        $busca = request('search');
        return view('products', ['busca'=>$busca]);
    }

    public function id(){
        $id = request('id');
        return view('product', ['id'=>$id]);
    }
   

}
