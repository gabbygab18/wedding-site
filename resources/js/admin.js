/**
 * Wedding Admin — JS
 */
document.addEventListener('DOMContentLoaded', () => {

  // Auto-dismiss alerts
  document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity 0.5s';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 500);
    }, 4000);
  });

  // Sort order update
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
