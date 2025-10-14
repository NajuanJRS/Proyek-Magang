console.log('custom.js loaded');

// ====== Hapus (SweetAlert2) ======
window.deleteData = function (id) {
  if (typeof Swal === 'undefined') {
    // fallback kalau Swal belum termuat
    if (confirm('Yakin ingin menghapus data ini?')) {
      const form = document.getElementById('delete-form-' + id);
      if (form) form.submit();
    }
    return;
  }

  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: 'Data ini akan dihapus secara permanen!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.getElementById('delete-form-' + id);
      if (form) form.submit();
    }
  });
};

// ====== Lihat Selengkapnya (SweetAlert2) ======
document.addEventListener('click', function (e) {
  const btn = e.target.closest('.see-more');
  if (!btn) return;

  const id = btn.getAttribute('data-id');
  const title = btn.getAttribute('data-judul') || 'Detail Data';
  const contentEl = document.getElementById('full-content-' + id);
  const htmlContent = contentEl ? contentEl.innerHTML : '';

  if (typeof Swal === 'undefined') {
    console.error('SweetAlert2 belum dimuat!');
    return;
  }

  Swal.fire({
    title: title,
    html: '<div style="text-align:left;max-height:60vh;overflow:auto;">' + htmlContent + '</div>',
    width: 800,
    confirmButtonText: 'Tutup'
  });
});

// ====== TinyMCE (opsional) ======
document.addEventListener('DOMContentLoaded', function () {
  if (typeof tinymce !== 'undefined') {
    tinymce.init({
      selector: 'textarea.my-editor',
      height: 400,
      setup: function (editor) {
        editor.on('change', function () {
          tinymce.triggerSave(); // penting: sinkron ke <textarea>
        });
      }
    });
  }
});

// Search logic
const searchInput = document.getElementById("searchInput");
const tableRows = document.querySelectorAll("tbody tr");

if (searchInput && tableRows) {
    searchInput.addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase();

        tableRows.forEach((row) => {
            // ambil teks dari kolom ke-2, 3, dan 4 (indeks 1, 2, 3)
            const cells = row.querySelectorAll("td");
            const combinedText =
                (cells[1]?.textContent.toLowerCase() || "")
                + " " +
                (cells[2]?.textContent.toLowerCase() || "");

            if (searchTerm.length >= 3 && combinedText.includes(searchTerm)) {
                row.style.display = "";
            } else if (searchTerm.length < 3) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const btn2 = document.getElementById("toggle-tombol2");
    const btn3 = document.getElementById("toggle-tombol3");
    const tombol2 = document.getElementById("tombol2");
    const tombol3 = document.getElementById("tombol3");

    if (btn2) {
        btn2.addEventListener("click", function () {
            if (tombol2.style.display === "none" || tombol2.style.display === "") {
                // buka berita 2
                tombol2.style.display = "block";
                btn2.innerText = "− Tutup 2";
            } else {
                // tutup tombol 2 dan otomatis tutup tombol 3
                tombol2.style.display = "none";
                btn2.innerText = "+ Tambah 2";

                tombol3.style.display = "none"; // otomatis tertutup
                if (btn3) btn3.innerText = "+ Tambah 3";
            }
        });
    }

    if (btn3) {
        btn3.addEventListener("click", function () {
            if (tombol3.style.display === "none" || tombol3.style.display === "") {
                tombol3.style.display = "block";
                btn3.innerText = "− Tutup 3";
            } else {
                tombol3.style.display = "none";
                btn3.innerText = "+ Tambah 3";
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector(".navbar-toggler");
    const sidebar = document.querySelector(".sidebar");

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("active");
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const body = document.querySelector("body");
    const toggleBtn = document.querySelector("[data-toggle='minimize']");

    if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            if (body.classList.contains("sidebar-icon-only")) {
                body.classList.remove("sidebar-icon-only");
            } else {
                body.classList.add("sidebar-icon-only");
            }
        });
    }
});

    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.getElementById('sidebarToggle');
        if (btn) {
            btn.onclick = function() {
                var sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.classList.toggle('sidebar-icon-only');
                }
                var content = document.querySelector('.content');
                if (content) {
                    content.classList.toggle('sidebar-minimized');
                }
            };
        }
    });

    function togglePassword() {
            var pwd = document.getElementById('password');
            var icon = document.getElementById('toggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                pwd.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }

        function previewImage(event, previewId) {
        const input = event.target;
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "#";
            preview.style.display = 'none';
        }
    }

     function previewEditImage(event, oldPreviewId, newPreviewId) {
        const input = event.target;
        const newPreview = document.getElementById(newPreviewId);
        const oldPreview = document.getElementById(oldPreviewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Tampilkan gambar baru
                newPreview.src = e.target.result;
                newPreview.style.display = 'block';
                newPreview.style.border = '1px solid #ddd';
                newPreview.style.borderRadius = '8px';
                newPreview.style.padding = '4px';
                newPreview.style.maxWidth = '200px';
                newPreview.style.marginTop = '10px';

                // Sembunyikan gambar lama jika ada
                if (oldPreview) {
                    oldPreview.style.display = 'none';
                }
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            // Jika batal memilih file, kembalikan kondisi awal
            newPreview.src = "#";
            newPreview.style.display = 'none';

            if (oldPreview) {
                oldPreview.style.display = 'block';
            }
        }
    }

    document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebarMenu').classList.toggle('hidden');
    document.querySelector('.content').classList.toggle('full');
});

