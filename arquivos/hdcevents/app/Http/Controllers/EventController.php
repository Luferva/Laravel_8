<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{

    public function index()
    {
        $search = request('search');

        if($search){
            $events = Event::where([ // where() serve para pesquisar no DB etrazer de volta quando for igual o parametro informado. Equivalente a "select *all where like 'search' 
                ['title', 'like', '%' .$search. '%']
            ])->get();
        }else{
            $events = Event::all(); // all() serve para trazer todos(collection) os registros do banco de dados
        }

        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function search()
    {
        $busca = request('search');
        return view('products', ['busca' => $busca]);
    }

    public function id()
    {
        $id = request('id');
        return view('product', ['id' => $id]);
    }

    public function store(Request $request)
    {

        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->itens = $request->itens;
        
        
        //image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $event->image = $imageName;
        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id){

        $event = Event::findOrFail($id);// find() serve para pegar somente UM registro no banco de dados 

        //Para verificar se o usu??rio j?? esta participando desse evento
        $user = auth()->user();

        $hasUserJoined = false;

        if($user){

            $userEvents = $user->eventsAsParticipant->toArray();

            foreach($userEvents as $userEvent) {
                if($userEvent['id'] == $id){
                    $hasUserJoined = true;
                }
            }
        }

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner'=>$eventOwner, 'hasUserJoined' =>$hasUserJoined]);
    }

    public function dashboard(){

        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events'=>$events, 'eventsasparticipant'=>$eventsAsParticipant]);
    }

    public function destroy($id){

        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg','Evento deletado com sucesso!');
    }

    public function edit($id){

        $user = auth()->user();

        $event = Event::findOrFail($id);

        if($user->id != $event->user_id){
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request){

        $data = $request->all();

        //image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $data['image'] = $imageName;
        }

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg','Evento editado com  sucesso!');
    }

    public function joinEvent($id){

        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id); //attach() met??do que faz a liga????o

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg','Sua presen??a esta confirmada no evento: ' . $event->title);
    }

    public function leaveEvent($id){

        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id); //detach() met??do que remove a liga????o

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg','Sua presen??a esta cancelada no evento: ' . $event->title);

    }

    
}
