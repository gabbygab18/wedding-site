@extends('layouts.admin')

@section('title', 'Wedding Details')
@section('page-title', 'Wedding Details')

@section('content')
<form
  class="admin-form"
  method="POST"
  action="{{ route('admin.wedding.update') }}"
  enctype="multipart/form-data"
>
  @csrf
  @method('PUT')

  {{-- ── Couple Info ────────────────────────── --}}
  <div class="form-section">
    <h3>Couple Information</h3>
    <div class="form-row">
      <div class="form-group">
        <label>Bride's Name</label>
        <input type="text" name="bride_name" value="{{ old('bride_name', $wedding->bride_name) }}" required>
      </div>
      <div class="form-group">
        <label>Groom's Name</label>
        <input type="text" name="groom_name" value="{{ old('groom_name', $wedding->groom_name) }}" required>
      </div>
    </div>
    <div class="form-group">
      <label>Wedding Hashtag</label>
      <div class="input-prefix">
        <span>#</span>
        <input type="text" name="hashtag" value="{{ old('hashtag', $wedding->hashtag) }}" placeholder="YourWeddingHashtag">
      </div>
    </div>
  </div>

  {{-- ── Date & Venue ───────────────────────── --}}
  <div class="form-section">
    <h3>Date & Venue</h3>
    <div class="form-row">
      <div class="form-group">
        <label>Wedding Date</label>
        <input type="date" name="wedding_date" value="{{ old('wedding_date', $wedding->wedding_date?->format('Y-m-d')) }}" required>
      </div>
      <div class="form-group">
        <label>Ceremony Time</label>
        <input type="time" name="ceremony_time" value="{{ old('ceremony_time', $wedding->ceremony_time) }}" required>
      </div>
      <div class="form-group">
        <label>Reception Time</label>
        <input type="time" name="reception_time" value="{{ old('reception_time', $wedding->reception_time) }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Venue Name</label>
        <input type="text" name="venue_name" value="{{ old('venue_name', $wedding->venue_name) }}" required>
      </div>
      <div class="form-group">
        <label>Reception Venue <span style="color:#9A9188;">(if different)</span></label>
        <input type="text" name="reception_venue" value="{{ old('reception_venue', $wedding->reception_venue) }}">
      </div>
    </div>
    <div class="form-group">
      <label>Venue Address</label>
      <input type="text" name="venue_address" value="{{ old('venue_address', $wedding->venue_address) }}" required>
    </div>
  </div>

  {{-- ── Map ──────────────────────────────────── --}}
  <div class="form-section">
    <h3>📍 Venue Map</h3>
    <p class="form-help">Paste a Google Maps embed URL or full iframe code.</p>

    <div class="form-group" style="margin-top:12px;">
      <label>Google Maps Embed</label>
      <textarea name="map_embed_url" rows="3" placeholder='Paste <iframe ...> code from Google Maps → Share → Embed a map, or paste just the src URL'>{{ old('map_embed_url', $wedding->map_embed_url) }}</textarea>
      <span class="form-hint">
        Go to <strong>Google Maps</strong> → search your venue → click <strong>Share</strong> → <strong>Embed a map</strong> → copy the iframe code.
      </span>
    </div>

    {{-- Live map preview --}}
    @if($wedding->map_embed_url)
    <div class="media-preview map-preview-admin">
      <p class="preview-label">Current Map Preview</p>
      <div class="map-iframe-wrap">
        {!! $wedding->map_embed_url !!}
      </div>
      <a
        href="https://www.google.com/maps/search/?api=1&query={{ urlencode($wedding->venue_address) }}"
        target="_blank"
        rel="noopener"
        class="btn btn-outline" style="margin-top:8px; font-size:0.75rem;"
      >Open in Google Maps ↗</a>
    </div>
    @endif
  </div>

  {{-- ── Hero Video ───────────────────────────── --}}
  <div class="form-section">
    <h3>🎬 Hero Video</h3>
    <p class="form-help">Displayed fullscreen at the top of the invitation after opening the envelope. Recommended: short clip (15–60s), MP4, under 100MB.</p>

    @if($wedding->hero_video)
    <div class="media-preview">
      <p class="preview-label">Current Video</p>
      <video
        src="{{ Storage::url($wedding->hero_video) }}"
        controls
        muted
        class="media-preview-video"
      ></video>
      <label class="remove-media-label">
        <input type="checkbox" name="remove_video" value="1">
        Remove this video
      </label>
    </div>
    @endif

    <div class="form-group" style="margin-top: {{ $wedding->hero_video ? '12px' : '0' }}">
      <label>{{ $wedding->hero_video ? 'Replace Video' : 'Upload Video' }}</label>
      <div class="file-upload-area" id="videoUploadArea">
        <input
          type="file"
          name="hero_video"
          id="heroVideoInput"
          accept="video/mp4,video/webm,video/quicktime"
          class="hidden-file-input"
        >
        <div class="file-upload-inner" onclick="document.getElementById('heroVideoInput').click()">
          <span class="upload-icon">🎬</span>
          <p>Click to upload or drag & drop</p>
          <span class="upload-hint">MP4, WebM, MOV — max 100MB</span>
        </div>
        <div class="file-selected-name" id="videoFileName" style="display:none;"></div>
      </div>
    </div>
  </div>

  {{-- ── Background Music ─────────────────────── --}}
  <div class="form-section">
    <h3>🎵 Background Music</h3>
    <p class="form-help">Plays softly in the background when guests open the invitation. A floating player lets them pause/play.</p>

    @if($wedding->background_music)
    <div class="media-preview">
      <p class="preview-label">Current Audio</p>
      <audio
        src="{{ Storage::url($wedding->background_music) }}"
        controls
        class="media-preview-audio"
      ></audio>
      <label class="remove-media-label">
        <input type="checkbox" name="remove_music" value="1">
        Remove this audio
      </label>
    </div>
    @endif

    <div class="form-group" style="margin-top: {{ $wedding->background_music ? '12px' : '0' }}">
      <label>{{ $wedding->background_music ? 'Replace Audio' : 'Upload Audio' }}</label>
      <div class="file-upload-area" id="audioUploadArea">
        <input
          type="file"
          name="background_music"
          id="bgMusicInput"
          accept="audio/mpeg,audio/ogg,audio/wav,audio/mp4"
          class="hidden-file-input"
        >
        <div class="file-upload-inner" onclick="document.getElementById('bgMusicInput').click()">
          <span class="upload-icon">🎵</span>
          <p>Click to upload or drag & drop</p>
          <span class="upload-hint">MP3, OGG, WAV, M4A — max 20MB</span>
        </div>
        <div class="file-selected-name" id="audioFileName" style="display:none;"></div>
      </div>
    </div>
  </div>

  {{-- ── Love Story ───────────────────────────── --}}
  <div class="form-section">
    <h3>Love Story</h3>
    <div class="form-group">
      <label>Your Story</label>
      <textarea name="love_story" rows="6" placeholder="How did you meet? Tell your story...">{{ old('love_story', $wedding->love_story) }}</textarea>
    </div>
  </div>

  {{-- ── RSVP Settings ────────────────────────── --}}
  <div class="form-section">
    <h3>RSVP Settings</h3>
    <div class="form-group">
      <label class="toggle-label">
        <input type="checkbox" name="rsvp_enabled" value="1" {{ $wedding->rsvp_enabled ? 'checked' : '' }}>
        <span class="toggle-switch"></span>
        Enable RSVP form on invitation
      </label>
    </div>
    <div class="form-group">
      <label>RSVP Deadline</label>
      <input type="date" name="rsvp_deadline" value="{{ old('rsvp_deadline', $wedding->rsvp_deadline?->format('Y-m-d')) }}">
    </div>
  </div>

  <div class="form-actions" style="padding-bottom:40px;">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Cancel</a>
    <button type="submit" class="btn btn-primary">Save Changes</button>
  </div>
