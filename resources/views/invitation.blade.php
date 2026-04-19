@extends('layouts.app')

@section('title', $wedding->bride_name . ' & ' . $wedding->groom_name . ' — Wedding Invitation')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     GLOBAL SVG DEFS — filters, textures, gradients, patterns
     ═══════════════════════════════════════════════════════ --}}
<svg class="svg-defs" aria-hidden="true" focusable="false" style="position:absolute;width:0;height:0;overflow:hidden;">
  <defs>

    {{-- Paper grain filter --}}
    <filter id="paperGrain" x="0%" y="0%" width="100%" height="100%">
      <feTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="3" stitchTiles="stitch" result="noise"/>
      <feColorMatrix type="saturate" values="0" in="noise" result="grayNoise"/>
      <feBlend in="SourceGraphic" in2="grayNoise" mode="multiply" result="blended"/>
      <feComponentTransfer in="blended">
        <feFuncA type="linear" slope="1"/>
      </feComponentTransfer>
    </filter>

    {{-- Gold shimmer gradient --}}
    <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%"   stop-color="#A07840"/>
      <stop offset="30%"  stop-color="#E4C47A"/>
      <stop offset="50%"  stop-color="#F5E0A0"/>
      <stop offset="70%"  stop-color="#E4C47A"/>
      <stop offset="100%" stop-color="#A07840"/>
    </linearGradient>

    {{-- Linen texture pattern --}}
    <pattern id="linenPattern" x="0" y="0" width="4" height="4" patternUnits="userSpaceOnUse">
      <rect width="4" height="4" fill="#FAF6F0"/>
      <line x1="0" y1="0" x2="4" y2="0" stroke="#E8DDD0" stroke-width="0.3" opacity="0.6"/>
      <line x1="0" y1="2" x2="4" y2="2" stroke="#E8DDD0" stroke-width="0.2" opacity="0.4"/>
      <line x1="0" y1="0" x2="0" y2="4" stroke="#E8DDD0" stroke-width="0.3" opacity="0.5"/>
      <line x1="2" y1="0" x2="2" y2="4" stroke="#E8DDD0" stroke-width="0.2" opacity="0.3"/>
    </pattern>

    {{-- Watercolor wash gradient --}}
    <radialGradient id="watercolorWash" cx="50%" cy="50%" r="70%">
      <stop offset="0%"   stop-color="#FDF0E8" stop-opacity="0.9"/>
      <stop offset="60%"  stop-color="#F8E8E0" stop-opacity="0.6"/>
      <stop offset="100%" stop-color="#F0D8D0" stop-opacity="0.3"/>
    </radialGradient>

    {{-- Section blush wash --}}
    <radialGradient id="blushWash" cx="50%" cy="30%" r="60%">
      <stop offset="0%"   stop-color="#FDEDF0" stop-opacity="0.8"/>
      <stop offset="100%" stop-color="#F5E0E8" stop-opacity="0"/>
    </radialGradient>

    {{-- Wax seal radial --}}
    <radialGradient id="waxGrad" cx="35%" cy="30%" r="65%">
      <stop offset="0%"   stop-color="#C04050"/>
      <stop offset="60%"  stop-color="#8B2635"/>
      <stop offset="100%" stop-color="#5A1020"/>
    </radialGradient>

  </defs>
</svg>

