<!doctype html>
<html class="no-scrollbar">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js"></script>

  </head>
  <body>

  <!-- Navbar -->
  <x-Navbar></x-Navbar>

    <!-- Hero -->
    <header class="Hero relative w-full h-svh flex justify-center items-center overflow-hidden inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] bg-size-[16px_16px]">
      <div class="relative isolate w-full">

        <div id="hero" class="mx-auto max-w-xl py-32 sm:py-48 lg:py-56">
        <!-- Bedge -->
          <div id="bedge" class="hidden sm:mb-8 sm:flex sm:justify-center">
            <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-700 ring-1 ring-black/30 ">
              Organize school activities here
            </div>
          </div>
          
          <div class="text-center text-shadow-sm/5">

            <h1 id="judulHero" class="text-3xl font-header tracking-tight text-balance sm:text-4xl">Organize your homework so you don't forget to do it.</h1>
            <p id="subHero" class="mt-4 text-lg text-pretty text-gray-500 text-shadow-sm/5 sm:text-base">Do you often forget to do your assignments and have trouble finding your files? Save and organize everything here.</p>
          
          </div>

        
          <div class="button flex flex-row gap-4 justify-center mt-5">

          <div id="btnStart" class="flex justify-center items-center p-2 w-30 bg-red-700  rounded-full shadow hover:bg-red-700/90 text-white ease-in-out duration-500"><a href="" class="font-medium text-shadow-sm">Start Now </a></div>
          <div id="btnLogin" class="flex justify-center items-center p-2 w-30 bg-gray-950 rounded-full shadow hover:bg-gray-950/90 text-white ease-in-out duration-500"><a href="" class="font-medium text-shadow-sm">Login</a></div>
          </div>

        </div>


        <!-- <div class="absolute w-full h-screen mask-t-from-5% mask-t-to-90% top-0 -z-1 bg-amber-300/20"></div> -->
        <!-- <img class="absolute w-full h-screen mask-t-from-5% mask-t-to-90% top-0 -z-1" src="{{ asset('img/bg.jpg') }}" alt=""> -->

      </div>
      

    </header>

    <!-- Problem -->
      <section id="features" class="features relative bg-green-950 w-full min-h-screen p-8 flex flex-col gap-40 overflow-hidden">



        <div id="Features" class="container features mx-auto py-32 sm:py-48 lg:py-56 flex flex-col lg:flex-row justify-center items-start">

          <div class="contect-left flex flex-col lg:justify-between lg:h-105 mb-4 lg:mr-5">

            <div class="text-upper flex flex-col mb-4">
              <h3 class="text-red-600 font-semibold">Problem</h3>
              <h1 class="text-white font-semibold text-2xl">Being buzy doesn't always <br> mean being organized</h1>
            </div>

            <div class="text-lower text-white flex flex-col">
              <p>Tasks are everywhere.Chats,notes,different tools.</p>
              <p class="mt-4">It's hard to see priorities, deadline slip, and work feels <br> more stressful than it should.</p>
            </div>

          </div>

          <div class="contect-right flex flex-col lg:justify-between lg:h-105 mt-4 lg:ml-5 items-center">

            <div class="container card grid grid-cols-2 gap-4">

              <div class="card bg-amber-50 p-5 border border-amber-100 rounded-2xl h-50 flex flex-col justify-between">
                  <i class="fa-solid fa-draw-polygon"></i>
                  <p class="font-medium">Too many tasks, no clear rhythm.</p>
              </div>

              <div class="card bg-amber-50 p-5 border border-amber-100 rounded-2xl h-50 flex flex-col justify-between">
                  <i class="fa-solid fa-arrow-trend-up"></i>
                  <p class="font-medium">Lists grow longer, motivation gets shorter</p>
              </div>

              <div class="card bg-amber-50 p-5 border border-amber-100 rounded-2xl h-50 flex flex-col justify-between">
                  <i class="fa-regular fa-clipboard"></i>
                  <p class="font-medium">important tasks get buried under small ones</p>
              </div>

              <div class="card bg-amber-50 p-5 border border-amber-100 rounded-2xl h-50 flex flex-col justify-between">
                  <i class="fa-regular fa-calendar-check"></i>
                  <p class="font-medium">You plan your day, but it never goes as planned</p>
              </div>
              
            </div>

          </div>


        </div>

      </section>
    <!-- Problem -->

    <!-- Solution -->
      <section id="sosial" class="sosial relative bg-green-700/80 w-full min-h-screen p-8 flex flex-col gap-40 overflow-hidden">

        <div id="solution" class="container solution mx-auto py-32 sm:py-48 lg:py-56 grid lg:grid-cols-[1fr_2fr_1fr] gap-5">

          <div class="solution-left flex flex-col lg:h-105 justify-between">

            <div class="text-upper flex flex-col mb-4">
              <h3 class="text-green-800 font-semibold">Solution</h3>
              <h1 class="text-white font-semibold text-4xl">One workspace to keep everything moving</h1>
            </div>

            <div class="text-lower text-white flex flex-col">
              <p>Roution puts all your tasks in one clear place.</p>
              <p class="mt-4">plan better,focus on what matters, and get work done without the noise.</p>
            </div>

          </div>

          <div class="solution-center flex flex-col lg:h-105 justify-center items-center">

            <div class="wrap flex flex-row relative overflow-hidden lg:w-72.5 h-105 rounded-2xl">

            <div id="sliderTrack" class="flex h-full transition-transform sliderTrack">

              <!-- IMG 1 -->
              <div class="slide w-full shrink-0 select-none">
                <img src="{{ asset('img/bg.jpg') }}" alt="" draggable="false" class="min-w-full h-full shrink-0 object-cover select-none pointer-events-none">
              </div>
              <!-- IMG 2 -->
              <div class="slide w-full shrink-0 select-none">
                <img src="{{ asset('img/1-collaboration.svg') }}" alt="" class="min-w-full h-full shrink-0 object-cover select-none pointer-events-none">
              </div>
              <!-- IMG 3 -->
              <div class="slide w-full shrink-0 select-none">
                <img src="{{ asset('img/2-mobile.svg') }}" alt="" class="min-w-full h-full shrink-0 object-cover select-none pointer-events-none">
              </div>

            </div>
              
            </div>

            <!-- slider indicators -->
             <div class="z-30 flex gap-2 mt-4 justify-center space-x-3 rtl:space-x-reverse">
                <button type="button" class="dot-btn w-3 h-3 rounded-full bg-white" aria-current="true" data-index=0 aria-label="Slide 1"></button>
                <button type="button" class="dot-btn w-3 h-3 rounded-full bg-white" aria-current="false" data-index=1 aria-label="Slide 2"></button>
                <button type="button" class="dot-btn w-3 h-3 rounded-full bg-white" aria-current="false" data-index=2 aria-label="Slide 3"></button>
             </div>


          </div>

          <div class="solution-right flex flex-col lg:h-105 justify-center">

            <div class="text-upper flex flex-col">
              <h1 class="text-white font-semibold text-4xl">Daily clarity</h1>
            </div>

            <div class="text-lower text-white flex flex-col">
              <p>You always know matters today, not <br> everything at one</p>
            </div>

          </div>


        </div>

      </section>
    <!-- Solution -->

    <!-- footer -->

    <div class="bg-green-700/80 font-sans w-full relative z-10">

    <footer class="relative w-full
            bg-[image:linear-gradient(rgba(255,255,255,0.15)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.15)_1px,transparent_1px),linear-gradient(to_bottom_right,#2845D6,#261CC1)] 
            bg-[length:40px_40px,40px_40px,100%_100%]
    text-[#fcf8ef] rounded-t-[2.5rem] px-4 md:px-15 py-10 pt-24 flex flex-col lg:flex-row justify-between gap-12 lg:gap-8 overflow-visible">

      <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 md:w-32 md:h-32 text-[#00ff66] bg-amber-50 rounded-full">
        <!-- Logo -->
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 245 245">
          <path d="M112.31 181.22H78.93a8.61 8.61 0 0 1-8.6-8.61V72.4c0-9.77 13.68-12 16.77-2.72l33.37 100.21a8.61 8.61 0 0 1-8.16 11.33" style="fill:#9a1b1f"/><circle cx="148.32" cy="111.4" r="26.35" style="fill:#231f20"/>
        </svg>
      </div>

      <div class="flex flex-col justify-between flex-1 gap-10">
      <div class="flex flex-col sm:flex-row gap-10 md:gap-16">
        <div>
          <h3 class="text-xl font-bold mb-4">Contact</h3>
          <p class="text-sm text-gray-300 leading-relaxed">
            Borneo.<br>
            Indonesia.<br>
            <a href="mailto:barudaktanpalewu@gmail.com" class="underline hover:text-[#00ff66] transition-colors">barudaktanpalewu@gmail.com</a>
          </p>
        </div>
        <div class="flex flex-col justify-center gap-2 mt-2 sm:mt-11">
          <a href="#" class="flex items-center gap-2 text-sm text-gray-300 hover:text-[#00ff66] transition-colors">
            Facebook <span class="text-[#00ff66]">↗</span>
          </a>
          <a href="#" class="flex items-center gap-2 text-sm text-gray-300 hover:text-[#00ff66] transition-colors">
            Instagram <span class="text-[#00ff66]">↗</span>
          </a>
          <a href="#" class="flex items-center gap-2 text-sm text-gray-300 hover:text-[#00ff66] transition-colors">
            LinkedIn <span class="text-[#00ff66]">↗</span>
          </a>
        </div>
      </div>

      <div class="flex items-center gap-3 mt-4 bg-[#fcf8ef] w-fit pr-3 pl-1 py-1 rounded-full">
        <span class="bg-[#00ff66] text-black text-xs font-bold px-2 py-1 rounded-full">7,9</span>
        <span class="text-xs text-black">Leadingcourses score</span>
      </div>
    </div>

    <div class="flex flex-col items-center text-center justify-center flex-1 gap-6">
      <div>
        <h2 class="text-4xl md:text-5xl font-serif font-medium tracking-tight mb-2">Go<br>Campus</h2>
        <p class="italic text-gray-300 font-sans">Organize and Scheduled</p>
      </div>
      <div class="flex flex-col sm:flex-row gap-4 mt-4">
        <button class="bg-[#00ff66] text-black font-semibold px-6 py-3 rounded-full hover:bg-[#00cc52] transition-colors flex items-center justify-center gap-2">
          Login <span class="font-normal">→</span>
        </button>
        <button class="bg-[#0c3e27] text-white font-semibold px-6 py-3 rounded-full hover:bg-[#082b1b] transition-colors flex items-center justify-center gap-2 border border-[#0c3e27]">
          Register <span class="font-normal text-[#00ff66]">→</span>
        </button>
      </div>
    </div>

    <div class="flex flex-col justify-between flex-1 items-start lg:items-end gap-10">
      <div class="w-full lg:w-auto">
        <h3 class="text-xl font-bold mb-4">Purpose</h3>
        <div class="grid gap-x-8 gap-y-2 text-sm text-gray-300 max-w-57.5">
          <p>The purpose of this website is to organize lecture files and lecture scheduling.</p>
        </div>
      </div>
      
      <div class="bg-[#fcf8ef] text-black text-xs px-4 py-2 rounded-full flex gap-4 mt-4 font-medium">
        <p>Inspired by the Notion app</p>
        <span>©2026</span>
      </div>
    </div>


    </footer>


    </div>

    <!-- footer -->

    
<!-- <script src="{{ asset('js/script.js') }}"></script> -->
<script src="{{ asset('js/script.js') }}" defer></script>

<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/Observer.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/lenis@1.0.42/dist/lenis.min.js"></script>

    <script>

      

    </script>


  </body>
</html>