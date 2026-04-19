/**
 * Wedding Admin — JS
 */
document.addEventListener('DOMContentLoaded', () => {

  // ─── Sidebar Toggle ────────────────────────
  const sidebar   = document.querySelector('.admin-sidebar');
  const overlay   = document.querySelector('.sidebar-overlay');
  const toggleBtn = document.querySelector('.sidebar-toggle');
  const closeBtn  = document.querySelector('.sidebar-close');

  function openSidebar() {
    if (!sidebar || !overlay) return;
    sidebar.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    if (!sidebar || !overlay) return;
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  if (toggleBtn) {
    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });
  }

  if (overlay) overlay.addEventListener('click', closeSidebar);
  if (closeBtn) closeBtn.addEventListener('click', closeSidebar);

  // Close sidebar on nav item click (mobile)
  document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', () => {
      if (window.innerWidth < 768) closeSidebar();
    });
  });

  // ─── Auto-dismiss alerts ───────────────────
  document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity 0.5s';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 500);
    }, 4000);
  });

  // ─── Sort order update ─────────────────────
  document.querySelectorAll('.order-input').forEach(input => {
    input.addEventListener('change', async () => {
      const id    = input.dataset.id;
      const order = input.value;
      const token = document.querySelector('meta[name="csrf-token"]')?.content;
      if (!token) return;

      await fetch(`/admin/photos/${id}/order`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify({ sort_order: order })
      });
    });
  });

});
