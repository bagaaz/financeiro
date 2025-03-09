@extends('layouts.app')

@section('content')
    <div x-data="{ openDeleteModal: false, deleteForm: null }" @open-delete-modal.window="openDeleteModal = true; deleteForm = $event.detail.form">
        {{-- Filtro --}}
        <div x-data="{ open: false }" class="w-full relative inline-block text-left">
            <div class="text-end">
                <button @click="open = !open" type="button" id="filter-menu" aria-expanded="open" aria-haspopup="true">
                    @svg('solar-filter-outline', ['class' => 'h-5 w-5'])
                </button>
            </div>

            {{-- Filtro Menu --}}
            <div x-show="open" x-cloak class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden"
                 role="menu" aria-orientation="vertical" aria-labelledby="filter-menu" tabindex="-1">
                <form class="p-4" method="GET" action="{{ route('transactions.index') }}">
                    {{-- Filtro por Mês --}}
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-500">{{ __('messages.month') }}</label>
                        <select id="month" name="month" class="mt-1 block w-full">
                            <option value="">{{ __('messages.select_option') }}</option>
                            <option value="01" {{ request('month') === '01' ? 'selected' : '' }}>{{ __('messages.jan') }}</option>
                            <option value="02" {{ request('month') === '02' ? 'selected' : '' }}>{{ __('messages.fev') }}</option>
                            <option value="03" {{ request('month') === '03' ? 'selected' : '' }}>{{ __('messages.mar') }}</option>
                            <option value="04" {{ request('month') === '04' ? 'selected' : '' }}>{{ __('messages.apr') }}</option>
                            <option value="05" {{ request('month') === '05' ? 'selected' : '' }}>{{ __('messages.may') }}</option>
                            <option value="06" {{ request('month') === '06' ? 'selected' : '' }}>{{ __('messages.jun') }}</option>
                            <option value="07" {{ request('month') === '07' ? 'selected' : '' }}>{{ __('messages.jul') }}</option>
                            <option value="08" {{ request('month') === '08' ? 'selected' : '' }}>{{ __('messages.aug') }}</option>
                            <option value="09" {{ request('month') === '09' ? 'selected' : '' }}>{{ __('messages.sep') }}</option>
                            <option value="10" {{ request('month') === '10' ? 'selected' : '' }}>{{ __('messages.oct') }}</option>
                            <option value="11" {{ request('month') === '11' ? 'selected' : '' }}>{{ __('messages.nov') }}</option>
                            <option value="12" {{ request('month') === '12' ? 'selected' : '' }}>{{ __('messages.dec') }}</option>
                        </select>
                    </div>

                    {{-- Filtro por Ano --}}
                    <div class="mt-4">
                        <label for="year" class="block text-sm font-medium text-gray-500">{{ __('messages.year') }}</label>
                        <select id="year" name="year" class="mt-1 block w-full">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtro por Título --}}
                    <div class="mt-4">
                        <label for="title" class="block text-sm font-medium text-gray-500">{{ __('messages.title') }}</label>
                        <input type="text" id="title" name="title" value="{{ request('title') }}" class="mt-1 block w-full border-gray-300 rounded-md border">
                    </div>

                    {{-- Novo filtro por Categoria --}}
                    <div class="mt-4">
                        <label for="category" class="block text-sm font-medium text-gray-500">{{ __('messages.category') }}</label>
                        <select id="category" name="category" class="mt-1 block w-full">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}" {{ request('category_id') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtro por Tipo de Registro --}}
                    <div class="mt-4">
                        <label for="record_type" class="block text-sm font-medium text-gray-500">{{ __('messages.transaction_type') }}</label>
                        <select id="record_type" name="record_type" class="mt-1 block w-full">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @foreach(\App\Enums\TransactionType::cases() as $type)
                                <option value="{{ $type->value }}" {{ request('record_type') == $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtro por Forma de Pagamento --}}
                    <div class="mt-4">
                        <label for="payment_type" class="block text-sm font-medium text-gray-500">{{ __('messages.transaction_payment') }}</label>
                        <select id="payment_type" name="payment_type" class="mt-1 block w-full">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @foreach(\App\Enums\PaymentType::cases() as $type)
                                <option value="{{ $type->value }}" {{ request('payment_type') == $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtro por Status --}}
                    <div class="mt-4">
                        <label for="status" class="block text-sm font-medium text-gray-500">{{ __('messages.status') }}</label>
                        <select id="status" name="status" class="mt-1 block w-full">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @foreach(\App\Enums\TransactionStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-between mt-4">
                        <a href="{{ route('transactions.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                            Limpar
                        </a>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <section class="bg-white rounded-lg shadow-sm px-4 py-8 mx-2 my-4">
            <header class="border-b border-gray-200 pb-4 pl-2 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-700">
                    {{ __('messages.transactions') }}
                </h3>
                <a href="{{ route('transactions.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                    {{ __('messages.create') }}
                </a>
            </header>

            <div class="mt-6">
                @if($transactions->isEmpty())
                    <div class="flex flex-col items-center text-lg text-gray-400 py-8">
                        {{ __('messages.no_data_found') }}
                        @svg('solar-notes-minimalistic-linear', ['class' => 'h-50 w-50 text-gray-200 mt-8'])
                    </div>
                @else
                    @php
                        // Array para rastrear o número da parcela para cada transação
                        $installmentNumbers = [];
                    @endphp
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.title') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.total_amount') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.category') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.transaction_type') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.transaction_payment') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.status') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.transaction_date') }}
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->transaction->title }}
                                    <br>
                                    <small>
                                        {{ $transaction->installment_number }} / {{ $transaction->transaction->installments_count }}
                                    </small>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="font-semibold">{{ $transaction->installment_amount }}</span> / {{ $transaction->transaction->total_amount }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->transaction->category->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->transaction->transaction_type->label() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->transaction->payment_type->label() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="py-1 px-2 rounded-full bg-{{$transaction->status->color()}}-300">{{ $transaction->status->label() }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->transaction_date->format('m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 relative">
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" class="focus:outline-none">
                                            @svg('solar-menu-dots-bold', ['class' => 'h-5 w-5'])
                                        </button>
                                        <div x-show="open" x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-md z-10">
                                            <a href="{{ route('transactions.edit', $transaction->transaction->id) }}" class="block flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                @svg('solar-pen-new-square-linear', ['class' => 'h-5 w-5 mr-2'])
                                                {{ __('messages.edit') }}
                                            </a>
                                            <a href="{{ route('transactions.status', $transaction->id) }}" class="block flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                @svg('solar-refresh-linear', ['class' => 'h-5 w-5 mr-2'])
                                                {{ __('messages.update_status') }}
                                            </a>
                                            <form action="{{ route('transactions.destroy', $transaction->transaction->id) }}" method="POST" class="block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        @click="$dispatch('open-delete-modal', { form: $el.closest('form') })"
                                                        class="w-full flex items-center text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
                @endif
            </div>
        </section>
        @include('pages.transactions.delete-transaction-modal')
    </div>
@endsection
