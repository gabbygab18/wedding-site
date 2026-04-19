@extends('layouts.admin')
@section('title', 'Photos')
@section('page-title', 'Wedding Photos')

@section('content')
<div class="upload-area" id="uploadArea">
  <form method="POST" action="{{ route('admin.photos.store') }}" enctype="multipart/form-data" id="uploadForm">
    @csrf
    <div class="dropzone" id="dropzone">
      <span class="drop-icon">⊡</span>
      <p>Drag & drop photos here, or <label for="photoInput" class="link-label">browse</label></p>
      <input type="file" id="photoInput" name="photos[]" multiple accept="image/*" class="hidden-input">
      <p class="drop-hint">JPG, PNG up to 5MB each</p>
    </div>
    <button type="submit" class="btn btn-primary" id="uploadBtn" style="display:none;">Upload Photos</button>
  </form>
</div>

<div class="photos-grid" id="photosGrid">
  @forelse($photos as $photo)
  <div class="photo-item" data-id="{{ $photo->id }}">
    <img src="{{ Storage::url($photo->path) }}" alt="Photo">
    <div class="photo-overlay">
      <form method="POST" action="{{ route('admin.photos.destroy', $photo) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn-icon btn-danger" onclick="return confirm('Delete?')">✕</button>
      </form>
    </div>
    <div class="photo-order">
      <input type="number" class="order-input" value="{{ $photo->sort_order }}" min="1"
             data-id="{{ $photo->id }}" title="Sort order">
    </div>
  </div>
  @empty
  <p class="empty-state">No photos uploaded yet.</p>
  @endforelse
</div>
@endsection

@push('scripts')
<script>
const dropzone = document.getElementById('dropzone');
const photoInput = document.getElementById('photoInput');
const uploadBtn = document.getElementById('uploadBtn');

dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('drag-over'); });
dropzone.addEventListener('dragleave', () => dropzone.classList.remove('drag-over'));
dropzone.addEventListener('drop', e => {
  e.preventDefault();
  dropzone.classList.remove('drag-over');
  const dt = new DataTransfer();
  [...e.dataTransfer.files].forEach(f => dt.items.add(f));
  photoInput.files = dt.files;
  uploadBtn.style.display = 'block';
  uploadBtn.textContent = `Upload ${photoInput.files.length} photo(s)`;
});
photoInput.addEventListener('change', () => {
  if (photoInput.files.length) {
    uploadBtn.style.display = 'block';
    uploadBtn.textContent = `Upload ${photoInput.files.length} photo(s)`;
  }
});
</script>
@endpush