<div class="invitation-wrapper" id="invitationWrapper">

  {{-- ── Layered background textures ───────────────────── --}}
  <div class="bg-texture-layer bg-linen"    aria-hidden="true"></div>
  <div class="bg-texture-layer bg-grain"    aria-hidden="true"></div>
  <div class="bg-texture-layer bg-vignette" aria-hidden="true"></div>

  {{-- ── Floating botanical corner vectors ─────────────── --}}
  <div class="corner-vector corner-tl" aria-hidden="true">
    <svg viewBox="0 0 180 180" xmlns="http://www.w3.org/2000/svg">
      <path d="M10,170 C30,120 60,80 100,40" stroke="#C9A96E" stroke-width="1.2" fill="none" opacity="0.55"/>
      <path d="M40,130 C55,115 75,108 95,105" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.45"/>
      <path d="M65,100 C80,85 100,78 118,70" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.45"/>
      <ellipse cx="95" cy="105" rx="10" ry="5"   fill="#B8C9A0" opacity="0.45" transform="rotate(-30 95 105)"/>
      <ellipse cx="118" cy="70" rx="9"  ry="4"   fill="#B8C9A0" opacity="0.4"  transform="rotate(-55 118 70)"/>
      <ellipse cx="100" cy="40" rx="8"  ry="4"   fill="#B8C9A0" opacity="0.4"  transform="rotate(-70 100 40)"/>
      <ellipse cx="55"  cy="118" rx="7" ry="3"   fill="#B8C9A0" opacity="0.35" transform="rotate(-20 55 118)"/>
      <ellipse cx="78"  cy="90"  rx="8" ry="3.5" fill="#B8C9A0" opacity="0.4"  transform="rotate(-45 78 90)"/>
      <circle cx="100" cy="40" r="5.5" fill="#D4A0A8" opacity="0.55"/>
      <circle cx="100" cy="40" r="3"   fill="#C88898" opacity="0.65"/>
      <circle cx="95"  cy="105" r="4"  fill="#D4A0A8" opacity="0.45"/>
      <circle cx="30"  cy="148" r="1.5" fill="#C9A96E" opacity="0.4"/>
      <circle cx="50"  cy="128" r="1"   fill="#C9A96E" opacity="0.35"/>
      <circle cx="70"  cy="102" r="1.2" fill="#C9A96E" opacity="0.3"/>
    </svg>
  </div>

  <div class="corner-vector corner-tr" aria-hidden="true">
    <svg viewBox="0 0 180 180" xmlns="http://www.w3.org/2000/svg" style="transform:scaleX(-1)">
      <path d="M10,170 C30,120 60,80 100,40" stroke="#C9A96E" stroke-width="1.2" fill="none" opacity="0.55"/>
      <path d="M40,130 C55,115 75,108 95,105" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.45"/>
      <path d="M65,100 C80,85 100,78 118,70" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.45"/>
      <ellipse cx="95" cy="105" rx="10" ry="5"   fill="#B8C9A0" opacity="0.45" transform="rotate(-30 95 105)"/>
      <ellipse cx="118" cy="70" rx="9"  ry="4"   fill="#B8C9A0" opacity="0.4"  transform="rotate(-55 118 70)"/>
      <ellipse cx="100" cy="40" rx="8"  ry="4"   fill="#B8C9A0" opacity="0.4"  transform="rotate(-70 100 40)"/>
      <ellipse cx="55"  cy="118" rx="7" ry="3"   fill="#B8C9A0" opacity="0.35" transform="rotate(-20 55 118)"/>
      <ellipse cx="78"  cy="90"  rx="8" ry="3.5" fill="#B8C9A0" opacity="0.4"  transform="rotate(-45 78 90)"/>
      <circle cx="100" cy="40" r="5.5" fill="#D4A0A8" opacity="0.55"/>
      <circle cx="100" cy="40" r="3"   fill="#C88898" opacity="0.65"/>
      <circle cx="95"  cy="105" r="4"  fill="#D4A0A8" opacity="0.45"/>
      <circle cx="30"  cy="148" r="1.5" fill="#C9A96E" opacity="0.4"/>
      <circle cx="50"  cy="128" r="1"   fill="#C9A96E" opacity="0.35"/>
      <circle cx="70"  cy="102" r="1.2" fill="#C9A96E" opacity="0.3"/>
    </svg>
  </div>

  {{-- Floating petals background --}}
  <div class="petals-container" id="petalsContainer"></div>

  {{-- Background Music Player --}}
  @if($wedding->background_music)
  <div class="bg-audio-bar" id="audioBar">
    <span class="audio-note">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M9 3v10.55A4 4 0 1 0 11 17V7h4V3H9Z"/>
      </svg>
    </span>
    <span class="audio-label">Wedding Melody</span>
    <button class="audio-toggle" id="audioToggle" aria-label="Toggle music">
      <svg id="audioIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M8 5v14l11-7L8 5Z"/>
      </svg>
    </button>
    <audio id="bgAudio" loop preload="none">
      <source src="{{ Storage::url($wedding->background_music) }}" type="audio/mpeg">
    </audio>
  </div>
  @endif

  {{-- ══════════════════════════════════════
       ENVELOPE SCENE
       ══════════════════════════════════════ --}}
  <section class="envelope-scene" id="envelopeScene">

    {{-- Scene watercolor wash --}}
    <svg class="scene-wash" viewBox="0 0 800 600" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <rect width="800" height="600" fill="url(#watercolorWash)"/>
      <ellipse cx="400" cy="300" rx="380" ry="280" fill="#F8EDE4" opacity="0.3"/>
      <ellipse cx="400" cy="300" rx="280" ry="180" fill="#F5E4D8" opacity="0.2"/>
    </svg>

    {{-- Scattered botanical sprigs --}}
    <svg class="scene-botanicals" viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice">
      <path d="M120,400 C140,360 160,330 175,300" stroke="#B8C9A0" stroke-width="1" fill="none" opacity="0.5"/>
      <ellipse cx="155" cy="340" rx="14" ry="6" fill="#B8C9A0" opacity="0.4" transform="rotate(-40 155 340)"/>
      <ellipse cx="175" cy="300" rx="12" ry="5" fill="#C9D4B0" opacity="0.35" transform="rotate(-60 175 300)"/>
      <circle  cx="175" cy="300" r="6"          fill="#D4A0A8" opacity="0.5"/>
      <circle  cx="175" cy="300" r="3.5"        fill="#C88898" opacity="0.6"/>
      <path d="M680,400 C660,360 640,330 625,300" stroke="#B8C9A0" stroke-width="1" fill="none" opacity="0.5"/>
      <ellipse cx="645" cy="340" rx="14" ry="6" fill="#B8C9A0" opacity="0.4" transform="rotate(40 645 340)"/>
      <ellipse cx="625" cy="300" rx="12" ry="5" fill="#C9D4B0" opacity="0.35" transform="rotate(60 625 300)"/>
      <circle  cx="625" cy="300" r="6"          fill="#D4A0A8" opacity="0.5"/>
      <circle  cx="625" cy="300" r="3.5"        fill="#C88898" opacity="0.6"/>
      <circle cx="200" cy="100" r="2"   fill="#C9A96E" opacity="0.3"/>
      <circle cx="220" cy="80"  r="1.5" fill="#C9A96E" opacity="0.25"/>
      <circle cx="590" cy="100" r="2"   fill="#C9A96E" opacity="0.3"/>
      <circle cx="570" cy="80"  r="1.5" fill="#C9A96E" opacity="0.25"/>
    </svg>

    <div class="scene-label">
      <span>You have received a special invitation</span>
    </div>

    <div class="envelope-container" id="envelopeContainer">
      {{-- Wax seal --}}
      <div class="wax-seal" id="waxSeal">
        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="38" fill="url(#waxGrad)" stroke="#5A1020" stroke-width="1.5"/>
          <path d="M20,25 Q40,20 60,25" stroke="#C04050" stroke-width="0.8" fill="none" opacity="0.4"/>
          <path d="M15,40 Q40,35 65,40" stroke="#C04050" stroke-width="0.6" fill="none" opacity="0.3"/>
          <circle cx="40" cy="40" r="30" fill="none" stroke="#C4535F" stroke-width="0.8" stroke-dasharray="2 3" opacity="0.6"/>
          <circle cx="40" cy="40" r="26" fill="none" stroke="#C4535F" stroke-width="0.4" opacity="0.3"/>
          <text x="40" y="35" text-anchor="middle" fill="#F9E8D0" font-family="Georgia, serif" font-size="11" font-style="italic">{{ substr($wedding->bride_name, 0, 1) }}</text>
          <text x="40" y="50" text-anchor="middle" fill="#F9E8D0" font-family="Georgia, serif" font-size="10" font-style="italic">&amp;</text>
          <text x="40" y="65" text-anchor="middle" fill="#F9E8D0" font-family="Georgia, serif" font-size="11" font-style="italic">{{ substr($wedding->groom_name, 0, 1) }}</text>
          <ellipse cx="28" cy="26" rx="7" ry="4" fill="white" opacity="0.12" transform="rotate(-20 28 26)"/>
        </svg>
      </div>

      {{-- The envelope --}}
      <div class="envelope" id="envelope">
        <div class="envelope-back"></div>
        <div class="envelope-flap" id="envelopeFlap"></div>
        <div class="envelope-front">
          {{-- Envelope linen texture overlay --}}
          <svg class="envelope-texture" viewBox="0 0 400 260" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <rect width="400" height="260" fill="url(#linenPattern)" opacity="0.5"/>
            <path d="M10,10 L10,35 M10,10 L35,10 M10,10 Q25,25 40,40" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.5"/>
            <circle cx="10" cy="10" r="2" fill="#C9A96E" opacity="0.5"/>
            <path d="M390,10 L390,35 M390,10 L365,10 M390,10 Q375,25 360,40" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.5"/>
            <circle cx="390" cy="10" r="2" fill="#C9A96E" opacity="0.5"/>
            <path d="M10,250 L10,225 M10,250 L35,250 M10,250 Q25,235 40,220" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.5"/>
            <circle cx="10" cy="250" r="2" fill="#C9A96E" opacity="0.5"/>
            <path d="M390,250 L390,225 M390,250 L365,250 M390,250 Q375,235 360,220" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.5"/>
            <circle cx="390" cy="250" r="2" fill="#C9A96E" opacity="0.5"/>
          </svg>
          <div class="envelope-address">
            <p class="to-line">To</p>
            <p class="guest-name">
              @if(isset($guestName))
                {{ $guestName }}
              @else
                Beloved Guest
              @endif
            </p>
          </div>
        </div>
        <div class="envelope-left-fold"></div>
        <div class="envelope-right-fold"></div>
        <div class="envelope-bottom-fold"></div>

        {{-- The letter inside --}}
        <div class="letter" id="letter">
          <div class="letter-inner">

            {{-- Letter paper texture --}}
            <svg class="letter-texture" viewBox="0 0 340 480" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect width="340" height="480" fill="url(#linenPattern)" opacity="0.5"/>
              <rect width="340" height="480" fill="url(#watercolorWash)" opacity="0.4"/>
            </svg>

            {{-- Letter top border --}}
            <svg class="letter-border-svg letter-border-top" viewBox="0 0 340 40" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <line x1="20" y1="20" x2="140" y2="20" stroke="#C9A96E" stroke-width="0.6" opacity="0.6"/>
              <line x1="200" y1="20" x2="320" y2="20" stroke="#C9A96E" stroke-width="0.6" opacity="0.6"/>
              <circle cx="170" cy="20" r="7" fill="none" stroke="#C9A96E" stroke-width="0.7" opacity="0.6"/>
              <circle cx="170" cy="20" r="3" fill="#C9A96E" opacity="0.4"/>
              <path d="M163,20 L158,15 M163,20 L158,25 M177,20 L182,15 M177,20 L182,25 M170,13 L165,8 M170,13 L175,8 M170,27 L165,32 M170,27 L175,32" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
              <path d="M30,20 L35,15 L40,20 L35,25 Z"   fill="none" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
              <path d="M300,20 L305,15 L310,20 L305,25 Z" fill="none" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            </svg>

            <div class="letter-ornament">✦</div>
            <p class="letter-pre">Together with their families</p>
            <h1 class="couple-names">
              <span class="bride-name">{{ $wedding->bride_name }}</span>
              <span class="ampersand">&</span>
              <span class="groom-name">{{ $wedding->groom_name }}</span>
            </h1>
            <p class="letter-invite-text">joyfully request the honor of your presence<br>at the celebration of their marriage</p>

            {{-- Floral divider --}}
            <div class="vector-divider" aria-hidden="true">
              <svg viewBox="0 0 280 32" xmlns="http://www.w3.org/2000/svg">
                <line x1="0"   y1="16" x2="90"  y2="16" stroke="#C9A96E" stroke-width="0.7" opacity="0.6"/>
                <line x1="190" y1="16" x2="280" y2="16" stroke="#C9A96E" stroke-width="0.7" opacity="0.6"/>
                <circle cx="140" cy="16" r="6"   fill="#D4A0A8" opacity="0.6"/>
                <circle cx="140" cy="16" r="3.5" fill="#C88898" opacity="0.7"/>
                <circle cx="140" cy="16" r="1.5" fill="#A06878" opacity="0.8"/>
                <ellipse cx="140" cy="8"  rx="3" ry="4" fill="#D4A0A8" opacity="0.4"/>
                <ellipse cx="148" cy="12" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(60 148 12)"/>
                <ellipse cx="148" cy="20" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(120 148 20)"/>
                <ellipse cx="140" cy="24" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(180 140 24)"/>
                <ellipse cx="132" cy="20" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(240 132 20)"/>
                <ellipse cx="132" cy="12" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(300 132 12)"/>
                <ellipse cx="108" cy="16" rx="10" ry="4" fill="#B8C9A0" opacity="0.45" transform="rotate(-10 108 16)"/>
                <ellipse cx="172" cy="16" rx="10" ry="4" fill="#B8C9A0" opacity="0.45" transform="rotate(10 172 16)"/>
                <circle cx="95"  cy="16" r="1.5" fill="#C9A96E" opacity="0.5"/>
                <circle cx="185" cy="16" r="1.5" fill="#C9A96E" opacity="0.5"/>
              </svg>
            </div>

            <div class="letter-details">
              <p class="detail-date">{{ \Carbon\Carbon::parse($wedding->wedding_date)->format('l, F j, Y') }}</p>
              <p class="detail-time">{{ \Carbon\Carbon::parse($wedding->ceremony_time)->format('g:i A') }}</p>
              <p class="detail-venue">{{ $wedding->venue_name }}</p>
              <p class="detail-address">{{ $wedding->venue_address }}</p>
            </div>

            {{-- Floral divider (repeat) --}}
            <div class="vector-divider" aria-hidden="true">
              <svg viewBox="0 0 280 32" xmlns="http://www.w3.org/2000/svg">
                <line x1="0"   y1="16" x2="90"  y2="16" stroke="#C9A96E" stroke-width="0.7" opacity="0.6"/>
                <line x1="190" y1="16" x2="280" y2="16" stroke="#C9A96E" stroke-width="0.7" opacity="0.6"/>
                <circle cx="140" cy="16" r="6"   fill="#D4A0A8" opacity="0.6"/>
                <circle cx="140" cy="16" r="3.5" fill="#C88898" opacity="0.7"/>
                <circle cx="140" cy="16" r="1.5" fill="#A06878" opacity="0.8"/>
                <ellipse cx="140" cy="8"  rx="3" ry="4" fill="#D4A0A8" opacity="0.4"/>
                <ellipse cx="148" cy="12" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(60 148 12)"/>
                <ellipse cx="148" cy="20" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(120 148 20)"/>
                <ellipse cx="140" cy="24" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(180 140 24)"/>
                <ellipse cx="132" cy="20" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(240 132 20)"/>
                <ellipse cx="132" cy="12" rx="3" ry="4" fill="#D4A0A8" opacity="0.4" transform="rotate(300 132 12)"/>
                <ellipse cx="108" cy="16" rx="10" ry="4" fill="#B8C9A0" opacity="0.45" transform="rotate(-10 108 16)"/>
                <ellipse cx="172" cy="16" rx="10" ry="4" fill="#B8C9A0" opacity="0.45" transform="rotate(10 172 16)"/>
                <circle cx="95"  cy="16" r="1.5" fill="#C9A96E" opacity="0.5"/>
                <circle cx="185" cy="16" r="1.5" fill="#C9A96E" opacity="0.5"/>
              </svg>
            </div>

            <p class="letter-rsvp-hint">Scroll to discover more ↓</p>

            {{-- Letter bottom border --}}
            <svg class="letter-border-svg letter-border-bottom" viewBox="0 0 340 40" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <line x1="20" y1="20" x2="140" y2="20" stroke="#C9A96E" stroke-width="0.6" opacity="0.6"/>
              <line x1="200" y1="20" x2="320" y2="20" stroke="#C9A96E" stroke-width="0.6" opacity="0.6"/>
              <circle cx="170" cy="20" r="7" fill="none" stroke="#C9A96E" stroke-width="0.7" opacity="0.6"/>
              <circle cx="170" cy="20" r="3" fill="#C9A96E" opacity="0.4"/>
              <path d="M163,20 L158,15 M163,20 L158,25 M177,20 L182,15 M177,20 L182,25 M170,13 L165,8 M170,13 L175,8 M170,27 L165,32 M170,27 L175,32" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
              <path d="M30,20 L35,15 L40,20 L35,25 Z"   fill="none" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
              <path d="M300,20 L305,15 L310,20 L305,25 Z" fill="none" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            </svg>

          </div>
        </div>
      </div>
    </div>

    <button class="open-btn" id="openBtn" aria-label="Open invitation">
      <span class="open-btn-text">Open Invitation</span>
      <span class="open-btn-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="2" y="4" width="20" height="16" rx="2"/>
          <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
        </svg>
      </span>
    </button>
  </section>

  {{-- ══════════════════════════════════════
       MAIN INVITATION CONTENT
       ══════════════════════════════════════ --}}
  <main class="invitation-content hidden" id="invitationContent">

    {{-- ── Hero ─────────────────────────────────────────── --}}
    @if($wedding->hero_video)
    <section class="hero-section hero-video-section" style="padding:0; position:relative; max-width:100%;">
      <div class="hero-video-wrapper">
        <video id="heroVideo" autoplay muted loop playsinline poster="" aria-label="Wedding video">
          <source src="{{ Storage::url($wedding->hero_video) }}" type="video/mp4">
        </video>
        <div class="hero-video-overlay">
          <div class="hero-ornament-top" style="margin-bottom:1.5rem;">
            <svg viewBox="0 0 500 70" xmlns="http://www.w3.org/2000/svg">
              <line x1="0"   y1="35" x2="170" y2="35" stroke="#C9A96E" stroke-width="0.6" opacity="0.7"/>
              <line x1="330" y1="35" x2="500" y2="35" stroke="#C9A96E" stroke-width="0.6" opacity="0.7"/>
              <path d="M250 8 L258 28 L278 28 L263 40 L268 60 L250 48 L232 60 L237 40 L222 28 L242 28 Z" fill="#C9A96E" opacity="0.8"/>
              <path d="M185,35 L190,30 L195,35 L190,40 Z" fill="#C9A96E" opacity="0.5"/>
              <path d="M305,35 L310,30 L315,35 L310,40 Z" fill="#C9A96E" opacity="0.5"/>
              <circle cx="155" cy="35" r="4" fill="#D4A0A8" opacity="0.5"/>
              <circle cx="155" cy="35" r="2" fill="#C88898" opacity="0.6"/>
              <circle cx="345" cy="35" r="4" fill="#D4A0A8" opacity="0.5"/>
              <circle cx="345" cy="35" r="2" fill="#C88898" opacity="0.6"/>
              <ellipse cx="130" cy="35" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(-15 130 35)"/>
              <ellipse cx="370" cy="35" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(15 370 35)"/>
            </svg>
          </div>
          <p class="hero-pre reveal-text" style="color:rgba(255,255,255,0.85);">Together with their families</p>
          <h1 class="hero-names reveal-text">
            <span class="hero-bride" style="color:#fff;">{{ $wedding->bride_name }}</span>
            <span class="hero-amp">&</span>
            <span class="hero-groom" style="color:#fff;">{{ $wedding->groom_name }}</span>
          </h1>
          <p class="hero-invite reveal-text" style="color:rgba(255,255,255,0.8);">request the honour of your presence<br>at the celebration of their wedding</p>
          <div class="hero-ornament-bottom" style="margin-top:1.5rem;">
            <svg viewBox="0 0 500 70" xmlns="http://www.w3.org/2000/svg">
              <line x1="0"   y1="35" x2="170" y2="35" stroke="#C9A96E" stroke-width="0.6" opacity="0.7"/>
              <line x1="330" y1="35" x2="500" y2="35" stroke="#C9A96E" stroke-width="0.6" opacity="0.7"/>
              <path d="M250 62 L258 42 L278 42 L263 30 L268 10 L250 22 L232 10 L237 30 L222 42 L242 42 Z" fill="#C9A96E" opacity="0.8"/>
              <path d="M185,35 L190,30 L195,35 L190,40 Z" fill="#C9A96E" opacity="0.5"/>
              <path d="M305,35 L310,30 L315,35 L310,40 Z" fill="#C9A96E" opacity="0.5"/>
              <circle cx="155" cy="35" r="4" fill="#D4A0A8" opacity="0.5"/>
              <circle cx="155" cy="35" r="2" fill="#C88898" opacity="0.6"/>
              <circle cx="345" cy="35" r="4" fill="#D4A0A8" opacity="0.5"/>
              <circle cx="345" cy="35" r="2" fill="#C88898" opacity="0.6"/>
              <ellipse cx="130" cy="35" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(-15 130 35)"/>
              <ellipse cx="370" cy="35" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(15 370 35)"/>
            </svg>
          </div>
          <button class="video-mute-btn" id="videoMuteBtn" aria-label="Toggle video sound">
            <svg id="muteIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/>
              <line x1="22" y1="9" x2="16" y2="15"/><line x1="16" y1="9" x2="22" y2="15"/>
            </svg>
          </button>
        </div>
      </div>
    </section>
    @else
    <section class="hero-section">
      <div class="hero-bg-texture" aria-hidden="true"></div>
      <svg class="hero-blush" viewBox="0 0 800 500" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <ellipse cx="400" cy="250" rx="400" ry="250" fill="url(#blushWash)"/>
      </svg>
      <div class="hero-ornament-top">
        <svg viewBox="0 0 500 70" xmlns="http://www.w3.org/2000/svg">
          <line x1="0"   y1="35" x2="170" y2="35" stroke="#C9A96E" stroke-width="0.6" opacity="0.6"/>
          <line x1="330" y1="35" x2="500" y2="35" stroke="#C9A96E" stroke-width="0.6" opacity="0.6"/>
          <path d="M250 8 L258 28 L278 28 L263 40 L268 60 L250 48 L232 60 L237 40 L222 28 L242 28 Z" fill="#C9A96E" opacity="0.7"/>
          <path d="M185,35 L190,30 L195,35 L190,40 Z" fill="#C9A96E" opacity="0.5"/>
          <path d="M305,35 L310,30 L315,35 L310,40 Z" fill="#C9A96E" opacity="0.5"/>
          <circle cx="155" cy="35" r="4" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="155" cy="35" r="2" fill="#C88898" opacity="0.6"/>
          <circle cx="345" cy="35" r="4" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="345" cy="35" r="2" fill="#C88898" opacity="0.6"/>
          <ellipse cx="130" cy="35" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(-15 130 35)"/>
          <ellipse cx="370" cy="35" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(15 370 35)"/>
        </svg>
      </div>
      <p class="hero-pre reveal-text">Together with their families</p>
      <h1 class="hero-names reveal-text">
        <span class="hero-bride">{{ $wedding->bride_name }}</span>
        <span class="hero-amp">&</span>
        <span class="hero-groom">{{ $wedding->groom_name }}</span>
      </h1>
      <p class="hero-invite reveal-text">request the honour of your presence<br>at the celebration of their wedding</p>
      <div class="hero-ornament-bottom">
        <svg viewBox="0 0 500 70" xmlns="http://www.w3.org/2000/svg">
          <line x1="0"   y1="35" x2="170" y2="35" stroke="#C9A96E" stroke-width="0.6" opacity="0.6"/>
          <line x1="330" y1="35" x2="500" y2="35" stroke="#C9A96E" stroke-width="0.6" opacity="0.6"/>
          <path d="M250 62 L258 42 L278 42 L263 30 L268 10 L250 22 L232 10 L237 30 L222 42 L242 42 Z" fill="#C9A96E" opacity="0.7"/>
          <path d="M185,35 L190,30 L195,35 L190,40 Z" fill="#C9A96E" opacity="0.5"/>
          <path d="M305,35 L310,30 L315,35 L310,40 Z" fill="#C9A96E" opacity="0.5"/>
          <circle cx="155" cy="35" r="4" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="155" cy="35" r="2" fill="#C88898" opacity="0.6"/>
          <circle cx="345" cy="35" r="4" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="345" cy="35" r="2" fill="#C88898" opacity="0.6"/>
          <ellipse cx="130" cy="35" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(-15 130 35)"/>
          <ellipse cx="370" cy="35" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(15 370 35)"/>
        </svg>
      </div>
    </section>
    @endif

    {{-- ── Vine divider ─────────────────────────────────── --}}
    <div class="section-vine-divider" aria-hidden="true">
      <svg viewBox="0 0 700 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
        <path d="M0,25 C80,15 160,35 240,25 C320,15 400,35 480,25 C560,15 640,35 700,25" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.45"/>
        <ellipse cx="240" cy="22" rx="9" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(-15 240 22)"/>
        <ellipse cx="480" cy="22" rx="9" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(15 480 22)"/>
        <circle  cx="350" cy="28" r="3"   fill="#D4A0A8" opacity="0.4"/>
        <circle  cx="350" cy="28" r="1.5" fill="#C88898" opacity="0.5"/>
      </svg>
    </div>

    {{-- ── Details ──────────────────────────────────────── --}}
    <section class="details-section reveal-section">
      <div class="section-texture-wash" aria-hidden="true"></div>
      <div class="details-grid">

        <div class="detail-card reveal-card">
          <svg class="card-filigree" viewBox="0 0 120 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <line x1="10" y1="10" x2="50"  y2="10" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <line x1="70" y1="10" x2="110" y2="10" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <circle cx="60" cy="10" r="3" fill="none" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <circle cx="60" cy="10" r="1" fill="#C9A96E" opacity="0.4"/>
          </svg>
          <div class="detail-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
          </div>
          <h3>Ceremony</h3>
          <p class="detail-main">{{ \Carbon\Carbon::parse($wedding->ceremony_time)->format('g:i A') }}</p>
          <p class="detail-sub">{{ \Carbon\Carbon::parse($wedding->wedding_date)->format('F j, Y') }}</p>
        </div>

        <div class="detail-card reveal-card">
          <svg class="card-filigree" viewBox="0 0 120 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <line x1="10" y1="10" x2="50"  y2="10" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <line x1="70" y1="10" x2="110" y2="10" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <circle cx="60" cy="10" r="3" fill="none" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <circle cx="60" cy="10" r="1" fill="#C9A96E" opacity="0.4"/>
          </svg>
          <div class="detail-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
          </div>
          <h3>Venue</h3>
          <p class="detail-main">{{ $wedding->venue_name }}</p>
          <p class="detail-sub">{{ $wedding->venue_address }}</p>
        </div>

        <div class="detail-card reveal-card">
          <svg class="card-filigree" viewBox="0 0 120 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <line x1="10" y1="10" x2="50"  y2="10" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <line x1="70" y1="10" x2="110" y2="10" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <circle cx="60" cy="10" r="3" fill="none" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <circle cx="60" cy="10" r="1" fill="#C9A96E" opacity="0.4"/>
          </svg>
          <div class="detail-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
          </div>
          <h3>Reception</h3>
          <p class="detail-main">{{ \Carbon\Carbon::parse($wedding->reception_time)->format('g:i A') }}</p>
          <p class="detail-sub">{{ $wedding->reception_venue ?? $wedding->venue_name }}</p>
        </div>

      </div>
    </section>

    {{-- ── Vine divider (inverted wave) ────────────────── --}}
    <div class="section-vine-divider" aria-hidden="true">
      <svg viewBox="0 0 700 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
        <path d="M0,25 C80,35 160,15 240,25 C320,35 400,15 480,25 C560,35 640,15 700,25" stroke="#C9A96E" stroke-width="0.8" fill="none" opacity="0.45"/>
        <ellipse cx="240" cy="28" rx="9" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(15 240 28)"/>
        <ellipse cx="480" cy="28" rx="9" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(-15 480 28)"/>
        <circle  cx="350" cy="22" r="3"   fill="#D4A0A8" opacity="0.4"/>
        <circle  cx="350" cy="22" r="1.5" fill="#C88898" opacity="0.5"/>
      </svg>
    </div>

    {{-- ── MAP ───────────────────────────────────────────── --}}
    @if($wedding->map_embed_url)
    <section class="map-section reveal-section">
      <div class="section-header">
        <svg class="section-header-svg" viewBox="0 0 500 50" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <line x1="0"   y1="25" x2="160" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <line x1="340" y1="25" x2="500" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <circle cx="250" cy="25" r="8" fill="none" stroke="#C9A96E" stroke-width="0.8" opacity="0.5"/>
          <circle cx="250" cy="25" r="3" fill="#C9A96E" opacity="0.4"/>
          <circle cx="175" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="325" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <ellipse cx="148" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(-10 148 25)"/>
          <ellipse cx="352" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(10 352 25)"/>
        </svg>
        <h2>Find Us</h2>
      </div>
      <div class="map-card">
        <div class="map-venue-label">
          <span class="map-pin">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
            </svg>
          </span>
          <div>
            <p class="map-venue-name">{{ $wedding->venue_name }}</p>
            <p class="map-venue-address">{{ $wedding->venue_address }}</p>
          </div>
          <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($wedding->venue_address) }}" target="_blank" rel="noopener" class="map-directions-btn">
            Get Directions
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
              <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
            </svg>
          </a>
        </div>
        <div class="map-embed">{!! $wedding->map_embed_url !!}</div>
      </div>
    </section>
    @endif

    {{-- ── Love Story ───────────────────────────────────── --}}
    @if($wedding->love_story)
    <section class="story-section reveal-section">
      <div class="story-wash" aria-hidden="true"></div>
      <svg class="story-bg-rose" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <circle cx="150" cy="150" r="80" fill="#F2D4D4" opacity="0.12"/>
        <circle cx="150" cy="150" r="55" fill="#EAC4C4" opacity="0.10"/>
        <circle cx="150" cy="150" r="35" fill="#D4A0A8" opacity="0.08"/>
        <ellipse cx="150" cy="80"  rx="18" ry="30" fill="#D4A0A8" opacity="0.10"/>
        <ellipse cx="150" cy="80"  rx="18" ry="30" fill="#D4A0A8" opacity="0.10" transform="rotate(60  150 150)"/>
        <ellipse cx="150" cy="80"  rx="18" ry="30" fill="#D4A0A8" opacity="0.10" transform="rotate(120 150 150)"/>
        <ellipse cx="150" cy="80"  rx="18" ry="30" fill="#D4A0A8" opacity="0.10" transform="rotate(180 150 150)"/>
        <ellipse cx="150" cy="80"  rx="18" ry="30" fill="#D4A0A8" opacity="0.10" transform="rotate(240 150 150)"/>
        <ellipse cx="150" cy="80"  rx="18" ry="30" fill="#D4A0A8" opacity="0.10" transform="rotate(300 150 150)"/>
      </svg>
      <div class="section-header">
        <svg class="section-header-svg" viewBox="0 0 500 50" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <line x1="0"   y1="25" x2="160" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <line x1="340" y1="25" x2="500" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <circle cx="250" cy="25" r="8" fill="none" stroke="#C9A96E" stroke-width="0.8" opacity="0.5"/>
          <circle cx="250" cy="25" r="3" fill="#C9A96E" opacity="0.4"/>
          <circle cx="175" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="325" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <ellipse cx="148" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(-10 148 25)"/>
          <ellipse cx="352" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(10 352 25)"/>
        </svg>
        <h2>Our Story</h2>
      </div>
      <div class="story-content">
        <p>{!! nl2br(e($wedding->love_story)) !!}</p>
      </div>
    </section>
    @endif

    {{-- ── Gallery ──────────────────────────────────────── --}}
    @if($wedding->photos && count($wedding->photos) > 0)
    <section class="gallery-section reveal-section">
      <div class="section-header">
        <svg class="section-header-svg" viewBox="0 0 500 50" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <line x1="0"   y1="25" x2="160" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <line x1="340" y1="25" x2="500" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <circle cx="250" cy="25" r="8" fill="none" stroke="#C9A96E" stroke-width="0.8" opacity="0.5"/>
          <circle cx="250" cy="25" r="3" fill="#C9A96E" opacity="0.4"/>
          <circle cx="175" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="325" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <ellipse cx="148" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(-10 148 25)"/>
          <ellipse cx="352" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(10 352 25)"/>
        </svg>
        <h2>Our Moments</h2>
      </div>
      <div class="gallery-grid">
        @foreach($wedding->photos as $photo)
        <div class="gallery-item reveal-card">
          <img src="{{ Storage::url($photo->path) }}" alt="Wedding photo {{ $loop->iteration }}" loading="lazy">
        </div>
        @endforeach
      </div>
    </section>
    @endif

    {{-- ── Entourage ─────────────────────────────────────── --}}
    @if($wedding->entourage && count($wedding->entourage) > 0)
    <section class="entourage-section reveal-section">
      <div class="section-header">
        <svg class="section-header-svg" viewBox="0 0 500 50" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <line x1="0"   y1="25" x2="160" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <line x1="340" y1="25" x2="500" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <circle cx="250" cy="25" r="8" fill="none" stroke="#C9A96E" stroke-width="0.8" opacity="0.5"/>
          <circle cx="250" cy="25" r="3" fill="#C9A96E" opacity="0.4"/>
          <circle cx="175" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="325" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <ellipse cx="148" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(-10 148 25)"/>
          <ellipse cx="352" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(10 352 25)"/>
        </svg>
        <h2>Wedding Entourage</h2>
      </div>
      <div class="entourage-grid">
        @foreach($wedding->entourage->groupBy('role') as $role => $members)
        <div class="entourage-group reveal-card">
          <svg class="card-filigree" viewBox="0 0 160 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <line x1="10" y1="10" x2="65"  y2="10" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <line x1="95" y1="10" x2="150" y2="10" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <circle cx="80" cy="10" r="3" fill="none" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
            <circle cx="80" cy="10" r="1" fill="#C9A96E" opacity="0.4"/>
          </svg>
          <h3 class="role-title">{{ $role }}</h3>
          <ul>
            @foreach($members as $member)
            <li>{{ $member->name }}</li>
            @endforeach
          </ul>
        </div>
        @endforeach
      </div>
    </section>
    @endif

    {{-- ── RSVP ─────────────────────────────────────────── --}}
    @if($wedding->rsvp_enabled)
    <section class="rsvp-section reveal-section" id="rsvp">
      <div class="rsvp-texture-bg" aria-hidden="true"></div>
      <svg class="rsvp-botanical rsvp-botanical-left" viewBox="0 0 100 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M80,190 C70,150 50,110 30,70 C20,50 10,30 20,10" stroke="#C9A96E" stroke-width="1" fill="none" opacity="0.4"/>
        <ellipse cx="50" cy="120" rx="14" ry="5" fill="#B8C9A0" opacity="0.35" transform="rotate(-30 50 120)"/>
        <ellipse cx="35" cy="80"  rx="12" ry="4" fill="#B8C9A0" opacity="0.3"  transform="rotate(-50 35 80)"/>
        <ellipse cx="25" cy="45"  rx="10" ry="4" fill="#B8C9A0" opacity="0.3"  transform="rotate(-60 25 45)"/>
        <circle  cx="20" cy="10" r="5"   fill="#D4A0A8" opacity="0.4"/>
        <circle  cx="20" cy="10" r="2.5" fill="#C88898" opacity="0.5"/>
      </svg>
      <svg class="rsvp-botanical rsvp-botanical-right" viewBox="0 0 100 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="transform:scaleX(-1)">
        <path d="M80,190 C70,150 50,110 30,70 C20,50 10,30 20,10" stroke="#C9A96E" stroke-width="1" fill="none" opacity="0.4"/>
        <ellipse cx="50" cy="120" rx="14" ry="5" fill="#B8C9A0" opacity="0.35" transform="rotate(-30 50 120)"/>
        <ellipse cx="35" cy="80"  rx="12" ry="4" fill="#B8C9A0" opacity="0.3"  transform="rotate(-50 35 80)"/>
        <ellipse cx="25" cy="45"  rx="10" ry="4" fill="#B8C9A0" opacity="0.3"  transform="rotate(-60 25 45)"/>
        <circle  cx="20" cy="10" r="5"   fill="#D4A0A8" opacity="0.4"/>
        <circle  cx="20" cy="10" r="2.5" fill="#C88898" opacity="0.5"/>
      </svg>
      <div class="section-header">
        <svg class="section-header-svg" viewBox="0 0 500 50" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <line x1="0"   y1="25" x2="160" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <line x1="340" y1="25" x2="500" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <circle cx="250" cy="25" r="8" fill="none" stroke="#C9A96E" stroke-width="0.8" opacity="0.5"/>
          <circle cx="250" cy="25" r="3" fill="#C9A96E" opacity="0.4"/>
          <circle cx="175" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="325" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <ellipse cx="148" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(-10 148 25)"/>
          <ellipse cx="352" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(10 352 25)"/>
        </svg>
        <h2>RSVP</h2>
      </div>
      <p class="rsvp-deadline">Kindly reply by <strong>{{ \Carbon\Carbon::parse($wedding->rsvp_deadline)->format('F j, Y') }}</strong></p>
      <form class="rsvp-form" id="rsvpForm" method="POST" action="{{ route('rsvp.store') }}">
        @csrf
        <input type="hidden" name="wedding_id" value="{{ $wedding->id }}">
        <div class="form-group">
          <label for="guest_name">Full Name</label>
          <input type="text" id="guest_name" name="guest_name" placeholder="Your full name" required>
        </div>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="your@email.com">
        </div>
        <div class="form-group">
          <label for="guests">Number of Guests</label>
          <select id="guests" name="guests_count">
            <option value="1">Just me</option>
            <option value="2">2 guests</option>
            <option value="3">3 guests</option>
            <option value="4">4 guests</option>
          </select>
        </div>
        <div class="form-group attendance-group">
          <label>Will you attend?</label>
          <div class="radio-group">
            <label class="radio-label"><input type="radio" name="attending" value="yes" required><span>Joyfully accepts</span></label>
            <label class="radio-label"><input type="radio" name="attending" value="no"><span>Regretfully declines</span></label>
          </div>
        </div>
        <div class="form-group">
          <label for="message">Message to the Couple</label>
          <textarea id="message" name="message" rows="4" placeholder="Share your wishes..."></textarea>
        </div>
        <button type="submit" class="rsvp-submit">Send RSVP</button>
      </form>
    </section>
    @endif

    {{-- ── Countdown ────────────────────────────────────── --}}
    <section class="countdown-section reveal-section">
      <div class="countdown-texture-bg" aria-hidden="true"></div>
      <svg class="countdown-bg-botanical" viewBox="0 0 600 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice">
        <path d="M50,100 C150,60 250,140 300,100 C350,60 450,140 550,100" stroke="#C9A96E" stroke-width="1.5" fill="none" opacity="0.12"/>
        <ellipse cx="150" cy="82" rx="20" ry="8" fill="#B8C9A0" opacity="0.12" transform="rotate(-15 150 82)"/>
        <ellipse cx="300" cy="100" rx="20" ry="8" fill="#B8C9A0" opacity="0.12"/>
        <ellipse cx="450" cy="82" rx="20" ry="8" fill="#B8C9A0" opacity="0.12" transform="rotate(15 450 82)"/>
        <circle cx="300" cy="100" r="10" fill="#D4A0A8" opacity="0.10"/>
      </svg>
      <div class="section-header">
        <svg class="section-header-svg" viewBox="0 0 500 50" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <line x1="0"   y1="25" x2="160" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <line x1="340" y1="25" x2="500" y2="25" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <circle cx="250" cy="25" r="8" fill="none" stroke="#C9A96E" stroke-width="0.8" opacity="0.5"/>
          <circle cx="250" cy="25" r="3" fill="#C9A96E" opacity="0.4"/>
          <circle cx="175" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <circle cx="325" cy="25" r="3.5" fill="#D4A0A8" opacity="0.5"/>
          <ellipse cx="148" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(-10 148 25)"/>
          <ellipse cx="352" cy="25" rx="10" ry="4" fill="#B8C9A0" opacity="0.4" transform="rotate(10 352 25)"/>
        </svg>
        <h2>Counting Down</h2>
      </div>
      <div class="countdown-grid" id="countdown" data-date="{{ \Carbon\Carbon::parse($wedding->wedding_date)->format('Y-m-d') }}T{{ \Carbon\Carbon::parse($wedding->ceremony_time)->format('H:i:s') }}">
        <div class="countdown-item"><span id="days">00</span><label>Days</label></div>
        <div class="countdown-item"><span id="hours">00</span><label>Hours</label></div>
        <div class="countdown-item"><span id="minutes">00</span><label>Minutes</label></div>
        <div class="countdown-item"><span id="seconds">00</span><label>Seconds</label></div>
      </div>
    </section>

    {{-- ── Footer ───────────────────────────────────────── --}}
    <footer class="invitation-footer">
      {{-- Botanical arch crown --}}
      <svg class="footer-botanical-arch" viewBox="0 0 700 120" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid meet">
        <path d="M50,120 C100,80 180,50 280,40 C350,34 420,38 500,55 C580,72 640,95 680,120" stroke="#C9A96E" stroke-width="1.2" fill="none" opacity="0.4"/>
        <path d="M80,120 C130,90 200,65 290,55 C350,49 430,53 510,68 C580,82 630,100 660,120" stroke="#C9A96E" stroke-width="0.7" fill="none" opacity="0.25"/>
        <path d="M140,90 C155,75 175,68 195,65" stroke="#B8C9A0" stroke-width="0.9" fill="none" opacity="0.4"/>
        <ellipse cx="195" cy="65" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(-30 195 65)"/>
        <ellipse cx="160" cy="82" rx="10" ry="4" fill="#B8C9A0" opacity="0.35" transform="rotate(-15 160 82)"/>
        <path d="M560,90 C545,75 525,68 505,65" stroke="#B8C9A0" stroke-width="0.9" fill="none" opacity="0.4"/>
        <ellipse cx="505" cy="65" rx="12" ry="5" fill="#B8C9A0" opacity="0.4" transform="rotate(30 505 65)"/>
        <ellipse cx="540" cy="82" rx="10" ry="4" fill="#B8C9A0" opacity="0.35" transform="rotate(15 540 82)"/>
        <circle cx="350" cy="38" r="10" fill="#D4A0A8" opacity="0.45"/>
        <circle cx="350" cy="38" r="6"  fill="#C88898" opacity="0.55"/>
        <circle cx="350" cy="38" r="3"  fill="#A06878" opacity="0.6"/>
        <ellipse cx="350" cy="26" rx="5" ry="7" fill="#D4A0A8" opacity="0.3"/>
        <ellipse cx="350" cy="26" rx="5" ry="7" fill="#D4A0A8" opacity="0.3" transform="rotate(60  350 38)"/>
        <ellipse cx="350" cy="26" rx="5" ry="7" fill="#D4A0A8" opacity="0.3" transform="rotate(120 350 38)"/>
        <ellipse cx="350" cy="26" rx="5" ry="7" fill="#D4A0A8" opacity="0.3" transform="rotate(180 350 38)"/>
        <ellipse cx="350" cy="26" rx="5" ry="7" fill="#D4A0A8" opacity="0.3" transform="rotate(240 350 38)"/>
        <ellipse cx="350" cy="26" rx="5" ry="7" fill="#D4A0A8" opacity="0.3" transform="rotate(300 350 38)"/>
        <circle cx="240" cy="48" r="6"   fill="#D4A0A8" opacity="0.38"/>
        <circle cx="240" cy="48" r="3.5" fill="#C88898" opacity="0.48"/>
        <circle cx="460" cy="48" r="6"   fill="#D4A0A8" opacity="0.38"/>
        <circle cx="460" cy="48" r="3.5" fill="#C88898" opacity="0.48"/>
        <circle cx="120" cy="105" r="2" fill="#C9A96E" opacity="0.3"/>
        <circle cx="580" cy="105" r="2" fill="#C9A96E" opacity="0.3"/>
        <circle cx="200" cy="62"  r="1.5" fill="#C9A96E" opacity="0.25"/>
        <circle cx="500" cy="62"  r="1.5" fill="#C9A96E" opacity="0.25"/>
      </svg>

      <p>With love & gratitude</p>
      <p class="footer-names">{{ $wedding->bride_name }} & {{ $wedding->groom_name }}</p>

      {{-- Ornamental rule --}}
      <div class="footer-ornament-vector" aria-hidden="true">
        <svg viewBox="0 0 300 24" xmlns="http://www.w3.org/2000/svg">
          <line x1="0"   y1="12" x2="110" y2="12" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
          <line x1="190" y1="12" x2="300" y2="12" stroke="#C9A96E" stroke-width="0.6" opacity="0.5"/>
          <path d="M122,12 L130,6 L138,12 L130,18 Z" fill="none" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <path d="M150,12 L158,6 L166,12 L158,18 Z" fill="#C9A96E" opacity="0.4"/>
          <path d="M178,12 L170,6 L162,12 L170,18 Z" fill="none" stroke="#C9A96E" stroke-width="0.7" opacity="0.5"/>
          <circle cx="113" cy="12" r="1.5" fill="#C9A96E" opacity="0.4"/>
          <circle cx="187" cy="12" r="1.5" fill="#C9A96E" opacity="0.4"/>
        </svg>
      </div>

      @if($wedding->hashtag)
      <p class="footer-hashtag">#{{ $wedding->hashtag }}</p>
      @endif
    </footer>

  </main>
