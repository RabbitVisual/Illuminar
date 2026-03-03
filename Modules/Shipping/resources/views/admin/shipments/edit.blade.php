<x-core::layouts.master heading="Informar Rastreio">
    <div class="max-w-xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('shipping.admin.shipments.index') }}" class="hover:text-primary transition-colors">Entregas</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Pedido {{ $shipment->order->order_number ?? $shipment->order_id }}</span>
        </div>

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                Pedido <strong>{{ $shipment->order->order_number ?? '#' . $shipment->order_id }}</strong>
                · Cliente: {{ $shipment->order->customer->name ?? '-' }}
                · Método: {{ $shipment->shippingMethod->name ?? '-' }}
            </p>

            <form method="POST" action="{{ route('shipping.admin.shipments.update-tracking', $shipment) }}">
                @csrf
                @method('PATCH')

                <div class="space-y-4">
                    <div>
                        <label for="tracking_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código de Rastreio</label>
                        <input type="text" id="tracking_code" name="tracking_code" value="{{ old('tracking_code', $shipment->tracking_code) }}" required
                               class="block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 font-mono">
                        @error('tracking_code')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="status" name="status" required
                                class="block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100">
                            <option value="pending" {{ old('status', $shipment->status) === 'pending' ? 'selected' : '' }}>Pendente</option>
                            <option value="dispatched" {{ old('status', $shipment->status) === 'dispatched' ? 'selected' : '' }}>Enviado</option>
                            <option value="delivered" {{ old('status', $shipment->status) === 'delivered' ? 'selected' : '' }}>Entregue</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-4">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                        <x-icon name="floppy-disk" style="solid" class="w-4 h-4" />
                        Salvar
                    </button>
                    <a href="{{ route('shipping.admin.shipments.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
