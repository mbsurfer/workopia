@props(['type' => 'info', 'message', 'timeout' => 5000])
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, {{ $timeout }})"
    x-show="show"
    @class(['p-4', 'mb-4', 'text-sm', 'text-white', 'rounded',
        'bg-blue-500' => $type === 'info',
        'bg-green-500' => $type === 'success',
        'bg-red-500' => $type === 'error',
    ])>
        {{ $message }}
</div>