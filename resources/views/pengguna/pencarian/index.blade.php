@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-plain')

@section('content')

 <nav aria-label="breadcrumb" class="container my-2">
   <ol class="breadcrumb small mb-0">
     <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
     <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
   </ol>
 </nav>

 <section class="py-5">
   <div class="container">

     <div class="text-center">
       <h2 class="ds-faq-title">Hasil Pencarian</h2>
       @if(isset($keyword) && $keyword)
         <p class="ds-faq-subtitle">Menampilkan hasil pencarian untuk: "{{ $keyword }}"</p>
       @else
         <p class="ds-faq-subtitle">Temukan informasi seputar layanan, program, berita, dokumen, atau pertanyaan umum di Dinas Sosial. Ketik pertanyaan Anda di bawah atau jelajahi berdasarkan kategori.</p>
       @endif
     </div>

     <div class="ds-faq-search-wrapper mx-auto my-4">
       <form action="{{ route('pencarian.index', ['kategori' => $kategoriAktif]) }}" method="GET" class="input-group">
         <input type="search" name="keyword" class="form-control" placeholder="Masukkan kata kunci..." aria-label="Cari..." value="{{ $keyword ?? '' }}">
         <button class="btn btn-primary" type="submit" aria-label="Tombol cari">
           <i class="bi bi-search"></i>
         </button>
       </form>
     </div>

     <div class="ds-faq-filters d-flex justify-content-center flex-wrap gap-2 mb-4">
       @foreach ($filters as $filter)
         <a href="{{ route('pencarian.index', ['keyword' => $keyword, 'kategori' => $filter['slug']]) }}"
            class="btn btn-sm ds-faq-filter-btn {{ $kategoriAktif == $filter['slug'] ? 'active' : '' }}">
           {{ $filter['name'] }} <span class="ds-filter-count">{{ $filter['count'] }}</span>
         </a>
       @endforeach
     </div>

     <div class="ds-search-results-wrapper mx-auto">
       <div class="ds-results-card">
         <div class="ds-search-results-container">
           @forelse ($results as $result)
             @if($result['type'] == 'dokumen')
               <div class="ds-download-item no-border mb-3">
                 <div class="ds-download-icon">
                   <i class="bi bi-file-earmark-text"></i>
                 </div>
                 <div class="ds-download-info">
                   <h6 class="ds-download-title">{{ $result['title'] }}</h6>
                   <span class="ds-download-meta">{{ $result['category'] }}</span>
                 </div>
                 <a href="{{ $result['url'] }}" class="btn btn-outline-primary ms-auto ds-download-btn">
                   <i class="bi bi-download me-2"></i>Download
                 </a>
               </div>
             @else
               <div class="ds-search-result-item">
                 <a href="{{ $result['url'] }}" class="ds-result-title">{{ $result['title'] }}</a>
                 <div class="ds-result-meta">
                   <span class="fw-semibold">{{ $result['category'] }}</span>
                 </div>
               </div>
             @endif
           @empty
             @if($faq_results->isEmpty())
               <div class="text-center py-5">
                  <p class="text-muted">Tidak ada hasil yang ditemukan untuk "{{ $keyword ?? '' }}" {{$kategoriAktif != 'semua' ? 'dalam kategori ini' : ''}}.</p>
               </div>
             @endif
           @endforelse

           @if($faq_results->isNotEmpty())
             <div class="mt-4 @if($results->isNotEmpty()) pt-4 border-top @endif">
               <h5 class="mb-3">Pertanyaan Umum (FAQ) Terkait:</h5>
               <div class="accordion" id="faqAccordion-search">
                 @foreach($faq_results as $index => $faq)
                 <div class="accordion-item">
                   <h2 class="accordion-header" id="heading-search-{{ $index }}">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-search-{{ $index }}" aria-expanded="false" aria-controls="collapse-search-{{ $index }}">
                       {{ $faq['title'] }}
                     </button>
                   </h2>
                   <div id="collapse-search-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading-search-{{ $index }}" data-bs-parent="#faqAccordion-search">
                     <div class="accordion-body">
                       {!! $faq['answer'] !!}
                     </div>
                   </div>
                 </div>
                 @endforeach
               </div>
             </div>
           @endif
         </div>
       </div>
     </div>

   </div>
 </section>
@endsection