</form>
@endsection

@push('scripts')
<script>
  // Show filename when file is selected
  function bindFileInput(inputId, nameDisplayId, areaId) {
    const input   = document.getElementById(inputId);
    const display = document.getElementById(nameDisplayId);
    const area    = document.getElementById(areaId);

    if (!input) return;

    input.addEventListener('change', () => {
      const file = input.files[0];
      if (file) {
        display.textContent = `✓ Selected: ${file.name} (${(file.size / 1024 / 1024).toFixed(1)} MB)`;
        display.style.display = 'block';
        area.classList.add('has-file');
      }
    });

    // Drag & drop
    const inner = area.querySelector('.file-upload-inner');
    ['dragenter','dragover'].forEach(evt =>
      area.addEventListener(evt, e => { e.preventDefault(); area.classList.add('drag-over'); })
    );
    ['dragleave','drop'].forEach(evt =>
      area.addEventListener(evt, e => { e.preventDefault(); area.classList.remove('drag-over'); })
    );
    area.addEventListener('drop', e => {
      const file = e.dataTransfer.files[0];
      if (file) {
        // Create a DataTransfer to assign to input
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        input.dispatchEvent(new Event('change'));
      }
    });
  }

  bindFileInput('heroVideoInput', 'videoFileName', 'videoUploadArea');
  bindFileInput('bgMusicInput',   'audioFileName', 'audioUploadArea');
</script>
@endpush