</div>
@endsection

@push('styles')
<style>
  /* ── SVG defs (hidden utility) ───────────────────────── */
  .svg-defs { position:absolute; width:0; height:0; overflow:hidden; }

  /* ── Full-page texture layers ────────────────────────── */
  .bg-texture-layer { position:fixed; inset:0; pointer-events:none; z-index:0; }
  .bg-linen {
    background-image:
      repeating-linear-gradient(0deg,  transparent, transparent 3px, rgba(200,185,165,0.06) 3px, rgba(200,185,165,0.06) 4px),
      repeating-linear-gradient(90deg, transparent, transparent 3px, rgba(200,185,165,0.04) 3px, rgba(200,185,165,0.04) 4px);
    mix-blend-mode: multiply;
  }
  .bg-grain {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
    opacity: 0.5;
    mix-blend-mode: overlay;
  }
  .bg-vignette {
    background: radial-gradient(ellipse at center, transparent 55%, rgba(180,155,130,0.18) 100%);
  }

  /* ── Fixed corner botanical vectors ─────────────────── */
  .corner-vector { position:fixed; width:180px; height:180px; pointer-events:none; z-index:1; }
  .corner-tl { top:0; left:0; }
  .corner-tr { top:0; right:0; }

  /* ── Envelope scene overlays ─────────────────────────── */
  .scene-wash, .scene-botanicals {
    position:absolute; inset:0; width:100%; height:100%; pointer-events:none;
  }

  /* ── Envelope texture SVG ────────────────────────────── */
  .envelope-texture {
    position:absolute; inset:0; width:100%; height:100%; pointer-events:none; z-index:1;
  }

  /* ── Letter overlays ─────────────────────────────────── */
  .letter-texture {
    position:absolute; inset:0; width:100%; height:100%; pointer-events:none; z-index:0; border-radius:inherit;
  }
  .letter-border-svg { display:block; width:100%; height:40px; }
  .letter-border-top  { margin-bottom:0.5rem; }
  .letter-border-bottom { margin-top:0.5rem; }

  /* ── Floral dividers ─────────────────────────────────── */
  .vector-divider { width:100%; max-width:280px; margin:0.75rem auto; }
  .vector-divider svg { display:block; width:100%; }

  /* ── Vine section dividers ───────────────────────────── */
  .section-vine-divider { width:100%; max-width:700px; margin:0 auto; padding:0.5rem 1rem; pointer-events:none; }
  .section-vine-divider svg { display:block; width:100%; }

  /* ── Section header SVG ornaments ────────────────────── */
  .section-header-svg { display:block; width:100%; max-width:500px; margin:0 auto 0.5rem; }
  .section-header .section-ornament { display:none; }

  /* ── Card filigree ───────────────────────────────────── */
  .card-filigree { display:block; margin:0 auto 0.5rem; }

  /* ── Section texture washes ──────────────────────────── */
  .section-texture-wash {
    position:absolute; inset:0; pointer-events:none; border-radius:inherit;
    background:
      radial-gradient(ellipse at 30% 50%, rgba(242,212,212,0.18) 0%, transparent 65%),
      radial-gradient(ellipse at 70% 50%, rgba(212,160,168,0.12) 0%, transparent 60%);
  }
  .details-section { position:relative; overflow:hidden; }

  /* ── Hero texture layers ─────────────────────────────── */
  .hero-bg-texture {
    position:absolute; inset:0; pointer-events:none; mix-blend-mode:multiply;
    background-image:
      repeating-linear-gradient(0deg,  transparent, transparent 3px, rgba(200,185,165,0.05) 3px, rgba(200,185,165,0.05) 4px),
      repeating-linear-gradient(90deg, transparent, transparent 3px, rgba(200,185,165,0.04) 3px, rgba(200,185,165,0.04) 4px);
  }
  .hero-blush { position:absolute; inset:0; width:100%; height:100%; pointer-events:none; }

  /* ── Story section ───────────────────────────────────── */
  .story-section { position:relative; overflow:hidden; }
  .story-wash {
    position:absolute; inset:0; pointer-events:none;
    background:
      radial-gradient(ellipse at 20% 60%, rgba(248,232,224,0.55) 0%, transparent 60%),
      radial-gradient(ellipse at 80% 40%, rgba(242,212,212,0.35) 0%, transparent 55%);
  }
  .story-bg-rose {
    position:absolute; right:-60px; top:50%; transform:translateY(-50%);
    width:300px; height:300px; pointer-events:none; opacity:0.7;
  }

  /* ── RSVP ────────────────────────────────────────────── */
  .rsvp-section { position:relative; overflow:hidden; }
  .rsvp-texture-bg {
    position:absolute; inset:0; pointer-events:none;
    background-image:
      repeating-linear-gradient(0deg,  transparent, transparent 4px, rgba(200,185,165,0.05) 4px, rgba(200,185,165,0.05) 5px),
      repeating-linear-gradient(90deg, transparent, transparent 4px, rgba(200,185,165,0.04) 4px, rgba(200,185,165,0.04) 5px);
  }
  .rsvp-botanical { position:absolute; width:80px; height:160px; top:60px; pointer-events:none; }
  .rsvp-botanical-left  { left:0; }
  .rsvp-botanical-right { right:0; }

  /* ── Countdown ───────────────────────────────────────── */
  .countdown-section { position:relative; overflow:hidden; }
  .countdown-texture-bg {
    position:absolute; inset:0; pointer-events:none;
    background: radial-gradient(ellipse at center, rgba(248,232,224,0.4) 0%, transparent 70%);
  }
  .countdown-bg-botanical { position:absolute; inset:0; width:100%; height:100%; pointer-events:none; }

  /* ── Footer ──────────────────────────────────────────── */
  .footer-botanical-arch { display:block; width:100%; max-width:700px; margin:0 auto 1rem; }
  .footer-ornament-vector { width:300px; margin:0.75rem auto; }
  .footer-ornament-vector svg { display:block; width:100%; }
  .footer-ornament { display:none; }
