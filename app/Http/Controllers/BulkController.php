<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Redirect;

class BulkController extends Controller
{
	public function sampleFileDownload(Request $req)
    {
        $getFile = 'event.csv';
        $directory = public_path("assets/sample/");
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true); // Create the directory with proper permissions
        }
        
        $filePath = $directory . $getFile;
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Define the headers for the response
        $headers = ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        // Return the file as a downloadable response
        return response()->download($filePath, $getFile, $headers);
    }


    public function importFile(Request $req)
    {
        if ($req->hasFile('importfile')) {
            // Validate the uploaded file
            $validator = Validator::make($req->all(), [
                'importfile' => 'required|file|mimes:csv,xlsx,xls|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $file = $req->file('importfile'); // Get the uploaded file

            // Define the directory path
            $directory = public_path('assets/import-directory');

            // Create the directory if it doesn't exist
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true); // Create the directory with proper permissions
            }

            // Move the uploaded file to the directory
            $file->move($directory, $file->getClientOriginalName());

            $importFileName = $file->getClientOriginalName();
            $filePath = $directory . '/' . $importFileName; // Define the path for FastExcel

            // Use FastExcel to import the file
            (new FastExcel())->import($filePath, function ($line) {

                // Check if event_id already exists
                if (Event::where('event_id', $line['Event ID'])->exists()) {
                    $errorMessages[] = "Event ID '{$line['Event ID']}' already exists.";
                    return null; // Skip this line
                }

                // Validate the incoming line data
                $validator = Validator::make($line, [
                    'event_id' => 'required|string|unique:events,event_id',
                    'name' => 'nullable|string|max:100',
                    'type' => 'nullable|in:Upcomming,Completed',
                    'description' => 'nullable|string',
                    'status' => 'required|integer|in:1,2',
                    'event_time' => 'required|date',
                    'created_by' => 'nullable|integer',
                ]);

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $message) {
                        $errorMessages[] = $message;
                    }
                    return null; // Skip this line
                }

                $createdByUser = User::where('username', $line['Created By'])->first();
                $updatedByUser = User::where('username', $line['Updated By'])->first();

                // Get user IDs or set them to null if not found
                $createdById = $createdByUser ? $createdByUser->id : null;
                $updatedById = $updatedByUser ? $updatedByUser->id : null;


                return Event::create([
                    'created_by' => Auth::id() ?? 1,
                    'event_id' => $line['Event ID'],
                    'name' => $line['Name'],
                    'type' => $line['Type'] ?? 'Upcomming',
                    'description' => $line['Description'],
                    'status' => $line['Status'],
                    'event_time' => $line['Event Time'],
                    'created_by' => $createdById,
                    'updated_by' => $updatedById,
                ]);
            });

            if (!empty($errorMessages)) {
                return redirect()->back()->with('error', implode('<br>', $errorMessages))->withInput();
            }

            return redirect()->back()->with('success', 'File imported successfully.');
        }

        return redirect()->back()->with('error', 'Please select an Excel or CSV file.');
    }


    public function export()
    {
        function eventsGenerator()
        {
            $response = Event::with(['creator', 'updater', 'deleter'])->get();
            foreach ($response as $key => $event) {
                $arrayval = array(
                    'SL' => $key + 1,
                    'Event ID' => $event->event_id,
                    'Name' => $event->name,
                    'Type' => $event->type,
                    'Description' => $event->description,
                    'Status' => $event->status == 1 ? 'Active' : 'Inactive',
                    'Event Time' => $event->event_time,
                    'Created By' => optional($event->creator)->name ?? 'N/A',
                    'Updated By' => optional($event->updater)->name ?? 'N/A',
                    'Deleted By' => optional($event->deleter)->name ?? 'N/A',
                    'Created At' => $event->created_at,
                    'Updated At' => $event->updated_at,
                );
                yield $arrayval; // Use yield to return each row
            }
        }

        return (new FastExcel(eventsGenerator()))->download('events_' . date('Y-m-d_H-i') . '.csv');
    }

}