document.getElementById('sidebarToggle').addEventListener('click', function () {
        document.querySelector('.navbar').classList.toggle('nav-collapsed');
    });

   document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebarMenu');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const logoFull = document.getElementById('logoFull');
    const logoMini = document.getElementById('logoMini');

    sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('sidebar-minimized');

        if (sidebar.classList.contains('sidebar-minimized')) {
            // tampilkan logo mini
            logoFull.classList.add('d-none');
            logoMini.classList.remove('d-none');
        } else {
            // tampilkan logo full
            logoFull.classList.remove('d-none');
            logoMini.classList.add('d-none');
        }
    });
});

(function () {
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebarMenu') || document.querySelector('.sidebar');
    const mobileBtn = document.getElementById('mobileSidebarToggle') || document.querySelector('.navbar-toggler');
    if (!sidebar || !mobileBtn) return;

    function createBackdrop() {
      let b = document.querySelector('.sidebar-backdrop');
      if (!b) {
        b = document.createElement('div');
        b.className = 'sidebar-backdrop';
        document.body.appendChild(b);
        b.addEventListener('click', closeMobileSidebar);
      }
      return b;
    }

    function openMobileSidebar() {
      if (window.innerWidth >= 992) return;
      sidebar.classList.add('show');
      document.body.classList.add('no-scroll');
      document.body.classList.add('mobile-sidebar-open'); // <-- add class to trigger logo animation
      const b = createBackdrop();
      // small delay so transition works consistently
      requestAnimationFrame(() => b.classList.add('show'));
      mobileBtn.setAttribute('aria-expanded', 'true');
    }

    function closeMobileSidebar() {
      if (window.innerWidth >= 992) return;
      sidebar.classList.remove('show');
      document.body.classList.remove('no-scroll');
      document.body.classList.remove('mobile-sidebar-open'); // <-- remove class
      const b = document.querySelector('.sidebar-backdrop');
      if (b) {
        b.classList.remove('show');
        setTimeout(() => { if (b.parentNode) b.parentNode.removeChild(b); }, 300);
      }
      mobileBtn.setAttribute('aria-expanded', 'false');
    }

    mobileBtn.addEventListener('click', function (e) {
      if (window.innerWidth >= 992) return;
      if (sidebar.classList.contains('show')) closeMobileSidebar();
      else openMobileSidebar();
    });

    // ensure mobile sidebar closed when resizing to desktop
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 992) {
        sidebar.classList.remove('show');
        document.body.classList.remove('no-scroll');
        document.body.classList.remove('mobile-sidebar-open'); // cleanup
        const b = document.querySelector('.sidebar-backdrop');
        if (b) b.remove();
      }
    });
  });
})();

(function () {
  function updateSidebarScroll() {
    var sidebar = document.getElementById('sidebarMenu') || document.querySelector('.sidebar');
    if (!sidebar) return;

    // Height of fixed navbar (adjust if different)
    var navbarHeight = 65;
    // compute available viewport height for sidebar
    var available = window.innerHeight - navbarHeight;
    // actual content height
    var contentHeight = sidebar.scrollHeight;

    if (contentHeight > available) {
      sidebar.classList.add('sidebar-scroll');
    } else {
      sidebar.classList.remove('sidebar-scroll');
    }
  }

  // run on load and resize, and after DOM changes (mutation observer)
  document.addEventListener('DOMContentLoaded', updateSidebarScroll);
  window.addEventListener('resize', updateSidebarScroll);

  // if sidebar content can change dynamically (collapses, ajax), observe mutations
  var sidebarEl = document.getElementById('sidebarMenu') || document.querySelector('.sidebar');
  if (sidebarEl && window.MutationObserver) {
    var mo = new MutationObserver(function () {
      // small debounce
      clearTimeout(window.__updateSidebarTimer);
      window.__updateSidebarTimer = setTimeout(updateSidebarScroll, 120);
    });
    mo.observe(sidebarEl, { childList: true, subtree: true, attributes: true });
  }
})();

