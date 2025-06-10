<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{

    public function index()
    {
        $notes = Auth::user()
            ->notes()
            ->notArchived()
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);


        return view('notes.index', compact('notes'));
    }

    public function archived()
    {
        $notes = Auth::user()
            ->notes()
            ->Archived()
            ->orderBy('created_at', 'desc')
            ->paginate(12);


        return view('notes.index', compact('notes'));
    }

    public function trash()
    {
        $notes = Auth::user()
            ->notes()
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(12);
        return view('notes.index', compact('notes'));
    }

    public function search(Request $request)
    {
        $q       = trim($request->input('q', ''));
        $context = $request->input('context', 'index');

        $notesQuery = Auth::user()->notes();

        if ($q !== '') {
            $notesQuery->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('body',  'like', "%{$q}%");
            });
        }

        if ($context === 'archived') {
            $notesQuery->where('is_archived', true);
        } elseif ($context === 'trash') {
            $notesQuery->onlyTrashed();
        } else {
            $notesQuery->where('is_archived', false);
        }

        $notes = $notesQuery->orderBy('created_at', 'desc')->paginate(12);

        return view('notes.partials.notes-grid', compact('notes'));
    }




    public function create()
    {
        return view('notes.create');
    }

    public function togglePin(Note $note)
    {
        $this->authorizeNote($note);

        $note->is_pinned = !$note->is_pinned;
        $note->save();

        return response()->json([
            'is_pinned' => $note->is_pinned,
            'message' => $note->is_pinned ? 'Note pinned!' : 'Note unpinned!',
        ]);
    }

    public function toggleArchive(Note $note)
    {
        $this->authorizeNote($note);

        $note->is_archived = !$note->is_archived;
        $note->save();

        return response()->json([
            'is_archived' => (bool) $note->is_archived,
            'message' => $note->is_archived ? 'Note archived!' : 'Note restored from archive!',
        ]);
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'color' => 'nullable|string|size:7',
        ]);

        $request->user()->notes()->create($validated);
        return redirect()->route('notes.index')->with('success', 'Note created.');
    }



    public function show(Note $note)
    {
        $this->authorizeNote($note);

        return view('notes.edit', compact('note'));
    }



    public function edit(Note $note)
    {
        $this->authorizeNote($note);

        if ($note->trashed()) {
            return view('notes.trash_show', compact('note'));
        }

        return view('notes.edit', compact('note'));
    }

    public function restore(Note $note)
    {
        $this->authorizeNote($note);

        if ($note->trashed()) {
            $note->restore();
            return redirect()->route('notes.trash')
                ->with('success', 'Note berhasil dipulihkan.');
        }

        return redirect()->route('notes.index')
            ->with('info', 'Note ini belum di-hapus.');
    }

    public function forceDelete(Note $note)
    {
        $this->authorizeNote($note);

        if ($note->trashed()) {
            $note->forceDelete();
            return redirect()->route('notes.trash')
                ->with('success', 'Note berhasil dihapus permanen.');
        }

        $note->delete();
        return redirect()->route('notes.index')
            ->with('success', 'Note dihapus.');
    }


    public function update(Request $request, Note $note)
    {
        $this->authorizeNote($note);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'color' => 'nullable|string|size:7',
        ]);

        $note->update($validated);
        return redirect()->route('notes.index')->with('success', 'Note updated.');
    }



    public function destroy(Note $note)
    {
        $this->authorizeNote($note);
        $orderedNotes = auth()->user()->notes()->orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc')->get();

        $currentIndex = $orderedNotes->search(fn($item) => $item->id === $note->id);

        $note->delete();

        $nextNote = null;
        if ($currentIndex !== false && isset($orderedNotes[$currentIndex + 1])) {
            $nextNote = $orderedNotes[$currentIndex + 1];
        } elseif ($currentIndex > 0 && isset($orderedNotes[$currentIndex - 1])) {
            $nextNote = $orderedNotes[$currentIndex - 1];
        }

        if ($nextNote) {
            return redirect()->route('notes.edit', $nextNote)->with('success', 'Note moved to Trash.');
        } else {
            return redirect()->route('notes.index')->with('success', 'Note moved to Trash.');
        }
    }

    private function authorizeNote(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
