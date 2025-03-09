@extends('layouts.app')

@section('content')
    <!-- Card de Edição da Transação -->
    <section class="bg-white rounded-lg shadow-sm px-4 py-8 mx-2 my-4">
        <header class="border-b border-gray-200 pb-4 pl-2">
            <h3 class="text-xl font-semibold text-gray-700">
                {{ __('messages.edit_transaction') }}
            </h3>
        </header>

        <div class="mt-6">
            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-3 gap-6">
                    <!-- Título -->
                    <div class="col-span-2">
                        <label for="title" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.title') }}
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $transaction->title) }}"
                               class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">
                    </div>

                    <!-- Total Amount -->
                    <div>
                        <label for="total_amount" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.total_amount') }}
                        </label>
                        <input type="text" name="total_amount" id="total_amount" value="{{ old('total_amount', $transaction->total_amount) }}"
                               class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500"
                               placeholder="R$ 0,00">
                    </div>

                    <!-- Description -->
                    <div class="col-span-3">
                        <label for="description" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.description') }}
                        </label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">{{ old('description', $transaction->description) }}</textarea>
                    </div>

                    <!-- Transaction Type -->
                    <div>
                        <label for="transaction_type" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.transaction_type') }}
                        </label>
                        <select name="transaction_type" id="transaction_type"
                                class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">
                            <option value="">{{ __('messages.select_option') }}</option>

                            @foreach(\App\Enums\TransactionType::cases() as $type)
                                <option value="{{ $type->value }}" {{ old('transaction_type', $transaction->transaction_type->value) == $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Transaction Payment -->
                    <div>
                        <label for="payment_type" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.transaction_payment') }}
                        </label>
                        <select name="payment_type" id="payment_type"
                                class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @foreach(\App\Enums\PaymentType::cases() as $type)
                                <option value="{{ $type->value }}" {{ old('payment_type', $transaction->payment_type->value) == $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.category') }}
                        </label>
                        <select name="category_id" id="category_id"
                                class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}" {{ old('category_id', $transaction->category->id) == $key ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Installments -->
                    <div>
                        <label for="installments" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.installments') }}
                        </label>
                        <select name="installments" id="installments"
                                class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('installments', $transaction->installments_count) == $i ? 'selected' : '' }}>
                                    {{ $i }}x
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Transaction Date -->
                    <div>
                        <label for="transaction_date" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.transaction_date') }}
                        </label>
                        <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
                               class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.status') }}
                        </label>
                        <select name="status" id="status"
                                class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @foreach(\App\Enums\TransactionStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('status', $transaction->status->value) == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                        {{ __('messages.update') }}
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Card de Parcelas -->
    <section class="bg-white rounded-lg shadow-sm px-4 py-8 mx-2 my-4">
        <header class="border-b border-gray-200 pb-4 pl-2">
            <h3 class="text-xl font-semibold text-gray-700">
                {{ __('messages.installments') }}
            </h3>
        </header>
        <div class="mt-6">
            @if(isset($transaction->installments) && $transaction->installments->count() > 0)
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">{{ __('messages.installment_number') }}</th>
                        <th class="px-4 py-2">{{ __('messages.total_amount') }}</th>
                        <th class="px-4 py-2">{{ __('messages.transaction_date') }}</th>
                        <th class="px-4 py-2">{{ __('messages.status') }}</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transaction->installments as $installment)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $installment->installment_number }} / {{ $transaction->installments_count }}</td>
                            <td class="px-4 py-2">{{ $installment->installment_amount }}</td>
                            <td class="px-4 py-2">{{ $installment->transaction_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-2"><span class="py-1 px-2 rounded-full bg-{{$installment->status->color()}}-300">{{ $installment->status->label() }}</span></td>
                            <td class="px-4 py-2 flex space-x-2 align-end justify-end">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="focus:outline-none">
                                        @svg('solar-menu-dots-bold', ['class' => 'h-5 w-5'])
                                    </button>
                                    <div x-show="open" x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-md z-10">
                                        <!-- Botão que dispara o modal para editar a parcela -->
                                        <button type="button"
                                                @click="$dispatch('open-edit-installment-modal', { route: '{{ route('transactions.installments.update', $installment->id) }}' })"
                                                class="w-full block flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            @svg('solar-pen-new-square-linear', ['class' => 'h-5 w-5 mr-2'])
                                            {{ __('messages.edit') }}
                                        </button>
                                        <a href="{{ route('transactions.status', $transaction->id) }}" class="block flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            @svg('solar-refresh-linear', ['class' => 'h-5 w-5 mr-2'])
                                            {{ __('messages.update_status') }}
                                        </a>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar esta transação?')" class="block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full flex items-center text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                @svg('solar-trash-bin-trash-linear', ['class' => 'h-5 w-5 mr-2'])
                                                {{ __('messages.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>{{ __('messages.no_installments_available') }}</p>
            @endif
        </div>
    </section>
    @include('pages.transactions.edit-installment-modal')
@endsection

@push('scripts')
    <script>
        function formatBRL(value) {
            value = value.replace(/\D/g, '');
            if (value === '') return '';
            let number = parseInt(value, 10) / 100;
            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(number);
        }

        document.getElementById('total_amount').addEventListener('input', function(e) {
            let input = e.target;
            let cursorPosition = input.selectionStart;
            let originalLength = input.value.length;

            input.value = formatBRL(input.value);

            let newLength = input.value.length;
            input.selectionStart = input.selectionEnd = cursorPosition + (newLength - originalLength);
        });

        document.getElementById('installment_amount').addEventListener('input', function(e) {
           let input = e.target;
           let cursorPosition = input.selectionStart;
           let originalLength = input.value.length;

           input.value = formatBRL(input.value);

           let newLength = input.value.length;
           input.selectionStart = input.selectionEnd = cursorPosition + (newLength - originalLength);
        });
    </script>
@endpush
