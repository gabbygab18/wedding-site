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

    public function storeRsvp(Request $request)
    {
        $validated = $request->validate([
            'wedding_id'   => 'required|exists:weddings,id',
            'guest_name'   => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'attending'    => 'required|in:yes,no',
            'guests_count' => 'required|integer|min:1|max:10',
            'message'      => 'nullable|string|max:1000',
        ]);

        $rsvp = Rsvp::create([
            'wedding_id'   => $validated['wedding_id'],
            'guest_name'   => $validated['guest_name'],
            'email'        => $validated['email'] ?? null,
            'attending'    => $validated['attending'] === 'yes',
            'guests_count' => $validated['guests_count'],
            'message'      => $validated['message'] ?? null,
            'notified'     => false,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'name'    => $rsvp->guest_name,
                'message' => 'RSVP received!'
            ]);
        }

        return back()->with('success', 'Your RSVP has been received!');
    }
}
