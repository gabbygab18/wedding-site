@extends('layouts.admin')
@section('title', 'Entourage')
@section('page-title', 'Wedding Entourage')

@section('content')
<div class="two-col-layout">
  <div class="col-main">
    <div class="table-card">
      <table class="data-table">
        <thead>
          <tr><th>Name</th><th>Role</th><th>Side</th><th></th></tr>
        </thead>
        <tbody>
          @forelse($entourage as $member)
          <tr>
            <td>{{ $member->name }}</td>
            <td>{{ $member->role }}</td>
            <td>{{ $member->side ?? '—' }}</td>
            <td>
              <form method="POST" action="{{ route('admin.entourage.destroy', $member) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon btn-danger" onclick="return confirm('Remove?')">✕</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="empty-state">No entourage members yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-side">
    <div class="form-card">
      <h3>Add Member</h3>
      <form method="POST" action="{{ route('admin.entourage.store') }}" class="admin-form">
        @csrf
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="name" required placeholder="e.g. Maria Santos">
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role">
            <option>Best Man</option>
            <option>Maid of Honor</option>
            <option>Groomsman</option>
            <option>Bridesmaid</option>
            <option>Flower Girl</option>
            <option>Ring Bearer</option>
            <option>Principal Sponsor</option>
            <option>Secondary Sponsor</option>
            <option>Parent of the Bride</option>
            <option>Parent of the Groom</option>
          </select>
        </div>
        <div class="form-group">
          <label>Side</label>
          <select name="side">
            <option value="">—</option>
            <option value="Bride">Bride's Side</option>
            <option value="Groom">Groom's Side</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Member</button>
      </form>
    </div>
  </div>
</div>
@endsection
