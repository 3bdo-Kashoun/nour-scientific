@props(['tag', 'partnerName', 'partnerOrigin', 'logoSrc', 'logoAlt'])


<div class="partner-card">
    <span class="tag global">{{ $tag }}</span>

    <div class="partner-info">
        <div class="partner-name" style="font-weight: 700; font-size: 1.3rem;">{{ $partnerName }}</div>
        <div class="partner-origin">{{ $partnerOrigin }}</div>
    </div>

    <img src="{{ $logoSrc }}" alt="{{ $logoAlt }}" class="partner-logo">
</div>
