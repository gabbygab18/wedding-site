<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\WeddingPhoto;
use App\Models\EntourageMember;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ─── Dashboard ────────────────────────────────
    public function dashboard()
{
    $wedding      = Wedding::with(['photos', 'entourage', 'rsvps'])->first();
    $totalRsvp    = Rsvp::count();
    $attending    = Rsvp::where('attending', true)->count();
    $notAttending = Rsvp::where('attending', false)->count();
    $totalGuests  = Rsvp::where('attending', true)->sum('guests_count');
    $recentRsvps  = Rsvp::latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'wedding', 'totalRsvp', 'attending', 'notAttending', 'totalGuests', 'recentRsvps'
    ));
}

    // ─── Wedding Details ──────────────────────────
    public function editWedding()
    {
        $wedding = Wedding::firstOrFail();
        return view('admin.wedding.edit', compact('wedding'));
    }

    public function updateWedding(Request $request)
    {
        $wedding = Wedding::firstOrFail();

        $validated = $request->validate([
            'bride_name'       => 'required|string|max:255',
            'groom_name'       => 'required|string|max:255',
            'wedding_date'     => 'required|date',
            'ceremony_time'    => 'required',
            'reception_time'   => 'nullable',
            'venue_name'       => 'required|string|max:255',
            'venue_address'    => 'required|string',
            'reception_venue'  => 'nullable|string|max:255',
            'love_story'       => 'nullable|string',
            'hashtag'          => 'nullable|string|max:100',
            'rsvp_enabled'     => 'boolean',
            'rsvp_deadline'    => 'nullable|date',
            'map_embed_url'    => 'nullable|string|max:5000',
            'hero_video'       => 'nullable|file|mimes:mp4,webm,mov|max:102400',
            'background_music' => 'nullable|file|mimes:mp3,ogg,wav,m4a|max:20480',
        ]);

        // Hero video upload
        if ($request->hasFile('hero_video')) {
            if ($wedding->hero_video) {
                Storage::disk('public')->delete($wedding->hero_video);
            }
            $validated['hero_video'] = $request->file('hero_video')
                ->store('wedding/video', 'public');
        } else {
            unset($validated['hero_video']);
        }

        // Background music upload
        if ($request->hasFile('background_music')) {
            if ($wedding->background_music) {
                Storage::disk('public')->delete($wedding->background_music);
            }
            $validated['background_music'] = $request->file('background_music')
                ->store('wedding/audio', 'public');
        } else {
            unset($validated['background_music']);
        }

        // Remove flags
        if ($request->boolean('remove_video')) {
            if ($wedding->hero_video) {
                Storage::disk('public')->delete($wedding->hero_video);
            }
            $validated['hero_video'] = null;
        }
        if ($request->boolean('remove_music')) {
            if ($wedding->background_music) {
                Storage::disk('public')->delete($wedding->background_music);
            }
            $validated['background_music'] = null;
        }

        $validated['rsvp_enabled'] = $request->has('rsvp_enabled');

        $wedding->update($validated);

        return redirect()->route('admin.wedding.edit')
            ->with('success', 'Wedding details updated successfully.');
    }

    // ─── Photos ───────────────────────────────────
    public function photosIndex()
    {
        $wedding = Wedding::firstOrFail();
        $photos  = $wedding->photos()->orderBy('sort_order')->get();
        return view('admin.photos.index', compact('wedding', 'photos'));
    }

    public function storePhotos(Request $request)
    {
        $request->validate([
            'photos'   => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:10240',
        ]);

        $wedding   = Wedding::firstOrFail();
        $lastOrder = $wedding->photos()->max('sort_order') ?? 0;

        foreach ($request->file('photos') as $i => $file) {
            $path = $file->store('wedding/photos', 'public');
            $wedding->photos()->create([
                'path'       => $path,
                'sort_order' => $lastOrder + $i + 1,
            ]);
        }

        return back()->with('success', 'Photos uploaded successfully.');
    }

    public function destroyPhoto(WeddingPhoto $photo)
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();
        return back()->with('success', 'Photo deleted.');
    }

    public function updatePhotoOrder(Request $request, WeddingPhoto $photo)
    {
        $request->validate(['order' => 'required|integer|min:0']);
        $photo->update(['sort_order' => $request->order]);
        return response()->json(['success' => true]);
    }

    // ─── Entourage ────────────────────────────────
    public function entourageIndex()
    {
        $wedding   = Wedding::firstOrFail();
        $entourage = $wedding->entourage()->orderBy('role')->orderBy('name')->get();
        return view('admin.entourage.index', compact('wedding', 'entourage'));
    }

    public function storeEntourage(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'wedding_id' => 'required|exists:weddings,id',
        ]);

        EntourageMember::create($validated);

        return back()->with('success', 'Member added.');
    }

    public function destroyEntourage(EntourageMember $member)
    {
        $member->delete();
        return back()->with('success', 'Member removed.');
    }

    // ─── RSVPs ────────────────────────────────────
    public function rsvpIndex(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $query  = Rsvp::with('wedding')->latest();

        if ($filter === 'attending') {
            $query->where('attending', true);
        } elseif ($filter === 'declining') {
            $query->where('attending', false);
        }

        $rsvps = $query->paginate(20)->withQueryString();

        $stats = [
            'total'    => Rsvp::count(),
            'attending'=> Rsvp::where('attending', true)->count(),
            'declining'=> Rsvp::where('attending', false)->count(),
            'guests'   => Rsvp::where('attending', true)->sum('guests_count'),
        ];

        return view('admin.rsvp.index', compact('rsvps', 'stats', 'filter'));
    }

    public function destroyRsvp(Rsvp $rsvp)
    {
        $rsvp->delete();
        return back()->with('success', 'RSVP deleted.');
    }

    public function exportRsvp()
    {
        $rsvps = Rsvp::with('wedding')->latest()->get();

        $csv  = "Name,Email,Attending,Guests,Message,Submitted\n";
        foreach ($rsvps as $r) {
            $csv .= implode(',', [
                '"' . str_replace('"', '""', $r->guest_name) . '"',
                '"' . ($r->email ?? '') . '"',
                $r->attending ? 'Yes' : 'No',
                $r->guests_count,
                '"' . str_replace('"', '""', $r->message ?? '') . '"',
                $r->created_at->format('Y-m-d H:i'),
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="rsvps-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
