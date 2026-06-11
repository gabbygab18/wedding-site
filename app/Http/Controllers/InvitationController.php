<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\Rsvp;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show(Request $request)
    {
        $wedding = Wedding::with(['photos', 'entourage'])->firstOrFail();
        $guestName = $request->query('guest');

        return view('invitation', compact('wedding', 'guestName'));
    }

    public function searchGuest(Request $request, Wedding $wedding)
    {
        $name = trim($request->query('name', ''));

        if (strlen($name) < 2) {
            return response()->json(['found' => false]);
        }

        $guest = $wedding->guests()
            ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($name) . '%'])
            ->first();

        if (!$guest) {
            return response()->json(['found' => false]);
        }

        // Check if already RSVP'd
        $existing = Rsvp::where('wedding_guest_id', $guest->id)->first();

        return response()->json([
            'found'          => true,
            'id'             => $guest->id,
            'name'           => $guest->name,
            'seats_allotted' => $guest->seats_allotted,
            'already_rsvped' => $existing !== null,
        ]);
    }

    public function storeRsvp(Request $request)
    {
        $validated = $request->validate([
            'wedding_id'       => 'required|exists:weddings,id',
            'wedding_guest_id' => 'nullable|exists:wedding_guests,id',
            'email'            => 'nullable|email|max:255',
            'attending'        => 'required|in:yes,no',
            'guest_names'      => 'nullable|array',
            'guest_names.*'    => 'nullable|string|max:255',
            'message'          => 'nullable|string|max:1000',
        ]);

        // Primary guest name = first in guest_names array, fallback to free-text
        $guestNames  = array_filter($validated['guest_names'] ?? []);
        $primaryName = $guestNames[0] ?? 'Guest';

        $rsvp = Rsvp::updateOrCreate(
            ['wedding_guest_id' => $validated['wedding_guest_id'] ?? null,
             'wedding_id'       => $validated['wedding_id']],
            [
                'guest_name'   => $primaryName,
                'email'        => $validated['email'] ?? null,
                'attending'    => $validated['attending'] === 'yes',
                'guests_count' => count($guestNames) ?: 1,
                'guest_names'  => array_values($guestNames),
                'message'      => $validated['message'] ?? null,
                'notified'     => false,
            ]
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'name'    => $rsvp->guest_name,
                'message' => 'RSVP received!',
            ]);
        }

        return back()->with('rsvp_success', $primaryName);
    }
}
