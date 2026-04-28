@extends('layouts.layout')
@section('title', '- من نحن')
@push('styles')
    <link rel="stylesheet" href="pages/about.css">
@endpush
@section('content')
    <section class="hero reveal">
        <span class="section-tag">من نحن</span>
        <h1>تُعد شركة نور العلمية من الشركات الرائدة في ليبيا</h1>
        <br>
        <div class="container ">
            <p style="width: 80%; margin: 0 auto;">في مجال توريد المواد الكيميائية وتجهيز المختبرات
                من زجاجيات، وأثاث مخبري، ومعدات علمية متكاملة,
                على مدى أكثر من 40 عامًا،
                قدّمنا خدماتنا باحترافية للمختبرات الليبية في الجامعات والمستشفيات والمصانع والمراكز البحثية، مما
                جعلنا من أهم شركاء تطوير البنية العلمية في ليبيا,

                نتعامل مع أبرز الشركات العالمية المتخصصة في هذا القطاع،
                ونوفّر منتجات عالية الجودة من مختلف دول العالم، مع التركيز
                على المعايير الدولية في السلامة والدقة, كما نقدم استشارات فنية تساعد عملاءنا عل
                ى اختيار التجهيزات الأنسب لضمان أعلى أداء وكفاءة داخل المختبر.</p>
        </div>
    </section>
    <section class="stats-container reveal">
        @foreach ($stats as $stat)
            <x-stat-card icon="{{ $stat['icon'] }}" title="{{ $stat['title'] }}" datatarget="{{ $stat['target'] }}"
                number="{{ $stat['number'] }}" />
        @endforeach
    </section>
    <section class="vision-mission reveal">
        <div class="section-header" style="padding-top:0;">
            <h2>رؤيتنا ورسالتنا</h2>
        </div>
        <div class="vm-container">
            <div class="vm-card">
                <i class="fa-solid fa-eye" style="font-size:3rem; margin-bottom:20px;"></i>
                <h3>رؤيتنا</h3>
                <p>أن نكون المزوّد الأول والأكثر موثوقية في ليبيا لحلول وتجهيزات المختبرات،
                    وأن نساهم في دعم وتطوير القطاع العلمي
                    والبحثي من خلال توفير منتجات عالمية مبتكرة تلبي متطلبات التقدم العلمي.</p>
            </div>
            <div class="vm-card">
                <i class="fa-solid fa-paper-plane" style="font-size:3rem; margin-bottom:20px;"></i>
                <h3>رسالتنا</h3>
                <p>تتمثل رسالتنا في توفير أفضل جودة ممكن
                    ة من المواد والمعدات المخبرية لضمان سلامة وكفاءة المختبرات في جميع مناطق ليبيا.
                    <br>
                    ونلتزم بتقديم منتجات موثوقة من الش. .
                    ركات الرائدة عالميًا، مع الحرص على الدقة، والاحترافية، والاستجابة لاحتياجات العملاء بأعلى مستوى من
                    الجودة.
                </p>
            </div>
        </div>
    </section>
    <section class="reveal">
        <div class="section-header">
            <h2>شركاؤنا</h2>
        </div>
        <div class="partners-grid">
            @foreach ($partners as $partner)
                <x-partner-card tag="شريك عالمي" partnerName="{{ $partner['name'] }}"
                    partnerOrigin="{{ $partner['origin'] }}" logoSrc="{{ asset('images/aboutImage/' . $partner['logo']) }}"
                    logoAlt="{{ $partner['name'] }} Logo" />
            @endforeach
        </div>
    </section>
@endsection
