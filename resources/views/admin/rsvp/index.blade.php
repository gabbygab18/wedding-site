@extends('layouts.admin')
@section('title', 'RSVPs')
@section('page-title', 'RSVP Responses')

@section('content')
<div class="rsvp-toolbar">
  <div class="filter-tabs">
    <a href="{{ route('admin.rsvp.index') }}" class="filter-tab {{ !request('filter') ? 'active' : '' }}">
      All ({{ $stats['total'] }})
    </a>
    <a href="{{ route('admin.rsvp.index', ['filter' => 'attending']) }}" class="filter-tab {{ request('filter') === 'attending' ? 'active' : '' }}">
      Attending ({{ $stats['attending'] }})
    </a>
    <a href="{{ route('admin.rsvp.index', ['filter' => 'declining']) }}" class="filter-tab {{ request('filter') === 'declining' ? 'active' : '' }}">
      Declined ({{ $stats['declining'] }})
    </a>
  </div>
  <a href="{{ route('admin.rsvp.export') }}" class="btn btn-outline">Export CSV</a>
</div>

<div class="table-card">
  <table class="data-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Guests</th>
        <th>Message</th>
        <th>Date</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($rsvps as $rsvp)
      <tr>
        <td><strong>{{ $rsvp->guest_name }}</strong></td>
        <td>{{ $rsvp->email ?? '—' }}</td>
        <td>
          <span class="badge badge-{{ $rsvp->attending ? 'green' : 'red' }}">
            {{ $rsvp->attending ? 'Attending' : 'Declined' }}
          </span>
        </td>
        <td>{{ $rsvp->guests_count }}</td>
        <td class="message-cell">{{ Str::limit($rsvp->message, 50) ?? '—' }}</td>
        <td>{{ $rsvp->created_at->format('M j, Y') }}</td>
        <td>
          <form method="POST" action="{{ route('admin.rsvp.destroy', $rsvp) }}" onsubmit="return confirm('Delete this RSVP?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon btn-danger">✕</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="empty-state">No RSVPs yet.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="pagination-wrap">
  {{ $rsvps->links() }}
</div>
@endsection
