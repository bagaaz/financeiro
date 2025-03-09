<div x-data="{ open: false, editRoute: '' }"
     x-init="
        window.addEventListener('open-edit-installment-modal', event => {
            editRoute = event.detail.route;
            open = true;
        });
     "
     x-show="open"
     x-cloak
     class="fixed inset-0 flex items-center justify-center z-50">
    <!-- Fundo semi-transparente -->
    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    <!-- Conteúdo do modal -->
    <div class="bg-white rounded-lg p-6 z-10 max-w-md mx-auto min-w-[500px]">
        <h2 class="text-xl font-bold mb-4">{{ __('messages.edit') }}</h2>
        <form :action="editRoute" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.transaction_date') }}</label>
                <input type="date" name="transaction_date" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.total_amount') }}</label>
                <input type="text" name="installment_amount" id="installment_amount" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>
            <div class="flex justify-end">
                <button type="button" @click="open = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                    {{ __('messages.exit') }}
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    {{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
