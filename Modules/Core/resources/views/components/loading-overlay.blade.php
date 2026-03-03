<div x-data="{
    loading: false,
    timeout: null,
    message: 'Carregando...',
    icon: 'lightbulb',
    icons: ['lightbulb', 'store', 'cart-shopping', 'receipt', 'box', 'spinner'],
    init() {
        const stop = () => { if (this.timeout) clearTimeout(this.timeout); this.timeout = null; this.loading = false; };
        const start = (msg = null, iconName = null) => {
            stop();
            this.message = msg || 'Processando...';
            this.icon = iconName && this.icons.includes(iconName) ? iconName : this.icons[Math.floor(Math.random() * this.icons.length)];
            this.timeout = setTimeout(() => this.loading = true, 50);
        };

        window.addEventListener('beforeunload', () => start('Preparando navegação...'));
        window.addEventListener('submit', (e) => {
            if (e.target.hasAttribute('data-no-loading')) return;
            start('Salvando...');
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
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/80 dark:bg-slate-900/85 backdrop-blur-md font-display"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div class="relative flex flex-col items-center">
        <div class="relative w-32 h-32 mb-8">
            <div class="absolute inset-0 bg-indigo-500/20 rounded-full animate-ping"></div>
            <div class="absolute inset-2 bg-indigo-500/10 rounded-full animate-pulse"></div>
            <div class="absolute inset-0 bg-white dark:bg-slate-800 rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-slate-100 dark:border-slate-700 flex items-center justify-center overflow-hidden">
                <div class="text-indigo-600 dark:text-indigo-400 text-5xl transform transition-all duration-500">
                    <template x-if="icon === 'lightbulb'"><x-icon name="lightbulb" style="duotone" class="fa-beat-fade" /></template>
                    <template x-if="icon === 'store'"><x-icon name="store" style="duotone" class="fa-fade" /></template>
                    <template x-if="icon === 'cart-shopping'"><x-icon name="cart-shopping" style="duotone" class="fa-bounce" /></template>
                    <template x-if="icon === 'receipt'"><x-icon name="receipt" style="duotone" class="fa-beat" /></template>
                    <template x-if="icon === 'box'"><x-icon name="box" style="duotone" class="fa-pulse" /></template>
                    <template x-if="icon === 'spinner'"><x-icon name="spinner" style="solid" class="fa-spin" /></template>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center gap-3">
            <h3 x-text="message" class="text-xl font-bold text-slate-800 dark:text-white tracking-wide"></h3>
            <div class="flex items-center gap-2 mt-2">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-bounce [animation-delay:-0.3s]"></span>
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-bounce [animation-delay:-0.15s]"></span>
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-bounce"></span>
            </div>
        </div>

        <div class="mt-8 w-64 h-1 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500 w-1/3 animate-[loading-bar_2s_ease-in-out_infinite]"></div>
        </div>
    </div>
</div>

<style>
    @keyframes loading-bar {
        0% { transform: translateX(-150%); }
        100% { transform: translateX(350%); }
    }
</style>
