import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

// NProgress is loaded via CDN, available globally as NProgress
window.addEventListener('beforeunload', () => {
    if (typeof NProgress !== 'undefined') NProgress.start();
});
window.addEventListener('load', () => {
    if (typeof NProgress !== 'undefined') NProgress.done();
});

Alpine.start();
