<?php
namespace App\Repositories;

use App\Models\Event;
use App\Repositories\EventRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class EventRepository implements EventRepositoryInterface {

    /**
     * Get a list of all events.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getList(){
        return Event::all();
    }

    /**
     * Create a new event.
     *
     * @param array $data
     * @return Event
     */
    public function create(array $data){
        // Create a new event instance and save it to the database
        return Event::create($data);
    }

    /**
     * Find an event by its ID.
     *
     * @param int $id
     * @return Event|null
     */
    public function find($id){
        // Find and return the event or null if not found
        return Event::find($id);
    }

    /**
     * Update an existing event by its ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data)
    {
        // Find the event and update it with the given data
        $event = $this->find($id);
        if ($event) {
            return $event->update($data);
        }
        return false; // Return false if the event was not found
    }

    /**
     * Delete an event by its ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        // Find the event and check if it exists
        $event = $this->find($id);
        
        if ($event) {
            // Set the 'deleted_by' field to the current authenticated user's ID
            $event->deleted_by = Auth::id();
            $event->save(); // Save the event to update 'deleted_by'

            // Perform soft delete
            return $event->delete();
        }
        
        return null; // Return null if the event was not found
    }
}
