@extends('layouts.app')

@section('content')
    <section class="py-10 sm:py-16 lg:py-20 relative overflow-hidden mesh-grid">
        <div class="orb -top-16 -left-10 w-72 h-72 bg-accent/20"></div>
        <div class="orb bottom-0 -right-10 w-80 h-80 bg-accent/10"></div>
        <div class="wrap max-w-4xl relative">
            <a href="{{ url('/#start') }}" class="inline-flex items-center gap-2 text-sm text-muted hover:text-primary mb-10">
                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                العودة للملفات
            </a>

            <article @class(['rounded-3xl sm:rounded-[2.5rem] border p-5 sm:p-8 lg:p-12 shadow-soft', 'bg-accent text-primary border-accent' => $digitalProduct->is_featured, 'bg-white border-line' => ! $digitalProduct->is_featured])>
                <div class="flex items-start justify-between gap-4 mb-6">
                    <span class="file-number shrink-0">{{ $digitalProduct->step_number }}</span>
                    <div class="min-w-0 flex-1 text-right">
                        <p class="text-sm font-bold mb-3 {{ $digitalProduct->is_featured ? 'text-primary/70' : 'text-accent' }}">{{ $digitalProduct->label }}</p>
                        <h1 class="text-2xl sm:text-3xl lg:text-5xl font-bold leading-tight mb-2">{{ $digitalProduct->title }}</h1>
                        <p class="text-sm mb-4 {{ $digitalProduct->is_featured ? 'text-primary/60' : 'text-muted' }}">{{ $digitalProduct->displaySales() }}</p>
                        <p class="text-lg {{ $digitalProduct->is_featured ? 'text-primary/80' : 'text-muted' }}">{{ $digitalProduct->description }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4 mb-10">
                    @if($digitalProduct->displayOldPrice())
                        <span class="text-lg line-through opacity-60">{{ $digitalProduct->displayOldPrice() }}</span>
                    @endif
                    <span class="text-2xl font-bold">{{ $digitalProduct->displayPrice() }}</span>
                    @if($digitalProduct->savingsAmount())
                        <span class="pill">وفر {{ $digitalProduct->savingsAmount() }}</span>
                    @endif
                </div>

                <div class="prose-file {{ $digitalProduct->is_featured ? 'text-primary/90' : 'text-muted' }}">
                    {!! nl2br(e($digitalProduct->full_description ?: $digitalProduct->description)) !!}
                </div>

                <div class="mt-12">
                    @if($digitalProduct->is_coming_soon)
                        <span class="file-cta file-cta-soon">قريبًا</span>
                    @elseif($digitalProduct->is_free && $digitalProduct->fileUrl())
                        <a href="{{ $digitalProduct->downloadUrl() }}" class="btn btn-acc" download="{{ $digitalProduct->asciiDownloadFilename() }}">تحميل مجاني</a>
                    @elseif($digitalProduct->is_free)
                        <span class="file-cta file-cta-soon">سيتوفر التحميل قريبًا</span>
                    @else
                        <a href="{{ url('/#consult') }}" class="btn btn-acc">احصل عليه</a>
                    @endif
                </div>
            </article>
        </div>
    </section>
@endsection
