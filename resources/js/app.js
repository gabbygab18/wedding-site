/**
 * Wedding Invitation — Main JS
 * Envelope open animation, petals, countdown, RSVP, scroll reveals
 */

document.addEventListener('DOMContentLoaded', () => {

  // ─── Elements ──────────────────────────────
  const envelopeScene   = document.getElementById('envelopeScene');
  const envelope        = document.getElementById('envelope');
  const envelopeFlap    = document.getElementById('envelopeFlap');
  const waxSeal         = document.getElementById('waxSeal');
  const openBtn         = document.getElementById('openBtn');
  const invitationContent = document.getElementById('invitationContent');
  const petalsContainer = document.getElementById('petalsContainer');

  // ─── Petals ────────────────────────────────
  function createPetal() {
    const petal = document.createElement('div');
    petal.classList.add('petal');
    petal.style.left = Math.random() * 100 + 'vw';
    petal.style.animationDuration = (6 + Math.random() * 8) + 's';
    petal.style.animationDelay = (Math.random() * 5) + 's';
    petal.style.fontSize = (0.8 + Math.random() * 0.8) + 'rem';
    petal.style.opacity = '0';

    const emojis = ['🌸', '🌺', '🌼', '✿', '❀'];
    petal.textContent = emojis[Math.floor(Math.random() * emojis.length)];

    petalsContainer.appendChild(petal);
    petal.addEventListener('animationend', () => petal.remove());
  }

  // Start petals after a delay
  setTimeout(() => {
    createPetal();
    setInterval(createPetal, 1200);
  }, 2000);

  // ─── Envelope Open Sequence ────────────────
  let isOpening = false;

  function openEnvelope() {
    if (isOpening) return;
    isOpening = true;

    openBtn.disabled = true;
    openBtn.classList.add('opening');

    // Step 1: Break the wax seal
    waxSeal.classList.add('seal-broken');

    // Step 2: Open the flap
    setTimeout(() => {
      envelope.classList.add('flap-open');
      envelope.classList.add('opening');
    }, 500);

    // Step 3: Letter rises out
    setTimeout(() => {
      envelope.classList.add('letter-rising');
    }, 1600);

    // Step 4: Fade out scene, show invitation
    setTimeout(() => {
      envelopeScene.classList.add('scene-exit');
    }, 3200);

    setTimeout(() => {
      envelopeScene.style.display = 'none';
      invitationContent.classList.remove('hidden');
      invitationContent.style.opacity = '0';

      // Fade in
      requestAnimationFrame(() => {
        invitationContent.style.transition = 'opacity 0.8s ease';
        invitationContent.style.opacity = '1';
      });

      // Trigger reveal animations
      triggerRevealAnimations();
      startCountdown();

    }, 4200);
  }

  if (openBtn) {
    openBtn.addEventListener('click', openEnvelope);
  }

  if (waxSeal) {
    waxSeal.addEventListener('click', openEnvelope);
    waxSeal.style.cursor = 'pointer';
  }

  // ─── Scroll Reveal ──────────────────────────
  function triggerRevealAnimations() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.reveal-text, .reveal-section, .reveal-card').forEach(el => {
      observer.observe(el);
    });
  }

 function startCountdown() {
  const countdownEl = document.getElementById('countdown');
  if (!countdownEl) return;

  const raw = countdownEl.dataset.date; // e.g. "2026-12-18T14:00:00" or "2026-12-18T2026-12-18 14:00:00"

  // Extract just the date part (first 10 chars) and time part (last 8 chars)
  const datePart = raw.substring(0, 10);           // "2026-12-18"
  const timePart = raw.slice(-8).replace(' ', ''); // "14:00:00"

  const [year, month, day]       = datePart.split('-').map(Number);
  const [hour, minute, second]   = timePart.split(':').map(Number);

  const targetDate = new Date(year, month - 1, day, hour, minute, second || 0);

  if (isNaN(targetDate.getTime())) {
    console.error('Invalid countdown date:', raw);
    return;
  }

  function update() {
    const now  = new Date();
    const diff = targetDate - now;

    if (diff <= 0) {
      document.getElementById('days').textContent    = '00';
      document.getElementById('hours').textContent   = '00';
      document.getElementById('minutes').textContent = '00';
      document.getElementById('seconds').textContent = '00';
      return;
    }

    const d = Math.floor(diff / (1000 * 60 * 60 * 24));
    const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const s = Math.floor((diff % (1000 * 60)) / 1000);

    document.getElementById('days').textContent    = String(d).padStart(2, '0');
    document.getElementById('hours').textContent   = String(h).padStart(2, '0');
    document.getElementById('minutes').textContent = String(m).padStart(2, '0');
    document.getElementById('seconds').textContent = String(s).padStart(2, '0');
  }

  update();
  setInterval(update, 1000);
}

  // ─── RSVP Form ─────────────────────────────
  const rsvpForm = document.getElementById('rsvpForm');

  if (rsvpForm) {
    rsvpForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const btn = rsvpForm.querySelector('.rsvp-submit');
      const original = btn.textContent;
      btn.textContent = 'Sending...';
      btn.disabled = true;

      try {
        const formData = new FormData(rsvpForm);
        const token    = document.querySelector('meta[name="csrf-token"]').content;

        const res = await fetch(rsvpForm.action, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();

        if (res.ok) {
          // Replace form with success message
          const section = rsvpForm.closest('section');
          rsvpForm.innerHTML = `
            <div class="rsvp-success">
              <span class="success-icon">✦</span>
              <p>Thank you, ${data.name || 'dear guest'}!</p>
              <p style="font-size:1rem; margin-top:8px;">Your RSVP has been received.<br>We look forward to celebrating with you.</p>
            </div>
          `;
        } else {
          throw new Error(data.message || 'Something went wrong');
        }
      } catch (err) {
        btn.textContent = original;
        btn.disabled = false;
        alert('Could not submit RSVP: ' + err.message);
      }
    });
  }

  // ─── Keyboard support ──────────────────────
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
      if (openBtn && !openBtn.disabled && envelopeScene && !envelopeScene.classList.contains('scene-exit')) {
        e.preventDefault();
        openEnvelope();
      }
    }
  });

});
