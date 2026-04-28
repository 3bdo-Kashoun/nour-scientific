document.addEventListener('DOMContentLoaded', () => {
  // Menu Toggle
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');

  menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    const icon = menuToggle.querySelector('i');
    icon.classList.toggle('fa-bars');
    icon.classList.toggle('fa-times');

  });
  /* ===============================
     Scroll Reveal
  =============================== */
  const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
        revealObserver.unobserve(entry.target);
      }
    });
  },
    {
      threshold: 0.2,
      rootMargin: "0px 0px -100px 0px"
    });

  document.querySelectorAll('.reveal')
    .forEach(el => revealObserver.observe(el));


  /* ===============================
     Counters
  =============================== */
  const counters = document.querySelectorAll('.stat-number');
  const statsSection = document.querySelector('.stats-container');

  const animateCounter = (counter) => {
    if (counter.innerText === "ISO") return;

    const target = +counter.dataset.target;
    let current = 0;
    const duration = 2000;
    const step = target / (duration / 20);

    const update = () => {
      current += step;
      if (current < target) {
        counter.innerText = "+" + Math.ceil(current);
        setTimeout(update, 20);
      } else {
        counter.innerText = "+" + target;
      }
    };

    update();
  };

  const counterObserver = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      counters.forEach(animateCounter);
      counterObserver.disconnect(); // يعمل مرة واحدة فقط
    }
  }, { threshold: 0.3 });

  if (statsSection) {
    counterObserver.observe(statsSection);
  }

  // User Dropdown Toggle
  const userMenuToggle = document.getElementById('userMenuToggle');
  const userDropdown = document.getElementById('userDropdown');

  if (userMenuToggle && userDropdown) {
      userMenuToggle.addEventListener('click', function (e) {
          e.stopPropagation();
          userDropdown.classList.toggle('show');
      });

      document.addEventListener('click', function (e) {
          if (!userMenuToggle.contains(e.target)) {
              userDropdown.classList.remove('show');
          }
      });
  }

});

// رسالة تأكيد الارسال في صفحة الاتصال
const contactForm = document.querySelector('form');
if (contactForm) {
  contactForm.addEventListener('submit', function (e) {
    e.preventDefault();
    Swal.fire({
      title: "تم الإرسال!",
      text: "لقد استلمنا رسالتك وسنقوم بالرد عليك قريباً.",
      icon: "success",
      confirmButtonText: "موافق",
      confirmButtonColor: "#28a745"
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });
}
