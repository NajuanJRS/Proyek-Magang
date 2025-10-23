function togglePassword() {
    const password = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        password.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
}

function toggleConfirmPassword() {
    const input = document.getElementById('password_confirmation');
    const icon = document.getElementById('toggleIconConfirm');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
}

// Fungsi Hapus Data dengan SweetAlert2
window.deleteData = function (id) {
    if (typeof Swal === 'undefined') {
        if (confirm('Yakin ingin menghapus data ini?')) {
            document.getElementById('delete-form-' + id)?.submit();
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
            document.getElementById('delete-form-' + id)?.submit();
        }
    });
};

// Fungsi Toggle Password
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

// Fungsi Image Preview (untuk tambah & edit)
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
            newPreview.src = e.target.result;
            newPreview.style.display = 'block';
            if (oldPreview) oldPreview.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        newPreview.src = "#";
        newPreview.style.display = 'none';
        if (oldPreview) oldPreview.style.display = 'block';
    }
}

// ====== BAGIAN 2: LISTENER "LIHAT SELENGKAPNYA" ======
document.addEventListener('click', function (e) {
    const seeMoreBtn = e.target.closest('.see-more');
    if (seeMoreBtn) {
        e.preventDefault();
        const id = seeMoreBtn.getAttribute('data-id');
        const title = seeMoreBtn.getAttribute('data-judul') || 'Detail Konten';
        const contentEl = document.getElementById('full-content-' + id);
        const htmlContent = contentEl ? contentEl.innerHTML : '';
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: title,
                html: '<div style="text-align:left;max-height:60vh;overflow:auto;">' + htmlContent + '</div>',
                width: 800,
                confirmButtonText: 'Tutup'
            });
        }
    }
});

    // PENTING: Hancurkan (dispose) instance Bootstrap Collapse lama untuk mencegah konflik
    document.querySelectorAll('.sidebar .collapse').forEach(el => {
        const instance = bootstrap.Collapse.getInstance(el);
        if (instance) {
            instance.dispose();
        }
    })

    // 2. Inisialisasi Logika Spesifik Halaman (Search, Tombol Tambah)
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        const tableRows = document.querySelectorAll("tbody tr");
        searchInput.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            tableRows.forEach((row) => {
                const cells = row.querySelectorAll("td");
                const combinedText = (cells[1]?.textContent.toLowerCase() || "") + " " + (cells[2]?.textContent.toLowerCase() || "");
                row.style.display = (searchTerm.length < 3 || combinedText.includes(searchTerm)) ? "" : "none";
            });
        });
    }

    const btn2 = document.getElementById("toggle-tombol2");
    if (btn2) {
        const btn3 = document.getElementById("toggle-tombol3");
        const tombol2 = document.getElementById("tombol2");
        const tombol3 = document.getElementById("tombol3");
        btn2.addEventListener("click", function () {
            const isTombol2Hidden = tombol2.style.display === "none" || tombol2.style.display === "";
            tombol2.style.display = isTombol2Hidden ? "block" : "none";
            btn2.innerText = isTombol2Hidden ? "− Tutup 2" : "+ Tambah 2";
            if (!isTombol2Hidden) {
                tombol3.style.display = "none";
                if (btn3) btn3.innerText = "+ Tambah 3";
            }
        });
        if (btn3) {
            btn3.addEventListener("click", function () {
                const isTombol3Hidden = tombol3.style.display === "none" || tombol3.style.display === "";
                tombol3.style.display = isTombol3Hidden ? "block" : "none";
                btn3.innerText = isTombol3Hidden ? "− Tutup 3" : "+ Tambah 3";
            });
        }
    }

    // === Multiple Custom Editors ===