</style>
@endpush

@push('scripts')
<script>
  window.weddingDate = "{{ \Carbon\Carbon::parse($wedding->wedding_date)->format('Y-m-d') }}T{{ \Carbon\Carbon::parse($wedding->ceremony_time)->format('H:i:s') }}";

  // ── Background Music ─────────────────────────
  const audio     = document.getElementById('bgAudio');
  const audioBtn  = document.getElementById('audioToggle');
  const audioIcon = document.getElementById('audioIcon');

  const playIconSVG  = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7L8 5Z"/></svg>`;
  const pauseIconSVG = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>`;

  if (audio && audioBtn) {
    window.tryPlayMusic = function () {
      audio.play().then(() => {
        if (audioIcon) audioIcon.innerHTML = pauseIconSVG;
      }).catch(() => {});
    };
    audioBtn.addEventListener('click', () => {
      if (audio.paused) { audio.play(); audioIcon.innerHTML = pauseIconSVG; }
      else              { audio.pause(); audioIcon.innerHTML = playIconSVG; }
    });
  }

  // ── Hero Video Mute Toggle ────────────────────
  const heroVideo = document.getElementById('heroVideo');
  const muteBtn   = document.getElementById('videoMuteBtn');
  const muteIcon  = document.getElementById('muteIcon');

  const mutedSVG   = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><line x1="22" y1="9" x2="16" y2="15"/><line x1="16" y1="9" x2="22" y2="15"/></svg>`;
  const unmutedSVG = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>`;

  if (heroVideo && muteBtn) {
    muteBtn.addEventListener('click', () => {
      heroVideo.muted = !heroVideo.muted;
      muteIcon.innerHTML = heroVideo.muted ? mutedSVG : unmutedSVG;
    });
  }
</script>
@endpush
