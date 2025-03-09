@extends('layouts.app')

@section('content')
    <section class="bg-white rounded-lg shadow-sm px-4 py-8 mx-2 my-4">
        <header class="border-b border-gray-200 pb-4 pl-2">
            <h3 class="text-xl font-semibold text-gray-700">
                {{ __('messages.add_transaction') }}
            </h3>
        </header>

        <div class="mt-6">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-3 gap-6">
                    <!-- Título -->
                    <div class="col-span-2">
                        <label for="title" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.title') }}
                        </label>
                        <input type="text" name="title" id="title"
                               class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">
                    </div>

                    <!-- Total Amount -->
                    <div>
                        <label for="total_amount" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.total_amount') }}
                        </label>
                        <input type="text" name="total_amount" id="total_amount"
                               class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500"
                               placeholder="R$ 0,00">
                    </div>

                    <!-- Description -->
                    <div  class="col-span-3">
                        <label for="description" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.description') }}
                        </label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500"></textarea>
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
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.category') }}
                        </label>
                        <select name="category_id" id="category_id"
                                class="w-full block min-w-0 grow py-1.5 pr-3 pl-1 text-base rounded-md text-gray-900 outline-1 outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-offset-1 focus:outline-gray-500">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}">{{ $category }}</option>
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
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
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
                                <option value="{{ $i }}">{{ $i }}x</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Transaction Date -->
                    <div>
                        <label for="transaction_date" class="block text-sm/6 font-semibold text-gray-600 mb-2">
                            {{ __('messages.transaction_date') }}
                        </label>
                        <input type="date" name="transaction_date" id="transaction_date"
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
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Função para formatar um número como moeda brasileira (R$)
        function formatBRL(value) {
            // Remove caracteres não numéricos
            value = value.replace(/\D/g, '');
            if (value === '') return '';
            // Converte para número e divide por 100 para inserir os centavos
            let number = parseInt(value, 10) / 100;
            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(number);
        }

        document.getElementById('total_amount').addEventListener('input', function(e) {
            let input = e.target;
            let cursorPosition = input.selectionStart;
            let originalLength = input.value.length;

            // Formata o valor e atualiza o campo
            input.value = formatBRL(input.value);

            // Ajusta a posição do cursor (opcional, pode ser refinado conforme a necessidade)
            let newLength = input.value.length;
            input.selectionStart = input.selectionEnd = cursorPosition + (newLength - originalLength);
        });
    </script>
@endpush
