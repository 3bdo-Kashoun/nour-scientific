@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="pages/contact.css">
@endpush
@section('title', '- تواصل معنا')

@section('content')
    <section class="contact-hero reveal">
        <h1 style="color:#2c3e50; font-size: 2.5rem; margin-bottom:10px;">نحن هنا لمساعدتك</h1>
        <p style="color:#777;">تواصل معنا اليوم للحصول على استشارة مجانية</p>
    </section>
    <div class="contact-wrapper reveal">

        <div class="contact-form-col">
            <form>
                <div class="form-group">
                    <label>الاسم الكامل</label>
                    <input type="text" placeholder="أدخل اسمك" required>
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" placeholder="example@email.com" required>
                </div>
                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="tel" placeholder="+218 XX XXX XXXX" required>
                </div>
                <div class="form-group">
                    <label>الرسالة</label>
                    <textarea rows="5" placeholder="اكتب رسالتك هنا..." style="resize: none;"></textarea>
                </div>
                <button type="submit" class="submit-btn">إرسال الرسالة</button>
            </form>
        </div>

        <div class="contact-info-col">
            <!-- معلومات تواصل الخاصة بالشركة -->
            <div class="c-info-card">
                <div class="c-icon"><i class="fa-solid fa-phone-volume"></i></div>
                <!-- كرت هاتف -->
                <div class="c-details">
                    <h4>اتصل بنا</h4>
                    <p dir="ltr" style="text-align: right;">+218 92 646 8875</p>
                    <p dir="ltr" style="text-align: right;">+218 21 4444 281</p>
                </div>
            </div>
            <!-- كرت الايميل -->
            <div class="c-info-card">
                <div class="c-icon"><i class="fa-regular fa-envelope"></i></div>
                <div class="c-details">
                    <h4>البريد الإلكتروني</h4>
                    <p>chetraco3@gmail.com</p>
                    <p>nuralelmiacompany@gmail.com</p>
                </div>
            </div>
            <!-- كرت العنوان -->
            <div class="c-info-card">
                <div class="c-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div class="c-details">
                    <h4>العنوان</h4>
                    <p> شارع شوقي - طرابلس</p>

                </div>
            </div>
            <!-- كرت ايام العمل -->
            <div class="c-info-card">
                <div class="c-icon"><i class="fa-regular fa-clock"></i></div>
                <div class="c-details">
                    <h4>ساعات العمل</h4>
                    <p> السبت - الخميس : 09:00 - 17:00</p>
                    <p>الجمعة : مغلق</p>
                </div>
            </div>

        </div>
    </div>
    <section class="team-section reveal">
        <div class="section-header">
            <h2>تواصل مع مهندسينا المختصين</h2>
        </div>
        <div class="team-grid">

            @foreach ($members as $member)
                <x-team-card name="{{ $member['name'] }}" role="{{ $member['role'] }}" phone="{{ $member['phone'] }}" email="{{ $member['email'] }}" />

            @endforeach
        </div>
    </section>
    <div class="map-section" id="map">
        <div
            style="background:#fff; padding:10px; position:absolute; top:20px; right:20px; z-index:10; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
            <strong>موقعنا الجغرافي - طرابلس</strong>
        </div>
        <iframe
            src="https://maps.google.com/maps?q=شركة+نور+العلمية+للكيماويات+chetraco,+Shawqy+St,+Tarabulus,+Libya&t=&z=15&ie=UTF8&iwloc=&output=embed"
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </div>
@endsection
