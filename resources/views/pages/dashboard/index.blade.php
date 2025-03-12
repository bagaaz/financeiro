@extends('layouts.app')

@section('content')
    <!-- Filtro e Gráfico -->
    <div class="w-full flex justify-start text-left">
        <div class="mt-4">
            <label for="daterange" class="block text-sm font-medium text-gray-500">Selecione o Período</label>
            <input type="text" name="daterange" id="daterange" class="mt-1" />
        </div>
    </div>

    <!-- Cards com os indicadores -->
    <div class="mt-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-gray-500 text-sm">Valor Pago</div>
                <div class="text-xl font-bold" data-paid-value>R$ 00,00</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-gray-500 text-sm">Valor a Pagar</div>
                <div class="text-xl font-bold" data-pending-value>R$ 00,00</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-gray-500 text-sm">Total Gasto</div>
                <div class="text-xl font-bold" data-total-expanse>R$ 00,00</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-gray-500 text-sm">Total Entradas</div>
                <div class="text-xl font-bold" data-total-income>R$ 00,00</div>
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

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        const paidValue = document.querySelector('[data-paid-value]');
        const pendingValue = document.querySelector('[data-pending-value]');
        const totalExpanse = document.querySelector('[data-total-expanse]');
        const totalIncome = document.querySelector('[data-total-income]');

        $(function() {
            $('#daterange').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                startDate: moment().startOf('month'),
                endDate: moment().endOf('month')
            }, function(start, end, label) {
                $.ajax({
                    url: '{{ route('dashboard.data') }}',
                    type: 'GET',
                    data: {
                        start: start.format('YYYY-MM-DD'),
                        end: end.format('YYYY-MM-DD')
                    },
                    success: function(data) {
                        console.log('Dados retornados:', data);

                        paidValue.innerHTML = data.paidValue;
                        pendingValue.innerHTML = data.pendingValue;
                        totalExpanse.innerHTML = data.totalExpanse;
                        totalIncome.innerHTML = data.totalIncome;
                    },
                    error: function(error) {
                        console.error("Erro na requisição:", error);
                    }
                })
            });
        });
    </script>
@endpush
