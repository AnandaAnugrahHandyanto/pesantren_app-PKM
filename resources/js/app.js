import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

window.Alpine = Alpine;
window.Swal = Swal;

NProgress.configure({ showSpinner: false, speed: 300 });

window.addEventListener('beforeunload', () => NProgress.start());
window.addEventListener('load', () => NProgress.done());

Alpine.start();