// Toggle arrow direction for dropdown menus
function toggleArrow(element) {
    const arrow = element.querySelector('.arrow-icon');
    const expanded = element.getAttribute('aria-expanded') === 'true';
    if (expanded) {
        arrow.classList.add('bi-chevron-up');
        arrow.classList.remove('bi-chevron-down');
    } else {
        arrow.classList.add('bi-chevron-down');
        arrow.classList.remove('bi-chevron-up');
    }
}

// Sync arrow on collapse events for all dropdown menus
document.addEventListener('DOMContentLoaded', function () {
    // Select all collapse triggers and collapse elements
    const triggers = document.querySelectorAll('[data-bs-toggle="collapse"]');
    triggers.forEach(function (trigger) {
        const targetSelector = trigger.getAttribute('data-bs-target') || trigger.getAttribute('href');
        const collapse = document.querySelector(targetSelector);

        if (!collapse) return;

        collapse.addEventListener('show.bs.collapse', function () {
            // Reset all arrows to down except the current one
            triggers.forEach(function (t) {
                const arrow = t.querySelector('.arrow-icon');
                if (arrow) {
                    arrow.classList.add('bi-chevron-down');
                    arrow.classList.remove('bi-chevron-up');
                }
                t.setAttribute('aria-expanded', 'false');
            });
            // Set current arrow to up
            const arrow = trigger.querySelector('.arrow-icon');
            if (arrow) {
                arrow.classList.add('bi-chevron-up');
                arrow.classList.remove('bi-chevron-down');
            }
            trigger.setAttribute('aria-expanded', 'true');
        });

        collapse.addEventListener('hide.bs.collapse', function () {
            const arrow = trigger.querySelector('.arrow-icon');
            if (arrow) {
                arrow.classList.add('bi-chevron-down');
                arrow.classList.remove('bi-chevron-up');
            }
            trigger.setAttribute('aria-expanded', 'false');
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
  const triggers = document.querySelectorAll('[data-bs-toggle="collapse"]');

  function closeAllExcept(menuToKeep) {
    document.querySelectorAll('.collapse').forEach(menu => {
      if (menu !== menuToKeep) {
        menu.classList.remove('show');
        localStorage.setItem(menu.id, 'hide');
        // update arrow
        const trigger = document.querySelector(`[href="#${menu.id}"], [data-bs-target="#${menu.id}"]`);
        if (trigger) trigger.querySelector('.arrow-icon')?.classList.remove('rotate');
      }
    });
  }

  // Restore state on load
  let openedMenu = null;
  triggers.forEach(trigger => {
    const targetSelector = trigger.getAttribute('data-bs-target') || trigger.getAttribute('href');
    const menu = document.querySelector(targetSelector);
    if (!menu) return;

    const menuId = menu.id;
    const state = localStorage.getItem(menuId);

    // Jika ada link aktif, buka menu ini
    if (menu.querySelector('.nav-link.active')) {
      new bootstrap.Collapse(menu, { toggle: true });
      localStorage.setItem(menuId, 'show');
      openedMenu = menu;
    } else if (!openedMenu && state === 'show') {
      // Kalau tidak ada menu aktif, gunakan localStorage
      new bootstrap.Collapse(menu, { toggle: true });
      openedMenu = menu;
    } else {
      new bootstrap.Collapse(menu, { toggle: false });
    }
  });

  // Tutup semua selain yang terbuka
  if (openedMenu) closeAllExcept(openedMenu);

  // Listener show/hide
  document.querySelectorAll('.collapse').forEach(menu => {
    menu.addEventListener('shown.bs.collapse', function () {
      localStorage.setItem(menu.id, 'show');
      closeAllExcept(menu);
      const trigger = document.querySelector(`[href="#${menu.id}"], [data-bs-target="#${menu.id}"]`);
      if (trigger) trigger.querySelector('.arrow-icon')?.classList.add('rotate');
    });
    menu.addEventListener('hidden.bs.collapse', function () {
      localStorage.setItem(menu.id, 'hide');
      const trigger = document.querySelector(`[href="#${menu.id}"], [data-bs-target="#${menu.id}"]`);
      if (trigger) trigger.querySelector('.arrow-icon')?.classList.remove('rotate');
    });
  });
});

