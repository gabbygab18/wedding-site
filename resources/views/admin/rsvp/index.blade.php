@extends('layouts.admin')
@section('title', 'RSVPs')
@section('page-title', 'RSVP Responses')

@section('content')

  {{-- ── Toolbar ──────────────────────────────────────── --}}
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

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- ── Summary cards ────────────────────────────────── --}}
  <div class="rsvp-summary-grid">
    <div class="summary-card">
      <span class="summary-number">{{ $stats['total'] }}</span>
      <span class="summary-label">Total RSVPs</span>
    </div>
    <div class="summary-card summary-card--green">
      <span class="summary-number">{{ $stats['attending'] }}</span>
      <span class="summary-label">Attending</span>
    </div>
    <div class="summary-card summary-card--red">
      <span class="summary-number">{{ $stats['declining'] }}</span>
      <span class="summary-label">Declined</span>
    </div>
    <div class="summary-card summary-card--gold">
      <span class="summary-number">{{ $stats['total_guests'] }}</span>
      <span class="summary-label">Total Guests</span>
    </div>
  </div>

  {{-- ── RSVP Responses Table ─────────────────────────── --}}
  <div class="table-card">
    <table class="data-table rsvp-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Primary Guest</th>
          <th>Guest Names</th>
          <th>Email</th>
          <th>Status</th>
          <th>Seats</th>
          <th>Message</th>
          <th>Submitted</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($rsvps as $i => $rsvp)
        <tr class="{{ !$rsvp->attending ? 'row-declined' : '' }}">
          <td class="td-num">{{ $rsvps->firstItem() + $i }}</td>
          <td><strong>{{ $rsvp->guest_name }}</strong></td>
          <td class="td-guests">
            @if($rsvp->guest_names && count($rsvp->guest_names))
              <ol class="guest-names-ol">
                @foreach($rsvp->guest_names as $name)
                  @if($name)<li>{{ $name }}</li>@endif
                @endforeach
              </ol>
            @else
              <span class="text-muted">—</span>
            @endif
          </td>
          <td>{{ $rsvp->email ?? '—' }}</td>
          <td>
            <span class="badge badge-{{ $rsvp->attending ? 'green' : 'red' }}">
              {{ $rsvp->attending ? 'Attending' : 'Declined' }}
            </span>
          </td>
          <td class="td-center">{{ $rsvp->guests_count }}</td>
          <td class="message-cell">
            @if($rsvp->message)
              <span class="message-preview" title="{{ $rsvp->message }}">{{ Str::limit($rsvp->message, 60) }}</span>
            @else
              <span class="text-muted">—</span>
            @endif
          </td>
          <td class="td-date">
            {{ $rsvp->created_at->format('M j, Y') }}<br>
            <small>{{ $rsvp->created_at->format('g:i A') }}</small>
          </td>
          <td>
            <form method="POST" action="{{ route('admin.rsvp.destroy', $rsvp) }}" onsubmit="return confirm('Delete this RSVP?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-icon btn-danger" title="Delete">✕</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="empty-state">No RSVPs yet.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">
    {{ $rsvps->links() }}
  </div>

  {{-- ── Guest Registry ───────────────────────────────── --}}
  <div class="section-title-row" style="margin-top: 2.5rem;">
    <h2 class="section-title">Guest Registry</h2>
    <button class="btn btn-primary" id="toggleAddGuest">+ Add Guest</button>
  </div>

  {{-- Add Guest Form --}}
  <div class="table-card" id="addGuestForm" style="display:none; margin-bottom:1rem;">
    <form method="POST" action="{{ route('admin.guests.store') }}"
          style="display:flex; gap:1rem; align-items:flex-end; flex-wrap:wrap; padding:0.25rem 0;">
      @csrf
      <div class="form-group" style="flex:2; min-width:200px; margin:0;">
        <label class="form-label">Guest Name</label>
        <input type="text" name="name" placeholder="Full name" required class="form-input">
      </div>
      <div class="form-group" style="flex:1; min-width:120px; margin:0;">
        <label class="form-label">Seats Allotted</label>
        <input type="number" name="seats_allotted" value="1" min="1" max="20" required class="form-input">
      </div>
      <button type="submit" class="btn btn-primary">Add to Registry</button>
    </form>
  </div>

  {{-- Guest Registry Table --}}
  <div class="table-card">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Seats Allotted</th>
          <th>RSVP Status</th>
          <th>Confirmed Names</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($guests as $i => $guest)

          {{-- View row --}}
          <tr id="guest-row-{{ $guest->id }}">
            <td class="td-num">{{ $i + 1 }}</td>
            <td><strong>{{ $guest->name }}</strong></td>
            <td class="td-center">{{ $guest->seats_allotted }}</td>
            <td>
              @if($guest->rsvp)
                <span class="badge badge-{{ $guest->rsvp->attending ? 'green' : 'red' }}">
                  {{ $guest->rsvp->attending ? 'Confirmed' : 'Declined' }}
                </span>
              @else
                <span class="badge badge-gray">Pending</span>
              @endif
            </td>
            <td class="td-guests">
              @if($guest->rsvp && $guest->rsvp->guest_names && count($guest->rsvp->guest_names))
                <ol class="guest-names-ol">
                  @foreach($guest->rsvp->guest_names as $name)
                    @if($name)<li>{{ $name }}</li>@endif
                  @endforeach
                </ol>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td class="td-actions">
              <button class="btn-icon btn-edit" onclick="showEditRow({{ $guest->id }})" title="Edit">✎</button>
              <form method="POST" action="{{ route('admin.guests.destroy', $guest) }}"
                    onsubmit="return confirm('Remove {{ addslashes($guest->name) }}?')" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon btn-danger" title="Remove">✕</button>
              </form>
            </td>
          </tr>

          {{-- Edit row --}}
          <tr id="guest-edit-{{ $guest->id }}" style="display:none; background:#fafaf8;">
            <td class="td-num">{{ $i + 1 }}</td>
            <td colspan="4">
              <form method="POST" action="{{ route('admin.guests.update', $guest) }}"
                    style="display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap; padding:0.25rem 0;">
                @csrf @method('PATCH')
                <input type="text" name="name" value="{{ $guest->name }}" required
                       class="form-input" style="flex:2; min-width:160px;">
                <input type="number" name="seats_allotted" value="{{ $guest->seats_allotted }}"
                       min="1" max="20" required class="form-input" style="flex:0 0 80px;">
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                <button type="button" class="btn btn-outline btn-sm" onclick="hideEditRow({{ $guest->id }})">Cancel</button>
              </form>
            </td>
            <td></td>
          </tr>

        @empty
        <tr>
          <td colspan="6" class="empty-state">No guests in registry yet. Add guests above so they can RSVP.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

