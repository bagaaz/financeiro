@props(['bottom' => '8'])

<div class="fixed bottom-{{ $bottom }} right-4 space-y-2 z-50">
    @if (session('success'))
        <div class="flex justify-between items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            <strong class="font-bold">Sucesso!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="cursor-pointer ml-2" onclick="this.parentElement.remove();">
                @svg('solar-close-circle-linear', ['class' => 'h-5 w-5', 'title' => __('messages.close')])
            </span>
        </div>
    @endif

    @if (session('error'))
        <div class="flex justify-between items-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Erro!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="cursor-pointer ml-2" onclick="this.parentElement.remove();">
                @svg('solar-close-circle-linear', ['class' => 'h-5 w-5', 'title' => __('messages.close')])
            </span>
        </div>
    @endif

    @if (session('warning'))
        <div class="flex justify-between items-center bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Atenção!</strong>
            <span class="block sm:inline">{{ session('warning') }}</span>
            <span class="cursor-pointer ml-2" onclick="this.parentElement.remove();">
                @svg('solar-close-circle-linear', ['class' => 'h-5 w-5', 'title' => __('messages.close')])
            </span>
        </div>
    @endif

    @if (session('info'))
        <div class="flex justify-between items-center bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Informação!</strong>
            <span class="block sm:inline">{{ session('info') }}</span>
            <span class="cursor-pointer ml-2" onclick="this.parentElement.remove();">
                @svg('solar-close-circle-linear', ['class' => 'h-5 w-5', 'title' => __('messages.close')])
            </span>
        </div>
    @endif
</div>
