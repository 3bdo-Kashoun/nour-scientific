@extends('layouts.layout')
@section('title', ' - الصفحة الرئيسية')
@push('styles')
 <link rel="stylesheet" href="pages/index.css">
@endpush
@section('content')
 <section class="hero">
        <div class="container hero-content slide-up">
            <h1 class="slide-up">نور العلمية للكيماويات</h1>

            <p class="slide-up">شريككم الموثوق في توريد المواد الكيميائية وتصنيع المواد عالية الجودة للصناعات المتقدمة.
            </p>

            <!-- الأزرار التنقل -->
            <div class="btn-group">
                <a href="pages/proudct.html" class="btn btn-primary slide-up">استكشف منتجاتنا</a>
                <a href="pages/contact.html" class="btn btn-secondary slide-up">تواصل معنا <i
                        class="fas fa-arrow-left"></i></a>
            </div>
        </div>
    </section>
    <section class="features">
        <div class="container">
            <h2 class="section-title reveal">لماذا نور العلمية؟</h2>
            <span class="section-subtitle reveal">الجودة والثقة في كل منتج نقدمه لعملائنا</span>
            <!-- div التعريف -->
            <div class="cards-grid">
                @include('partials.featureCard',[
                    'title'=>'منتجات عالية الجودة',
                    'description'=>'مواد كيميائية من أفضل المصادر العالمية لضمان كفاءة منتجاتكم الصناعية',
                    'icon'=>'fa-flask-vial'
                ])
                @include('partials.featureCard',[
                    'title'=>'معايير السلامة',
                    'description'=>'التزام كامل بمعايير ISO والسلامة البيئية في النقل والتخزين والتصنيع.',
                    'icon'=>'fa-shield-halved'
                ])
                @include('partials.featureCard',[
                    'title'=>'خبرة 30+ عام',
                    'description'=>'سنوات من الخبرة في المجال الكيميائي تضعنا في مقدمة الموردين المعتمدين.',
                    'icon'=>'fa-certificate'
                ])

            </div>
        </div>
    </section>
      <section class="services-section">
        <div class="container">
            <h2 class="section-title reveal"> خدماتنــا</h2>
            <div class="services-grid">
                <!-- خدمة 1 -->
               <x-service-card
                    title="توريد المواد الكيميائية"
                    description="نوفر مجموعة واسعة من المواد الكيميائية عالية الجودة لتلبية احتياجات صناعاتكم المختلفة."
                    feature1="مواد كيميائية نقية"
                    feature2="توصيل سريع"
                    feature3="أسعار تنافسية"
                    icon="fa-truck-fast"
                    />

                <!-- خدمة 2 -->
                <x-service-card
                    title=" دعم فني متخصص"
                    description="فريق من الخبراء جاهز لمساعدتك في اختيار المنتجات المناسبة."
                    feature1="استشارات مجانية"
                    feature2="دعم على مدار الساعة"
                    feature3="حلول مخصصة "
                    icon="fa-users-gear"
                    />

                <!-- خدمة 3 -->
                <x-service-card
                    title="شهادات معتمدة"
                    description="نحمل شهادات الجودة ISO وجميع التراخيص اللازمة."
                    feature1="ISO 9001:2015"
                    feature2="شهادات السلامة"
                    feature3="تراخيص حكومية"
                    icon="fa-award"
                    />


                <!-- خدمة 4 -->
                <x-service-card
                    title="حلول مخصصة"
                    description="نقدم حلول كيميائية مصممة خصيصاً لتلبية احتياجاتك."
                    feature1=" تركيبات خاصة"
                    feature2=" كميات مرنة"
                    feature3=" توصيل سريع"
                    icon="fa-cogs"
                    />
                
                </div>
            </div>
        </div>
    </section>
 @endsection
