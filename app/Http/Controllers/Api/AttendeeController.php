<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AttendeeController extends Controller
{
    use CanLoadRelationships;

    private array $relations = ['user', 'event'];

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event ): AnonymousResourceCollection
    {
        $attendees = $this->loadRelationships($event->attendees()->latest());

        return AttendeeResource::collection($attendees->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event): AttendeeResource
    {
        $attendee = $event->attendees()->create([
            'user_id' => 1,
        ]);

        return new AttendeeResource($this->loadRelationships($attendee));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee): AttendeeResource
    {
        return new AttendeeResource($this->loadRelationships($attendee));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee): Response
    {
        $attendee->delete();

        return response(status: 204);
    }
}
