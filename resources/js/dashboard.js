import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

document.addEventListener("DOMContentLoaded", function() {
    const ctxGastosCategorias = document.getElementById('gastosCategorias').getContext('2d');
    const ctxReceitasCategorias = document.getElementById('receitasCategorias').getContext('2d');
    const ctxBalancoPeriodo = document.getElementById('balancoPeriodo').getContext('2d');
    const ctxBalancoAnual = document.getElementById('balancoAnual').getContext('2d');

    const gastosCategorias = new Chart(ctxGastosCategorias, {
        type: 'doughnut',
        data: {
            labels: [
                'Alimentação',
                'Transporte',
                'Lazer'
            ],
            datasets: [{
                label: 'Total: ',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        }
    });

    const receitasCategorias = new Chart(ctxReceitasCategorias, {
        type: 'doughnut',
        data: {
            labels: [
                'Salario',
                'Freelancer',
            ],
            datasets: [{
                label: 'Total: ',
                data: [70, 30],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)'
                ],
                hoverOffset: 4
            }]
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
                    data: Array.from({ length: 12 }, () => Math.floor(Math.random() * 100)),
                    borderColor: 'rgb(32, 227, 74)',
                    backgroundColor: 'rgba(32, 227, 74, 0.2)',
                    fill: true,
                    tension: 0.1,
                },
                {
                    label: 'Saídas',
                    data: Array.from({ length: 12 }, () => Math.floor(Math.random() * 100)),
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
            }
        }
    });
});
