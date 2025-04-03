<a href="{{ $href }}" @class([
    'text-white text-xl text-center font-bold cursor-pointer hover:bg-black hover:bg-opacity-40 py-3 w-full',
    'bg-black bg-opacity-40' => request()->url() === $href,
])>
    {{ $slot }}
</a>
