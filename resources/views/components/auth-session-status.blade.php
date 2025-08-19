@props(['statut'])

@if ($statut)
<div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
    {{ $statut }}
</div>
@endif