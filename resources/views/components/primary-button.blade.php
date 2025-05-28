<button {{ $attributes->merge([
    'type' => 'submit',
    'class' =>
        'inline-flex items-center justify-center px-6 py-2 rounded-xl text-sm font-semibold tracking-wide ' .
        'bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white shadow-md ' .
        'hover:from-indigo-600 hover:via-purple-600 hover:to-pink-600 ' .
        'focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400 ' .
        'transition-all duration-300 ease-in-out'
]) }}>
    {{ $slot }}
</button>
