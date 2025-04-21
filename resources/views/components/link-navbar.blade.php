<a href="{{ $href }}" @class([
    'flex items-center text-gray-300 text-xl cursor-pointer py-3 w-full border-l-4 border-primary pl-8 gap-4',
    'border-white font-black text-white' => request()->url() === $href,
])>
    <i class="fa-solid fa-{{ $icon }} fa-lg"></i>
    <span>{{ $slot }}</span>
</a>
