<nav class="navbar navbar-expand-lg ds-topbar sticky-top">
  <div class="container px-3">
    <a class="navbar-brand d-flex align-items-center text-white fw-bold me-3" href="{{ url('/') }}">
      <img src="{{ asset('images/dinas-sosial.png') }}" alt="Logo Dinas Sosial" class="me-2 ds-logo">
    </a>

    <ul class="navbar-nav ms-auto d-none d-lg-flex">
      <li class="nav-item"><a class="nav-link text-white px-3" href="{{ url('/') }}">BERANDA</a></li>
      <li class="nav-item"><a class="nav-link text-white px-3" href="{{ url('/profil') }}">PROFIL</a></li>
      <li class="nav-item"><a class="nav-link text-white px-3" href="{{ url('/layanan') }}">LAYANAN</a></li>
      <li class="nav-item"><a class="nav-link text-white px-3" href="{{ url('/berita') }}">BERITA</a></li>
      <li class="nav-item"><a class="nav-link text-white px-3" href="{{ url('/download') }}">DOWNLOAD</a></li>
      <li class="nav-item"><a class="nav-link text-white px-3" href="{{ url('/ppid') }}">PPID</a></li>
      <li class="nav-item"><a class="nav-link text-white px-3" href="{{ url('/kontak') }}">KONTAK</a></li>
      <li class="nav-item ms-2">
        <a id="search-icon-btn-desktop" class="nav-link text-white" href="#" aria-label="Cari"><i class="bi bi-search ds-icon"></i></a>
      </li>
    </ul>

    <div class="d-flex d-lg-none align-items-center gap-3 ms-auto">
      <a id="search-icon-btn-mobile" class="nav-link text-white p-0" href="#" aria-label="Cari"><i class="bi bi-search ds-icon"></i></a>
      <button id="ds-hamburger"
              class="btn p-0 text-white"
              type="button"
              aria-expanded="false"
              aria-controls="ds-mobile-panel"
              aria-label="Menu">
        <i class="bi bi-list ds-icon"></i>
      </button>
    </div>
  </div>
</nav>

<div id="search-panel" class="ds-search-panel">
  <div class="container">
    <form action="{{ url('/pencarian') }}" method="GET" class="ds-search-box">
        <input name="keyword" type="text" class="form-control" placeholder="Ketik pencarian Anda di sini..." required>
        <button type="submit" class="btn btn-primary">Cari</button>
        <button id="close-search-btn" type="button" class="btn-close" aria-label="Tutup Pencarian"></button>
    </form>
  </div>
</div>

<div class="ds-mobile-panel" id="ds-mobile-panel" hidden>
  <div class="container ds-mobile-menu">
    <a class="nav-link" href="{{ url('/') }}">BERANDA</a>
    <a class="nav-link" href="{{ url('/profil') }}">PROFIL</a>
    <a class="nav-link" href="{{ url('/layanan') }}">LAYANAN</a>
    <a class="nav-link" href="{{ url('/berita') }}">BERITA</a>
    <a class="nav-link" href="{{ url('/download') }}">DOWNLOAD</a>
    <a class="nav-link" href="{{ url('/ppid') }}">PPID</a>
    <a class="nav-link" href="{{ url('/kontak') }}">KONTAK</a>
  </div>
</div>

<div class="ds-overlay" id="ds-overlay" hidden></div>

@push('scripts')
<script>
(function () {
  const btn     = document.getElementById('ds-hamburger');
  const panel   = document.getElementById('ds-mobile-panel');
  const overlay = document.getElementById('ds-overlay');
  const topbar  = document.querySelector('.ds-topbar');

  if (!btn || !panel || !overlay || !topbar) {
    return;
  }

  function setPositions() {
    const topbarHeight = topbar.offsetHeight;
    panel.style.top = topbarHeight + 'px';
    overlay.style.top = topbarHeight + 'px';
  }

  function openPanel(){
    setPositions();
    panel.removeAttribute('hidden');
    void panel.offsetHeight;
    panel.classList.add('open');
    overlay.removeAttribute('hidden');
    void overlay.offsetHeight;
    overlay.classList.add('show');
    btn.setAttribute('aria-expanded','true');
    btn.innerHTML = '<i class="bi bi-x ds-icon"></i>';
    document.body.style.overflow = 'hidden';
  }

  function closePanel(){
    panel.classList.remove('open');
    overlay.classList.remove('show');
    btn.setAttribute('aria-expanded','false');
    btn.innerHTML = '<i class="bi bi-list ds-icon"></i>';
    document.body.style.overflow = '';
    function onTransitionEnd() {
      panel.setAttribute('hidden','');
      overlay.setAttribute('hidden','');
      panel.removeEventListener('transitionend', onTransitionEnd);
    }
    panel.addEventListener('transitionend', onTransitionEnd);
  }

  function togglePanel(){
    const isHidden = panel.hasAttribute('hidden');
    isHidden ? openPanel() : closePanel();
  }

  btn.addEventListener('click', togglePanel);
  overlay.addEventListener('click', closePanel);
  panel.addEventListener('click', (e) => {
    if (e.target.matches('.nav-link')) {
      closePanel();
    }
  });
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 992 && !panel.hasAttribute('hidden')) {
      closePanel();
    }
    if (!panel.hasAttribute('hidden')) {
        setPositions();
    }
  });
  setPositions();
})();
</script>

<script>
(function () {
  const searchButtons = [
      document.getElementById('search-icon-btn-desktop'),
      document.getElementById('search-icon-btn-mobile')
  ];
  const searchPanel = document.getElementById('search-panel');
  const closeSearchButton = document.getElementById('close-search-btn');
  const searchInput = searchPanel.querySelector('input');
  const topbar = document.querySelector('.ds-topbar');

  if (!searchButtons.length || !searchPanel || !closeSearchButton || !searchInput || !topbar) {
      return;
  }

  function openSearchPanel() {
    const topbarHeight = topbar.offsetHeight;
    searchPanel.style.top = topbarHeight + 'px';
    searchPanel.classList.add('open');
    searchInput.focus();
  }

  function closeSearchPanel() {
    searchPanel.classList.remove('open');
  }

  searchButtons.forEach(button => {
    if (button) {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const isPanelOpen = searchPanel.classList.contains('open');
        isPanelOpen ? closeSearchPanel() : openSearchPanel();
      });
    }
  });

  closeSearchButton.addEventListener('click', closeSearchPanel);
})();
</script>
@endpush
