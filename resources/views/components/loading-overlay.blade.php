<div x-data="{
    loading: false,
    timeout: null,
    message: 'Preparando seu ambiente de estudos...',
    icon: 'book-open-reader',
    icons: ['book-open-reader', 'chalkboard-user', 'graduation-cap', 'school', 'laptop-code', 'pencil-paintbrush'],
    init() {
        const stop = () => { if (this.timeout) clearTimeout(this.timeout); this.timeout = null; this.loading = false; };
        const start = (msg = null, iconName = null) => {
            stop();
            this.message = msg || 'Carregando materiais...';
            this.icon = iconName || this.icons[Math.floor(Math.random() * this.icons.length)];
            this.timeout = setTimeout(() => this.loading = true, 50);
        };

        window.addEventListener('beforeunload', () => start('Preparando navegação...'));
        window.addEventListener('submit', (e) => {
            if (e.target.hasAttribute('data-no-loading')) return;
            start('Salvando seu progresso...');
        });
        window.addEventListener('pageshow', stop);
        window.addEventListener('load', stop);
        window.addEventListener('DOMContentLoaded', stop);
        window.addEventListener('stop-loading', stop);
        window.addEventListener('start-loading', (e) => start(e.detail?.message, e.detail?.icon));

        $watch('loading', v => { if (v) setTimeout(() => { if (this.loading) stop(); }, 30000); });
        stop();
    }
}"
    x-show="loading"
    x-cloak
    role="alert"
    aria-busy="true"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/80 dark:bg-slate-900/85 backdrop-blur-md font-['Poppins']"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div class="relative flex flex-col items-center">
        <!-- Main Icon Container -->
        <div class="relative w-32 h-32 mb-8">
            <!-- Pulsing Rings -->
            <div class="absolute inset-0 bg-indigo-500/20 rounded-full animate-ping"></div>
            <div class="absolute inset-2 bg-indigo-500/10 rounded-full animate-pulse delay-75"></div>

            <!-- Glass Card for Icon -->
            <div class="absolute inset-0 bg-white dark:bg-slate-800 rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-slate-100 dark:border-slate-700 flex items-center justify-center overflow-hidden">
                <div class="text-indigo-600 dark:text-indigo-400 text-5xl transform transition-all duration-500">
                   <template x-if="icon === 'book-open-reader'"><x-icon name="book-open-reader" style="duotone" class="fa-beat-fade" /></template>
                   <template x-if="icon === 'chalkboard-user'"><x-icon name="chalkboard-user" style="duotone" class="fa-fade" /></template>
                   <template x-if="icon === 'graduation-cap'"><x-icon name="graduation-cap" style="duotone" class="fa-bounce" /></template>
                   <template x-if="icon === 'school'"><x-icon name="school" style="duotone" class="fa-beat" /></template>
                   <template x-if="icon === 'laptop-code'"><x-icon name="laptop-code" style="duotone" class="fa-pulse" /></template>
                   <template x-if="icon === 'pencil-paintbrush'"><x-icon name="pencil-paintbrush" style="duotone" class="fa-shake" /></template>
                </div>
            </div>
        </div>

        <!-- Message Box -->
        <div class="flex flex-col items-center gap-3">
            <h3 x-text="message" class="text-xl font-bold text-slate-800 dark:text-white tracking-wide font-['Poppins']"></h3>

            <div class="flex items-center gap-2 mt-2">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-bounce [animation-delay:-0.3s]"></span>
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-bounce [animation-delay:-0.15s]"></span>
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-bounce"></span>
            </div>
        </div>

        <!-- Subtle Progress Line -->
        <div class="mt-8 w-64 h-1 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500 animate-[loading-bar_2s_ease-in-out_infinite] w-1/3"></div>
        </div>
    </div>
</div>

<style>
    @font-face {
        font-family: 'Poppins';
        src: url('/resources/fonts/poppins-v24-latin-regular.woff2') format('woff2');
        font-weight: 400;
        font-style: normal;
    }
    @font-face {
        font-family: 'Poppins';
        src: url('/resources/fonts/poppins-v24-latin-700.woff2') format('woff2');
        font-weight: 700;
        font-style: normal;
    }

    @keyframes loading-bar {
        0% { transform: translateX(-150%); }
        100% { transform: translateX(350%); }
    }
</style>
