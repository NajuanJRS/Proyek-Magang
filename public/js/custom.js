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
        const title = seeMoreBtn.getAttribute('data-judul') || 'Detail Data';
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
    });

    // 1. Inisialisasi TinyMCE
    if (typeof tinymce !== 'undefined') {
        tinymce.remove('textarea.my-editor');
        tinymce.init({
            selector: 'textarea.my-editor',
            height: 400,
            setup: function (editor) {
                editor.on('change', function () { tinymce.triggerSave(); });
            }
        });
    }

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

    // 3. Inisialisasi Logika Final untuk Sidebar
    const sidebar = document.getElementById('sidebarMenu');
    if (sidebar) {
        const activeMenuId = sidebar.getAttribute('data-active-menu');
        sidebar.style.overflowY = 'hidden';

        const collapseElements = document.querySelectorAll('.sidebar .collapse');
        const collapseInstances = Array.from(collapseElements).map(el => {
            return new bootstrap.Collapse(el, { toggle: false });
        });

        collapseInstances.forEach(instance => {
            const menuElement = instance._element;
            const trigger = document.querySelector(`a[href="#${menuElement.id}"]`);
            const arrow = trigger ? trigger.querySelector('.arrow-icon') : null;

            if (menuElement.id === activeMenuId) {
                if (arrow) {
                    arrow.classList.remove('bi-chevron-down');
                    arrow.classList.add('bi-chevron-up');
                }
                setTimeout(() => { instance.show(); }, 10);
            } else {
                instance.hide();
                if (arrow) {
                    arrow.classList.remove('bi-chevron-up');
                    arrow.classList.add('bi-chevron-down');
                }
            }
        });

        document.querySelectorAll('.sidebar [data-bs-toggle="collapse"]').forEach(trigger => {
            const targetMenu = document.querySelector(trigger.getAttribute('href'));
            if (!targetMenu) return;

            targetMenu.addEventListener('show.bs.collapse', function () {
                const arrow = trigger.querySelector('.arrow-icon');
                if (arrow) {
                    arrow.classList.remove('bi-chevron-down');
                    arrow.classList.add('bi-chevron-up');
                }
            });

            targetMenu.addEventListener('hide.bs.collapse', function () {
                const arrow = trigger.querySelector('.arrow-icon');
                if (arrow) {
                    arrow.classList.remove('bi-chevron-up');
                    arrow.classList.add('bi-chevron-down');
                }
            });

            targetMenu.addEventListener('shown.bs.collapse', function () {
                sidebar.style.overflowY = 'auto';
            });
        });

        const activeDropdown = document.querySelector(`.collapse#${activeMenuId}`);
        if (!activeDropdown) {
             setTimeout(() => { sidebar.style.overflowY = 'auto'; }, 100);
        }

        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
             sidebarToggle.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-is-minimized');
                sidebar.classList.toggle('sidebar-minimized');
                document.querySelector('.content').classList.toggle('sidebar-minimized');
                const isMinimized = sidebar.classList.contains('sidebar-minimized');
                document.getElementById('logoFull').classList.toggle('d-none', isMinimized);
                document.getElementById('logoMini').classList.toggle('d-none', !isMinimized);
            });
        }

        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
        if (mobileSidebarToggle) {
            let backdrop = null;

            const openMobileSidebar = () => {
                if (window.innerWidth >= 992) return;
                sidebar.classList.add('show');
                document.body.classList.add('no-scroll');
                if (!backdrop) {
                    backdrop = document.createElement('div');
                    backdrop.className = 'sidebar-backdrop';
                    document.body.appendChild(backdrop);
                    backdrop.addEventListener('click', closeMobileSidebar);
                }
                setTimeout(() => backdrop.classList.add('show'), 10);
            };

            const closeMobileSidebar = () => {
                if (window.innerWidth >= 992) return;
                sidebar.classList.remove('show');
                document.body.classList.remove('no-scroll');
                if (backdrop) {
                    backdrop.classList.remove('show');
                    setTimeout(() => {
                        backdrop.remove();
                        backdrop = null;
                    }, 300);
                }
            };

            mobileSidebarToggle.addEventListener('click', function() {
                if (sidebar.classList.contains('show')) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    closeMobileSidebar();
                }
            });
        }

        // Logika Hover-to-expand saat minimized
        sidebar.addEventListener('click', function(event) {
            if (sidebar.classList.contains('sidebar-minimized')) {
                const trigger = event.target.closest('[data-bs-toggle="collapse"]');
                if (trigger) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            }
        });
    }