document.addEventListener("DOMContentLoaded", function () {
    const allEditors = [
        { id: "editor1", hidden: "hiddenContent1" },
        { id: "editor2", hidden: "hiddenContent2" },
        { id: "editor3", hidden: "hiddenContent3" },
    ];

    // Toolbar logic
    document.querySelectorAll(".editor-toolbar button").forEach(btn => {
        btn.addEventListener("click", () => {
            const cmd = btn.dataset.command;
            const target = btn.dataset.target;
            const editor = document.getElementById(target);

            if (!editor) return;

            if (cmd === "createLink") {
                const url = prompt("Masukkan URL:");
                if (url) document.execCommand("createLink", false, url);
            } else if (cmd === "insertImage") {
                const imgUrl = prompt("Masukkan URL gambar:");
                if (imgUrl) document.execCommand("insertImage", false, imgUrl);
            } else {
                document.execCommand(cmd, false, null);
            }
            editor.focus();
        });
    });

    // Sync editor content before submit
    const form = document.querySelector("form");
    if (form) {
        form.addEventListener("submit", () => {
            allEditors.forEach(ed => {
                const editor = document.getElementById(ed.id);
                const hidden = document.getElementById(ed.hidden);
                if (editor && hidden) hidden.value = editor.innerHTML;
            });
        });
    }
});


    // === 3. Inisialisasi Logika Final untuk Sidebar ===
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebarMenu');
    if (!sidebar) return;

    const logoFull = document.getElementById('logoFull');
    const logoMini = document.getElementById('logoMini');
    const content = document.querySelector('.content');

    // === 1. Pulihkan status sidebar lebih dulu ===
    const savedState = localStorage.getItem('sidebarState');
    const isMinimized = savedState === 'minimized';

    if (isMinimized) {
        document.body.classList.add('sidebar-is-minimized');
        sidebar.classList.add('sidebar-minimized');
        if (content) content.classList.add('sidebar-minimized');
        if (logoFull && logoMini) {
            logoFull.classList.add('d-none');
            logoMini.classList.remove('d-none');
        }
    } else {
        document.body.classList.remove('sidebar-is-minimized');
        sidebar.classList.remove('sidebar-minimized');
        if (content) content.classList.remove('sidebar-minimized');
        if (logoFull && logoMini) {
            logoFull.classList.remove('d-none');
            logoMini.classList.add('d-none');
        }
    }

    // === 2. Inisialisasi collapse setelah state sidebar diterapkan ===
    const activeMenuId = sidebar.getAttribute('data-active-menu');
    const collapseElements = sidebar.querySelectorAll('.collapse');

    collapseElements.forEach(el => {
        const instance = new bootstrap.Collapse(el, { toggle: false });
        const trigger = document.querySelector(`a[href="#${el.id}"]`);
        const arrow = trigger ? trigger.querySelector('.arrow-icon') : null;

        if (isMinimized) {
            // Saat sidebar minimized → pastikan semua tertutup
            instance.hide();
            if (arrow) {
                arrow.classList.remove('bi-chevron-up');
                arrow.classList.add('bi-chevron-down');
            }
        } else {
            // Saat sidebar normal → buka menu aktif
            if (el.id === activeMenuId) {
                if (arrow) {
                    arrow.classList.remove('bi-chevron-down');
                    arrow.classList.add('bi-chevron-up');
                }
                setTimeout(() => instance.show(), 10);
            } else {
                instance.hide();
                if (arrow) {
                    arrow.classList.remove('bi-chevron-up');
                    arrow.classList.add('bi-chevron-down');
                }
            }
        }
    });

    // === 3. Tombol toggle sidebar ===
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            const currentlyMinimized = sidebar.classList.toggle('sidebar-minimized');
            document.body.classList.toggle('sidebar-is-minimized', currentlyMinimized);
            if (content) content.classList.toggle('sidebar-minimized', currentlyMinimized);

            // Simpan ke localStorage
            localStorage.setItem('sidebarState', currentlyMinimized ? 'minimized' : 'expanded');

            // Tutup semua dropdown saat minimize
            document.querySelectorAll('.sidebar .collapse.show').forEach(el => {
                const inst = bootstrap.Collapse.getInstance(el) || new bootstrap.Collapse(el, { toggle: false });
                inst.hide();
            });

            // Toggle logo
            if (logoFull && logoMini) {
                logoFull.classList.toggle('d-none', currentlyMinimized);
                logoMini.classList.toggle('d-none', !currentlyMinimized);
            }
        });
    }

    const successAlertElement = document.getElementById('session-success-toast');
    if (successAlertElement) {
    const message = successAlertElement.getAttribute('data-message');
    if (message) {
        Swal.fire({
            title: 'Berhasil!',
            text: message,
            icon: 'success',
            confirmButtonColor: '#3085d6', // Warna tombol OK
            confirmButtonText: 'OK'
        });
    }
}
});


