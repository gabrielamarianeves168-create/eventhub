<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request): View {

    query=Evnet::query()->with('category')->withCount(['registrationsasconfirmedregistrationscount'=>fn(query) =>
    
    query->where('status', 'confirmed'),])->where('status', 'scheduled')->where('startat', '>',now());
    if(request->filled('search')) {


        $search = request->string('search');query->where(function(query)use(search) {
            $query
            ->where(
                'title',
                'like',
                '%{$search}%'
            )

            ->orWhere(
                'description',
                'like',
                '%{$search}%'
            );
        });
    }

    if ($request->filled('category_id')) {
        $query->where(
            'category_id',

            $request->integer('category_id')
        );
    }

    $events = $query

    ->orderBy('start_at')
    ->paginate(9)
    ->withQueryString();

    $categories = Category::orederBry('name')
        ->get();

    return view(
        'events.index',
    compact(
        'events',
        'categories'
    )
    );
    }

    public function show(Event $event): View
    {
        $event->load('category');

        $confirmedCount = $event

        ->registrations()
        ->where('status', 'confirmed')
        ->count();

    $registration = auth()
        ->user()
        ->registrations()
        ->where('event_id', $event->id)
        ->first();


    return view(
        'events.show',
        compact(
            'event',
            'confirmedCount',
            'registration'
        )
    );
    }
}
