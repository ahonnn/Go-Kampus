
<flux:sidebar sticky collapsible="mobile" class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.header>
            
            <!-- <flux:sidebar.brand
                href="#"
                logo="https://fluxui.dev/img/demo/logo.png"
                logo:dark="{{ asset('img/logo-kecil.svg') }}"
                name="Go Kampus."/> -->
            <flux:sidebar.brand class="gap-3">


            {{-- 1. KOTAK LOGO (Background & Ukuran diatur di sini) --}}
            <div class="flex items-center justify-center bg-white rounded-lg dark:bg-white">
                {{-- Logo Image --}}
                <img 
                    src="{{ asset('img/logo.svg') }}" 
                    class="h-6 w-6" 
                    alt="Logo"
                >
            </div>

            {{-- 2. NAMA APLIKASI (Manual Text) --}}
            <div class="leading-none mx-3">
                <span class="block font-bold text-zinc-800 dark:text-white">Go Kampus.</span>
            </div>

            

            </flux:sidebar.brand>

            <flux:sidebar.collapse class="lg:hidden" />

            
        </flux:sidebar.header>

        <!-- <flux:sidebar.search placeholder="Search..." /> -->

        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" href="{{ route('dashboard') }}">Home</flux:sidebar.item>
            <flux:sidebar.item icon="inbox" href="{{ route('tasks.index') }}">Tugas</flux:sidebar.item>
            <flux:sidebar.item icon="rectangle-stack" href="{{ route('subjects.index') }}">Mata Kuliah</flux:sidebar.item>
            <flux:sidebar.item icon="folder" href="{{ route('materials.index') }}">Documents</flux:sidebar.item>
            <flux:sidebar.item icon="calendar" href="{{ route('schedules.index') }}">Calendar</flux:sidebar.item>

            <!-- <flux:sidebar.group expandable heading="Favorites" class="grid">
                <flux:sidebar.item href="#">Marketing site</flux:sidebar.item>
                <flux:sidebar.item href="#">Android app</flux:sidebar.item>
                <flux:sidebar.item href="#">Brand guidelines</flux:sidebar.item>
            </flux:sidebar.group> -->

        </flux:sidebar.nav>
        <flux:sidebar.spacer />

        <!-- Next Fitur -->
        <!-- <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" href="#">Settings</flux:sidebar.item>
            <flux:sidebar.item icon="information-circle" href="#">Help</flux:sidebar.item>
        </flux:sidebar.nav> -->


        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile avatar="{{ auth()->user()->avatar }}" name="{{ auth()->user()->name }}" />
            <flux:menu>

                <!-- <flux:menu.radio.group>
                    <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                    <flux:menu.radio>Truly Delta</flux:menu.radio>
                </flux:menu.radio.group> -->

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="text-red-500 hover:text-red-600 hover:bg-red-50 transition duration-300">
                                Log Out
                        </flux:menu.item>
                    </form>

            </flux:menu>
        </flux:dropdown>

    </flux:sidebar>
    
    <flux:header class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 lg:hidden">
        <flux:navbar class="lg:hidden w-full">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" align="start">
                <flux:profile avatar="{{ auth()->user()->avatar }}"/>
                    <flux:menu>
                    
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="text-red-500 hover:text-red-600 hover:bg-red-50">
                                Log Out
                            </flux:menu.item>
                        </form>
                    </flux:menu>
            </flux:dropdown>
        </flux:navbar>


        <!-- <flux:navbar scrollable>
            <flux:navbar.item href="#" current>Dashboard</flux:navbar.item>
            <flux:navbar.item badge="32" href="#">Orders</flux:navbar.item>
            <flux:navbar.item href="#">Catalog</flux:navbar.item>
            <flux:navbar.item href="#">Configuration</flux:navbar.item>
        </flux:navbar> -->
        
    </flux:header>