(function () {
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebarMenu') || document.querySelector('.sidebar');
    if (!sidebar) return;

    const triggers = sidebar.querySelectorAll('[data-bs-toggle="collapse"]');
    const overlays = {};      // overlay element per targetSelector
    const timers = {};        // hide timers per targetSelector
    const pinned = {};        // pinned state per targetSelector (true if clicked/pinned)

    function makeOverlay(menuEl) {
      const ov = document.createElement('div');
      ov.className = 'sidebar-mini-overlay';
      const clone = menuEl.cloneNode(true);
      clone.querySelectorAll('[id]').forEach(n => n.removeAttribute('id'));
      clone.classList.remove('collapse','show');
      // remove any nested collapse triggers to avoid duplicated behavior
      clone.querySelectorAll('[data-bs-toggle]').forEach(n => n.removeAttribute('data-bs-toggle'));
      ov.appendChild(clone);
      document.body.appendChild(ov);
      return ov;
    }

    function positionAndShowOverlay(ov, rect) {
      if (!ov) return;
      const sbRect = sidebar.getBoundingClientRect();
      const left = sbRect.right + 8;
      let top = rect.top;
      // adjust top so overlay fits in viewport
      if (top + ov.offsetHeight > window.innerHeight - 12) {
        top = Math.max(8, window.innerHeight - ov.offsetHeight - 12);
      }
      ov.style.left = left + 'px';
      ov.style.top = top + 'px';
      ov.style.display = 'block';
      requestAnimationFrame(() => ov.classList.add('show'));
    }

    function hideOverlayImmediate(targetSelector, force = false) {
      const ov = overlays[targetSelector];
      if (!ov) return;
      // if pinned and not forced, keep it
      if (pinned[targetSelector] && !force) return;
      ov.classList.remove('show');
      ov.style.display = 'none';
      const trigger = document.querySelector(`[href="${targetSelector}"], [data-bs-target="${targetSelector}"]`);
      if (trigger) trigger.setAttribute('aria-expanded', 'false');
      pinned[targetSelector] = false;
      clearTimeout(timers[targetSelector]);
      timers[targetSelector] = null;
    }

    function hideAllOverlays(force = false) {
      Object.keys(overlays).forEach(sel => hideOverlayImmediate(sel, force));
    }

    triggers.forEach(trigger => {
      const targetSelector = trigger.getAttribute('href') || trigger.getAttribute('data-bs-target');
      if (!targetSelector) return;
      const menuEl = document.querySelector(targetSelector);
      if (!menuEl) return;

      // ensure initial states
      pinned[targetSelector] = false;
      timers[targetSelector] = null;

      // create overlay on demand
      function ensureOverlay() {
        if (!overlays[targetSelector]) overlays[targetSelector] = makeOverlay(menuEl);
        return overlays[targetSelector];
      }

      // hover: show overlay temporarily (unless pinned)
      trigger.addEventListener('mouseenter', () => {
        const isMin = sidebar.classList.contains('sidebar-minimized') ||
                      document.body.classList.contains('nav-collapsed') ||
                      document.body.classList.contains('sidebar-is-minimized');
        if (!isMin) return;
        // hide other non-pinned overlays immediately
        Object.keys(overlays).forEach(sel => { if (!pinned[sel]) hideOverlayImmediate(sel); });
        const ov = ensureOverlay();
        clearTimeout(timers[targetSelector]);
        const rect = trigger.getBoundingClientRect();
        positionAndShowOverlay(ov, rect);
        trigger.setAttribute('aria-expanded', 'true');
      });

      // leave trigger -> schedule hide only if not pinned
      trigger.addEventListener('mouseleave', () => {
        if (pinned[targetSelector]) return;
        clearTimeout(timers[targetSelector]);
        timers[targetSelector] = setTimeout(() => hideOverlayImmediate(targetSelector), 120);
      });

      // overlay mouseenter cancels hide timer
      document.addEventListener('mouseover', function (ev) {
        const ov = overlays[targetSelector];
        if (!ov) return;
        if (ov.contains(ev.target)) {
          clearTimeout(timers[targetSelector]);
        }
      });

      // overlay mouseleave: hide only if not pinned
      document.addEventListener('mouseleave', function (ev) {
        const ov = overlays[targetSelector];
        if (!ov) return;
        // ignore if leaving document; rely on global click to hide pinned
        if (!ov.contains(ev.target) && !sidebar.contains(ev.target) && !pinned[targetSelector]) {
          hideOverlayImmediate(targetSelector);
        }
      }, true);

      // click toggles pinned state (kept visible until clicked again or clicked outside)
      trigger.addEventListener('click', function (e) {
        const isMin = sidebar.classList.contains('sidebar-minimized') ||
                      document.body.classList.contains('nav-collapsed') ||
                      document.body.classList.contains('sidebar-is-minimized');
        if (!isMin) return; // in normal mode, allow default collapse
        e.preventDefault();
        // hide other overlays (including pinned) to ensure exclusive pinned overlay
        hideAllOverlays(true);
        const ov = ensureOverlay();
        const rect = trigger.getBoundingClientRect();
        positionAndShowOverlay(ov, rect);
        pinned[targetSelector] = true;
        trigger.setAttribute('aria-expanded', 'true');
      });
    });

    // global: click outside -> hide all overlays (including pinned)
    document.addEventListener('click', function (e) {
      if (e.target.closest('.sidebar') || e.target.closest('.sidebar-mini-overlay')) return;
      hideAllOverlays(true);
    });

    // hide overlays on resize/scroll to avoid stuck overlays
    window.addEventListener('resize', () => hideAllOverlays(true));
    window.addEventListener('scroll', () => hideAllOverlays(true), true);
  });
})();