@endsection

@push('styles')
<style>
  .rsvp-summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
  }
  .summary-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1.25rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }
  .summary-card--green { border-left: 4px solid #22c55e; }
  .summary-card--red   { border-left: 4px solid #ef4444; }
  .summary-card--gold  { border-left: 4px solid #C9A96E; }
  .summary-number { font-size: 2rem; font-weight: 700; line-height: 1; color: #111827; }
  .summary-label  { font-size: 0.8rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; }

  .rsvp-table th, .rsvp-table td { vertical-align: top; }
  .td-num    { color: #9ca3af; font-size: 0.85rem; width: 2rem; }
  .td-center { text-align: center; }
  .td-date   { font-size: 0.85rem; white-space: nowrap; }
  .td-date small { color: #9ca3af; }
  .td-guests { min-width: 160px; }
  .guest-names-ol { margin: 0; padding-left: 1.1rem; font-size: 0.85rem; color: #374151; line-height: 1.7; }
  .row-declined td { opacity: 0.6; }
  .message-preview { font-size: 0.85rem; color: #6b7280; font-style: italic; cursor: default; }
  .text-muted { color: #9ca3af; }

  .badge-gray { background: #f3f4f6; color: #6b7280; }

  .section-title-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
  .section-title { font-size: 1.1rem; font-weight: 600; color: #111827; margin: 0; }

  .alert-success {
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;
    padding: 0.75rem 1rem; border-radius: 6px; font-size: 0.9rem; margin-bottom: 1rem;
  }

  .td-actions { white-space: nowrap; display: flex; gap: 0.4rem; align-items: center; }
  .btn-edit {
    background: none; border: 1px solid #d1d5db; border-radius: 4px;
    padding: 0.2rem 0.45rem; cursor: pointer; color: #6b7280;
    font-size: 0.9rem; line-height: 1;
  }
  .btn-edit:hover { border-color: #C9A96E; color: #C9A96E; }
  .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.82rem; }

  @media (max-width: 768px) {
    .rsvp-summary-grid { grid-template-columns: repeat(2, 1fr); }
  }
</style>
@endpush

@push('scripts')
<script>
  // Add Guest toggle
  document.getElementById('toggleAddGuest').addEventListener('click', function () {
    const form = document.getElementById('addGuestForm');
    const open = form.style.display === 'none' || form.style.display === '';
    form.style.display  = open ? 'block' : 'none';
    this.textContent    = open ? '✕ Cancel' : '+ Add Guest';
  });

  // Inline edit
  function showEditRow(id) {
    document.getElementById('guest-row-'  + id).style.display = 'none';
    document.getElementById('guest-edit-' + id).style.display = '';
  }
  function hideEditRow(id) {
    document.getElementById('guest-edit-' + id).style.display = 'none';
    document.getElementById('guest-row-'  + id).style.display = '';
  }
</script>
@endpush
