<template x-if="openDeleteModal">
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        <div class="bg-white rounded-lg p-6 z-10 max-w-sm mx-auto">
            <h2 class="text-xl font-bold mb-4">Confirmação de Exclusão</h2>
            <p class="mb-4">Deseja realmente deletar esta transação? Todas as parcelas também serão excluídas.</p>
            <div class="flex justify-end">
                <button @click="openDeleteModal = false" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                    Cancelar
                </button>
                <button @click="deleteForm.submit()" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                    Deletar
                </button>
            </div>
        </div>
    </div>
</template>
