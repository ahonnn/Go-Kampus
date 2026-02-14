<header class="absolute inset-x-0 top-0 z-50">
    <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
      <div class="flex lg:flex-1">
        <a href="#" class="-m-1.5 p-1.5">
          <span class="sr-only">Go Kampus</span>
          <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50" height="50"><path d="M22.921 36.984h-6.813a1.757 1.757 0 0 1 -1.755 -1.757V14.776c0 -1.994 2.792 -2.449 3.422 -0.555l6.81 20.451a1.757 1.757 0 0 1 -1.665 2.312" style="fill:#9a1b1f"/><path cx="148.32" cy="111.4" r="26.35" style="fill:#231f20" d="M35.647 22.735a5.379 5.379 0 0 1 -5.378 5.377 5.379 5.379 0 0 1 -5.377 -5.377 5.378 5.378 0 0 1 10.755 0"/></svg>
        </a>
      </div>
      <div class="flex lg:hidden">
        <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
          <span class="sr-only">Open main menu</span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>

        </button>
      </div>

      <div class="hidden lg:flex lg:gap-x-12">
        <a href="#" class="font-medium hover:text-[#9a0002] hover:scale-105 transition duration-300 ease-in-out">Home</a>
        <a href="#" class="font-medium hover:text-[#9a0002] hover:scale-105 transition duration-300 ease-in-out">About</a>
        <a href="#" class="font-medium hover:text-[#9a0002] hover:scale-105 transition duration-300 ease-in-out">Features</a>
        <a href="#" class="font-medium hover:text-[#9a0002] hover:scale-105 transition duration-300 ease-in-out">Sosial</a>
      </div>

      <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        <a href="{{ route('login') }}" class="font-semibold hover:text-[#9a0002] hover:scale-105 transition duration-300 ease-in-out">Log in <span aria-hidden="true">&rarr;</span></a>
      </div>
    </nav>

    <el-dialog>
      <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
        <div tabindex="0" class="fixed inset-0 focus:outline-none">
          <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
            <div class="flex items-center justify-between">
              <a href="#" class="-m-1.5 p-1.5">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70" width="70" height="70"><path d="M32.089 51.778h-9.538a2.46 2.46 0 0 1-2.457-2.46V20.686c0-2.792 3.909-3.429 4.791-.777l9.534 28.631a2.46 2.46 0 0 1-2.331 3.237" style="fill:#9a1b1f"/><path style="fill:#231f20" d="M49.906 31.829a7.53 7.53 0 0 1-7.529 7.528 7.53 7.53 0 0 1-7.528-7.528 7.529 7.529 0 0 1 15.057 0"/></svg>
              </a>
              <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-200">
                <span class="sr-only">Close menu</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                  <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
            <div class="mt-6 flow-root">
              <div class="-my-6 divide-y divide-white/10">
                <div class="space-y-2 py-6">
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Product</a>
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Features</a>
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Marketplace</a>
                  <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Company</a>
                </div>
                <div class="py-6">
                  <a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Log in</a>
                </div>
              </div>
            </div>
          </el-dialog-panel>
        </div>
      </dialog>
    </el-dialog>

  </header>