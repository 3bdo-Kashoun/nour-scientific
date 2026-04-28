@props(['name','role','phone','email'])


<div class="team-card">
    <div class="member-name">{{ $name }}</div>
    <div class="member-role">{{ $role }}</div>
    <div class="member-contact">
        <div><i class="fa-solid fa-phone"></i> <span dir="ltr">{{ $phone }}</span></div>
        <div><i class="fa-solid fa-envelope"></i> {{ $email }}</div>
    </div>
</div>
