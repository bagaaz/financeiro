import 'daterangepicker';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

document.addEventListener("DOMContentLoaded", function() {
    const ctxGastosCategorias = document.getElementById('gastosCategorias').getContext('2d');
    const ctxReceitasCategorias = document.getElementById('receitasCategorias').getContext('2d');
    const ctxBalancoPeriodo = document.getElementById('balancoPeriodo').getContext('2d');
    const ctxBalancoAnual = document.getElementById('balancoAnual').getContext('2d');

    const paidValue = document.querySelector('[data-paid-value]');
    const pendingValue = document.querySelector('[data-pending-value]');
    const totalExpanse = document.querySelector('[data-total-expanse]');
    const totalIncome = document.querySelector('[data-total-income]');

    const gastosCategorias = new Chart(ctxGastosCategorias, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                label: 'Total: ',
                data: [],
                backgroundColor: [],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (context.parsed !== undefined) {
                                label += new Intl.NumberFormat('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL'
                                }).format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    const receitasCategorias = new Chart(ctxReceitasCategorias, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                label: 'Total: ',
                data: [],
                backgroundColor: [],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (context.parsed !== undefined) {
                                label += new Intl.NumberFormat('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL'
                                }).format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    const balancoPeriodo = new Chart(ctxBalancoPeriodo, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul'],
            datasets: [{
                label: 'Gastos',
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            // Verifica se o valor está encapsulado em um objeto (por exemplo, para gráficos de linha)
                            let value = typeof context.parsed === 'object' ? context.parsed.y : context.parsed;
                            if (value !== undefined) {
                                // Converte para número, se necessário
                                let numericValue = parseFloat(value);
                                // Formata o valor absoluto e adiciona o sinal de negativo manualmente se necessário
                                let formatted = new Intl.NumberFormat('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL'
                                }).format(Math.abs(numericValue));
                                if (numericValue < 0) {
                                    formatted = '-' + formatted;
                                }
                                label += formatted;
                            }
                            return label;
                        }
                    }
                }
            }
        },
    });

    const balancoAnual = new Chart(ctxBalancoAnual, {
        type: 'line',
        data: {
            title: 'Balanço Anual',
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [
                {
                    label: 'Entradas',
                    data: [],
                    borderColor: 'rgb(32, 227, 74)',
                    backgroundColor: 'rgba(32, 227, 74, 0.2)',
                    fill: true,
                    tension: 0.1,
                },
                {
                    label: 'Saídas',
                    data: [],
                    borderColor: 'rgb(227, 74, 32)',
                    backgroundColor: 'rgba(227, 74, 32, 0.2)',
                    fill: true,
                    tension: 0.1,
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            // Verifica se o valor está encapsulado em um objeto (por exemplo, para gráficos de linha)
                            let value = typeof context.parsed === 'object' ? context.parsed.y : context.parsed;
                            if (value !== undefined) {
                                // Converte para número, se necessário
                                let numericValue = parseFloat(value);
                                // Formata o valor absoluto e adiciona o sinal de negativo manualmente se necessário
                                let formatted = new Intl.NumberFormat('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL'
                                }).format(Math.abs(numericValue));
                                if (numericValue < 0) {
                                    formatted = '-' + formatted;
                                }
                                label += formatted;
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Função que realiza a consulta AJAX e atualiza os dados do dashboard
    function atualizarDashboard(start, end, label) {
        $.ajax({
            url: '/dashboard/data',
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

                const labelsExpanseByCategory = data.expanseByCategory.map(item => item.category);
                const dataExpanseByCategory = data.expanseByCategory.map(item => item.total);
                const colorsExpanseByCategory = data.expanseByCategory.map(item => item.color);

                const labelsIncomeByCategory = data.incomeByCategory.map(item => item.category);
                const dataIncomeByCategory = data.incomeByCategory.map(item => item.total);
                const colorsIncomeByCategory = data.incomeByCategory.map(item => item.color);

                const labelsPeriodBalance = data.periodBalance.map(item => item.period);
                const dataPeriodBalance = data.periodBalance.map(item => parseFloat(item.balance));
                const periodBackgroundColors = dataPeriodBalance.map(value =>
                    value < 0 ? 'rgba(227, 74, 32, 0.2)' : 'rgba(32, 227, 74, 0.2)'
                );
                const periodBorderColors = dataPeriodBalance.map(value =>
                    value < 0 ? 'rgb(227, 74, 32)' : 'rgb(32, 227, 74)'
                );

                gastosCategorias.data.labels = labelsExpanseByCategory;
                gastosCategorias.data.datasets[0].data = dataExpanseByCategory;
                gastosCategorias.data.datasets[0].backgroundColor = colorsExpanseByCategory;
                gastosCategorias.update();

                receitasCategorias.data.labels = labelsIncomeByCategory;
                receitasCategorias.data.datasets[0].data = dataIncomeByCategory;
                receitasCategorias.data.datasets[0].backgroundColor = colorsIncomeByCategory;
                receitasCategorias.update();

                balancoPeriodo.data.labels = labelsPeriodBalance;
                balancoPeriodo.data.datasets[0].data = dataPeriodBalance;
                balancoPeriodo.data.datasets[0].backgroundColor = periodBackgroundColors;
                balancoPeriodo.data.datasets[0].borderColor = periodBorderColors;
                balancoPeriodo.update();

                balancoAnual.data.datasets[0].data = data.annualBalance.income;
                balancoAnual.data.datasets[1].data = data.annualBalance.expense;
                balancoAnual.update();
            },
            error: function(error) {
                console.error("Erro na requisição:", error);
            }
        });
    }

    $(function() {
        const start = moment().startOf('month');
        const end = moment().endOf('month');

        $('#daterange').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            startDate: start,
            endDate: end
        }, atualizarDashboard);

        atualizarDashboard(start, end, '');
    });
});
