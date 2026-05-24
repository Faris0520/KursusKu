@props(['rating' => 0, 'max' => 5])

<div class="flex items-center gap-0.5">
    @for($i = 1; $i <= $max; $i++)
        @if($i <= round($rating))
            <span class="text-yellow-400">★</span>
        @else
            <span class="text-gray-300">★</span>
        @endif
    @endfor
    <span class="ml-1 text-sm text-gray-500">({{ number_format($rating, 1) }})</span>
</div>