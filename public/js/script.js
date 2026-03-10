gsap.registerPlugin(Observer);
      gsap.registerPlugin(ScrollTrigger);

      const buttons = document.querySelectorAll('.dot-btn');
      const sliderTrack = document.querySelector('#sliderTrack');
      const totalSlides = buttons.length;
      let currentSlide = 0;
      let autoPlayTimer;

      // script welcome
      gsap.from('#Features', {
        scrollTrigger: {
          trigger: "#Features",
          toggleActions: "restart restart restart restart"
        }, // start animation when ".box" enters the viewport
        opacity: 0,
        y: 100,
        duration: 1,
        delay: 0.5,
        stagger: 1,
        ease: "power3.out"
      });

      gsap.from('#solution', {
        scrollTrigger: {
          trigger: "#solution",
          toggleActions: "restart restart restart restart"
        }, // start animation when ".box" enters the viewport
        opacity: 0,
        y: 100,
        duration: 1,
        delay: 0.5,
        stagger: 1,
        ease: "power3.out"
      });

      gsap.from('.card', {
        scrollTrigger: {
          trigger: ".card",
          toggleActions: "restart restart restart restart"
        },
        opacity: 0,
        x: 100,
        duration: 1,
        delay: 0.2,
        stagger: 0.2,
        ease: "power3.out"
      });   

      gsap.from('.text-upper', {
        scrollTrigger: {
          trigger: ".text-upper",
          toggleActions: "restart none restart reverse"
        },
        opacity: 0,
        y: -100,
        duration: 1,
        delay: 0.7,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from('.text-lower', {
        scrollTrigger: {
          trigger: ".text-lower",
          toggleActions: "restart none restart none"
        },
        opacity: 0,
        y: 100,
        duration: 1,
        delay: 0.7,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from("#hero", {
        opacity: 0,
        y: 100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from("#bedge, #judulHero, #subHero", {
        opacity: 0,
        y: 100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from('.button', {
      opacity: 0,
      y: 100,
      delay: 1,
      duration: 1.5,
      stagger: 0.2,
      ease: "sine.out"
      });


      // script Dashboard

      gsap.from("#banner", {
        opacity: 0,
        y: 100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from("#horizontal-card", {
        opacity: 0,
        x: 100,
        delay: 0.9,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from("#col-kiri", {
        opacity: 0,
        y: 100,
        delay: 1.3,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from("#col-kanan", {
        opacity: 0,
        x: 100,
        delay: 1.5,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      // script Task
      gsap.from("#title-task , #filter-task, #search-task", {
        opacity: 0,
        y: -100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from("#card-task", {
        opacity: 0,
        y: 100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      // Script Subject
      gsap.from("#title-subject", {
        opacity: 0,
        y: -100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from("#card-subject", {
        opacity: 0,
        y: 100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      // Script Material
      gsap.from("#title-material", {
        opacity: 0,
        y: -100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from("#card-material", {
        opacity: 0,
        y: 100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      // Script Schedules
      gsap.from("#title-schedules, #sub-title-schedules, #separator", {
        opacity: 0,
        y: -100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });

      gsap.from("#card-schedules", {
        opacity: 0,
        y: 100,
        delay: 0.7,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
      });





      // Fungsi utama untuk pindah slide
        function goToSlide(index) {
          currentSlide = (index + totalSlides) % totalSlides;

          // Animasi pergerakan track
          gsap.to("#sliderTrack", {
            xPercent: currentSlide * -100,
            duration: 0.1, // Sedikit lebih lambat agar transisi terlihat smooth
            ease: "sine.inOut",
            overwrite: "auto"
          });

            // Update styling tombol dot
            // gsap.to(".dot-btn", { 
            //   opacity: 0.5 
            // });
            // gsap.to(buttons[currentSlide], { \
            //   opacity: 1 ,
              
            // });

            buttons.forEach((btn, i) => {
              if(i === currentSlide) {
                btn.className = "dot-btn h-3 w-8 bg-white opacity-100 rounded-full transition-all duration-300 transition-all";
              } else{
                btn.className = "dot-btn w-3 h-3 rounded-full bg-white opacity-50 transition-all";
              }
            });

            resetAutoPlay();
          }

          // --- LOGIKA AUTO-PLAY ---
          function startAutoPlay() {
            // Pindah ke slide berikutnya setiap 3 detik (3000ms)
            autoPlayTimer = setInterval(() => {
              goToSlide(currentSlide + 1);
            }, 3000); 
          }

          function resetAutoPlay() {
            clearInterval(autoPlayTimer); // Hentikan timer yang sedang berjalan
            startAutoPlay(); // Mulai timer baru
          }

          // Event Listener untuk Tombol Dot
          buttons.forEach((button, index) => {
            button.addEventListener('click', () => {
              goToSlide(index);
            });
          });

          // Konfigurasi Swipe/Touch menggunakan Observer
            Observer.create({
              target: "#sliderTrack", 
              type: "touch,pointer",
              // Logika Swipe: 
              // Swipe ke Kiri (onLeft) berarti mau lihat konten di Kanan (Slide + 1)
              onLeft: () => goToSlide(currentSlide + 1),
              // Swipe ke Kanan (onRight) berarti mau lihat konten di Kiri (Slide - 1)
              onRight: () => goToSlide(currentSlide - 1),
              tolerance: 50,
              preventDefault: true
            });

            startAutoPlay();
            // Set tampilan awal (opsional, agar slide 0 aktif)
            goToSlide(0);