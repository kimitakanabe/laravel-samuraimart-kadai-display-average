@props(['rating' => null, 'max' => 5])

@if ($rating)
    @php
        $percent = round(($rating / $max) * 100); //round()は小数点を四捨五入し整数を返す
    @endphp
    <span class="star-rating" style="--rating: {{ $percent }}%;"></span>
    <span class="ml-1">({{ number_format($rating, 1) }})</span>
@else
    <span class="text-muted">レビューなし</span>
@endif
