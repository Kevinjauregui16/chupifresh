<div class="bg-[#141318] flex justify-evenly items-center py-8 rounded-xl">
    <div class="flex items-center gap-1">
        <input type="text" placeholder="Buscar..." class="px-4 py-2 rounded-md text-white bg-[#0D0D11] ">
        <button class="p-3 bg-[#0D0D11] text-gray-200 rounded-md flex items-center justify-center">
            <i class="fas fa-search"></i>
        </button>
    </div>
    <a class="py-3 px-6 bg-[#0D0D11] text-green-500 rounded-md flex items-center justify-center"
        href="{{ route('products.create') }}">
        <i class="fas fa-plus font-black"></i>
    </a>
</div>
