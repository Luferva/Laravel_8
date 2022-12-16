<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Models\Event;

class EventController extends Controller
{
    
    public function index(){

       $events = Event::all();

       return view('welcome', ['events'=> $events]);
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
