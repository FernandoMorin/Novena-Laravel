@props(['status'])
<span class="badge text-bg-{{ \App\Models\Order::STATUSES[$status] ?? 'secondary' }} text-capitalize">{{ $status }}</span>