(function () {
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebarMenu');
    if (!sidebar) return;

    const collapseTriggers = Array.from(sidebar.querySelectorAll('[data-bs-toggle="collapse"]'));

    function storeAndDisableTrigger(t) {
      if (t.dataset.origBsToggle) return;
      t.dataset.origBsToggle = t.getAttribute('data-bs-toggle') || '';
      t.dataset.origHref = t.getAttribute('href') || '';
      // remove the bootstrap toggle so it cannot open the inline collapse
      t.removeAttribute('data-bs-toggle');
      if (t.getAttribute('href')) t.removeAttribute('href');
      t.setAttribute('aria-expanded', 'false');
    }

    function restoreTrigger(t) {
      if (!t.dataset.origBsToggle) return;
      if (t.dataset.origBsToggle) t.setAttribute('data-bs-toggle', t.dataset.origBsToggle);
      if (t.dataset.origHref && t.dataset.origHref !== '') t.setAttribute('href', t.dataset.origHref);
      delete t.dataset.origBsToggle;
      delete t.dataset.origHref;
    }

    function collapseAllInlineMenus() {
      const openCollapses = sidebar.querySelectorAll('.collapse.show');
      openCollapses.forEach(el => {
        const inst = bootstrap.Collapse.getInstance(el);
        if (inst) inst.hide();
        else new bootstrap.Collapse(el, { toggle: false }).hide();
      });
    }

    function setCollapseTriggersDisabled(disabled) {
      if (disabled) {
        collapseTriggers.forEach(storeAndDisableTrigger);
        collapseAllInlineMenus();
      } else {
        collapseTriggers.forEach(restoreTrigger);
      }
    }

    // Initialize based on current state
    const isInitMin = sidebar.classList.contains('sidebar-minimized') ||
                      document.body.classList.contains('sidebar-is-minimized') ||
                      document.body.classList.contains('nav-collapsed');
    if (isInitMin) setCollapseTriggersDisabled(true);

    // Listen to sidebar toggle(s) to update state
    const sidebarToggleButtons = [
      document.getElementById('sidebarToggle'),
      document.getElementById('mobileSidebarToggle')
    ].filter(Boolean);

    sidebarToggleButtons.forEach(btn => {
      btn.addEventListener('click', function () {
        // small timeout to allow class toggles in other handlers to apply first
        setTimeout(() => {
          const isMin = sidebar.classList.contains('sidebar-minimized') ||
                        document.body.classList.contains('sidebar-is-minimized') ||
                        document.body.classList.contains('nav-collapsed');
          setCollapseTriggersDisabled(isMin);
        }, 40);
      });
    });

    // Ensure restoring when resizing to desktop and sidebar auto-restores
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 992) {
        // when switching back to desktop, always restore triggers
        setCollapseTriggersDisabled(false);
      } else {
        // on mobile keep normal behavior (we don't want inline collapses while overlay)
        setCollapseTriggersDisabled(true);
      }
    });

    // also ensure click inside minimized sidebar does not accidentally expand inline
    sidebar.addEventListener('click', function (event) {
      if (sidebar.classList.contains('sidebar-minimized') ||
          document.body.classList.contains('sidebar-is-minimized') ||
          document.body.classList.contains('nav-collapsed')) {
        const trigger = event.target.closest('[data-bs-toggle="collapse"], a[data-bs-toggle="collapse"]');
        if (trigger) {
          event.preventDefault();
          event.stopPropagation();
        }
      }
    }, true);
  });

  document.querySelectorAll('.sidebar [data-bs-toggle="collapse"]').forEach(trigger => {
    const targetMenu = document.querySelector(trigger.getAttribute('href'));
    if (!targetMenu) return;
    const arrow = trigger.querySelector('.arrow-icon');

    // Pastikan semua panah awal mengarah ke bawah
    if (arrow) {
        arrow.classList.remove('bi-chevron-up');
        arrow.classList.add('bi-chevron-down');
    }

    // Saat menu mulai dibuka → arahkan ke atas
    targetMenu.addEventListener('show.bs.collapse', () => {
        if (arrow) {
            arrow.classList.remove('bi-chevron-down');
            arrow.classList.add('bi-chevron-up');
        }
    });

    // Saat menu mulai ditutup → arahkan ke bawah
    targetMenu.addEventListener('hide.bs.collapse', () => {
        if (arrow) {
            arrow.classList.remove('bi-chevron-up');
            arrow.classList.add('bi-chevron-down');
        }
    });
});
})();
