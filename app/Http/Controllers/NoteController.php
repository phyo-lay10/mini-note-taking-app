<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::where("user_id", Auth::user()->id)->get();
        return view("index", compact("notes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        $userId = Auth::user()->id;

        Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $userId,
        ]);
        return redirect()->route('notes.index')->with('success', 'You have successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $note = Note::findOrFail($id);
        return view('edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateRequest($request);

        Note::findOrFail($id)->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return redirect()->route('notes.index')->with('success', 'You have successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Note::findOrFail($id)->delete();
        return back();
    }

    public function copy($id)
    {

        $note = Note::findOrfail($id);
        $newNote = $note->replicate();
        // $newNote->created_at = Carbon::now();
        $newNote->save();
        return redirect('notes')->with('success', 'Note copied successfully');
    }

    public function share(Request $request, $id)
    {
        $request->validate([
            'receiver_email' => 'required',
        ]);
        $note = Note::findOrfail($id);
        $user = User::where('email', $request->receiver_email)->first();

        Note::create([
            'title' => $note->title,
            'content' => $note->content,
            'user_id' => $user->id,
        ]);
        return back()->with('success', 'Note shared successfully!');
    }

    public function validateRequest($request)
    {
        return $request->validate([
            "title" => "required",
            "content" => "required",
        ]);
    }
}
