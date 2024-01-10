<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $search = \request('search');

        if ($search) {
            $events = Event::where([['title', 'like', "%{$search}%"]])->get();
        } else {
            $events = Event::all();
        }

        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {   #@formatter:off

        $event = new Event();

        $event->title       = $request->title;
        $event->city        = $request->city;
        $event->date_event  = $request->date_event;
        $event->description = $request->description;
        $event->private     = $request->private;
        $event->items       = $request->items;

        $user               = auth()->user();
        $event->user_id     = $user->id;

        #Image upload
        if($request->hasFile('image') && $request->file('image')->isValid()){
                $requestImage = $request->image;
                $extension    = $requestImage->extension();
                $imageName    = md5($requestImage->getClientOriginalName().strtotime('now')) .".{$extension}";

                $requestImage->move(public_path('img/events'),$imageName);
                $event->image = $imageName;
        }

        $event->save();

        return redirect('/')->with('msg','Evento criado com sucesso');
        #@formatter:on
    }

    public function show($id)
    {
        #@formatter:off
        $event      = Event::findOrFail($id);
        $user       = auth()->user();
        $eventOwner = User::where('id', '=', $event->user_id)->first();

        if ($eventOwner) {
            $eventOwner = $eventOwner->toArray();
        }

        $hasUserJoined = false;

        if($user){
            $userEvents = $user->eventsAsParticipant->toArray();

            foreach ($userEvents as $userEvent) {
                if($userEvent['id'] == $id){
                    $hasUserJoined = true;
                    break;
                }
            }
        }

        return view('events.show', [
            'event'         => $event,
            'eventowner'    => $eventOwner,
            'hasUserJoined' => $hasUserJoined,
        ]);
        #@formatter:on
    }

    public function dashboard()
    {
        #@formatter:off
        $user                = auth()->user();
        $events              = $user->events;
        $eventsAsParticipant = $user->eventsAsParticipant;
        #@formatter:on

        return view('events.dashboard', [
            'events' => $events,
            'eventsasparticipant' => $eventsAsParticipant
        ]);

    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso');
    }

    public function edit($id)
    {
        $user = auth()->user();

        $event = Event::findOrFail($id);

        if ($user->id != $event->user->id) {
            return redirect('/dashboard');
        }


        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        #@formatter:off
        #Image upload
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $requestImage = $request->image;
            $extension    = $requestImage->extension();
            $imageName    = md5($requestImage->getClientOriginalName().strtotime('now')) .".{$extension}";

            $requestImage->move(public_path('img/events'),$imageName);
            $data['image'] = $imageName;

        }
        #@formatter:on

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso');
    }

    public function joinEvent($id)
    {
        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);
        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento ' . $event->title);
    }

    public function leaveEvent($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);
        $user->eventsAsParticipant()->detach($id);

        return redirect('/dashboard')->with('msg', 'Voçê sai com sucesso do evento ' . $event->title);
    }
}
