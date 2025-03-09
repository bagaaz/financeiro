@extends('layouts.app')

@section('content')
    <!-- Filtro e Gráfico -->
    <div x-data="{ open: false }" class="w-full relative inline-block text-left">
        <div class="text-end text-gray-600">
            <button @click="open = !open" type="button" id="filter-menu" aria-expanded="open" aria-haspopup="true">
                @svg('solar-filter-bold', ['class' => 'h-6 w-6'])
            </button>
        </div>

        {{-- Filtro Menu --}}
        <div x-show="open" class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden"
             role="menu" aria-orientation="vertical" aria-labelledby="filter-menu" tabindex="-1">
            <div class="p-4">
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-500">{{ __('messages.month') }}</label>
                    <select id="month" name="month" class="mt-1 block w-full">
                        <option value="01">{{ __('messages.jan') }}</option>
                        <option value="02">{{ __('messages.fev') }}</option>
                        <option value="03">{{ __('messages.mar') }}</option>
                        <option value="04">{{ __('messages.apr') }}</option>
                        <option value="05">{{ __('messages.may') }}</option>
                        <option value="06">{{ __('messages.jun') }}</option>
                        <option value="07">{{ __('messages.jul') }}</option>
                        <option value="08">{{ __('messages.aug') }}</option>
                        <option value="09">{{ __('messages.sep') }}</option>
                        <option value="10">{{ __('messages.oct') }}</option>
                        <option value="11">{{ __('messages.nov') }}</option>
                        <option value="12">{{ __('messages.dec') }}</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label for="year" class="block text-sm font-medium text-gray-500">{{ __('messages.year') }}</label>
                    <select id="year" name="year" class="mt-1 block w-full">
                        @foreach($years as $year)
                            <option value="{{$year}}">{{$year}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards com os indicadores -->
    <div class="mt-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-gray-500 text-sm">Valor Pago</div>
                <div class="text-xl font-bold">{{ $valorPago }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-gray-500 text-sm">Valor a Pagar</div>
                <div class="text-xl font-bold">{{ $valorAPagar }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-gray-500 text-sm">Total Gasto</div>
                <div class="text-xl font-bold">{{ $totalGastos }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-gray-500 text-sm">Total Entradas</div>
                <div class="text-xl font-bold">{{ $totalEntradas }}</div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-gray-500">Gastos por Categoria</h2>
                <canvas id="gastosCategorias"></canvas>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-gray-500">Receitas por Categoria</h2>
                <canvas id="receitasCategorias"></canvas>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-gray-500">Balanço Período</h2>
                <canvas id="balancoPeriodo" height="300"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-gray-500">Balanço Anual</h2>
            <canvas id="balancoAnual" height="60"></canvas>
        </div>
    </div>
@endsection
