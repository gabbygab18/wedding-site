@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

@php
    $daysToGo = now()->startOfDay()
        ->diffInDays(
            \Carbon\Carbon::parse($wedding->wedding_date)->startOfDay(),
            false
        );
@endphp

<div class="dashboard-stats">
  <div class="stat-card">
    <div class="stat-icon">✉</div>
    <div class="stat-body">
      <span class="stat-value">{{ $totalRsvp }}</span>
      <span class="stat-label">Total RSVPs</span>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">✓</div>
    <div class="stat-body">
      <span class="stat-value">{{ $attending }}</span>
      <span class="stat-label">Attending</span>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">✗</div>
    <div class="stat-body">
      <span class="stat-value">{{ $notAttending }}</span>
      <span class="stat-label">Not Attending</span>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">♡</div>
    <div class="stat-body">
      <span class="stat-value">{{ $totalGuests }}</span>
      <span class="stat-label">Total Guests</span>
    </div>
  </div>
</div>

<div class="dashboard-grid">
  <div class="dash-card">
    <h3>Wedding Details</h3>
    <div class="wedding-summary">
      <p><strong>Couple:</strong> {{ $wedding->bride_name }} & {{ $wedding->groom_name }}</p>
      <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($wedding->wedding_date)->format('F j, Y') }}</p>
      <p><strong>Venue:</strong> {{ $wedding->venue_name }}</p>
      <p><strong>Days to go:</strong>
        @if($daysToGo > 0)
          {{ $daysToGo }}
        @elseif($daysToGo === 0)
          Today 🎉
        @else
          The big day has passed
        @endif
      </p>
    </div>
    <a href="{{ route('admin.wedding.edit') }}" class="btn btn-primary">Edit Details</a>
  </div>

  <div class="dash-card">
    <h3>Recent RSVPs</h3>
    @if($recentRsvps->count())
    <table class="mini-table">
      <thead><tr><th>Name</th><th>Status</th><th>Guests</th></tr></thead>
      <tbody>
        @foreach($recentRsvps as $rsvp)
        <tr>
          <td>{{ $rsvp->guest_name }}</td>
          <td><span class="badge badge-{{ $rsvp->attending ? 'green' : 'red' }}">{{ $rsvp->attending ? 'Attending' : 'Declined' }}</span></td>
          <td>{{ $rsvp->guests_count }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="empty-state">No RSVPs yet.</p>
    @endif
    <a href="{{ route('admin.rsvp.index') }}" class="btn btn-outline">View All →</a>
  </div>
</div>

@endsection
