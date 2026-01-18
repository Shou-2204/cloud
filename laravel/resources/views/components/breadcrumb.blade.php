@props(['crumbs' => []])

@if(!empty($crumbs))
    <nav aria-label="Breadcrumb" class="py-4 text-sm text-gray-500 dark:text-gray-400">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="/" class="hover:text-gray-900 dark:hover:text-gray-100 transition-colors">Home</a>
                <span class="mx-2">/</span>
            </li>
            @foreach($crumbs as $crumb)
                <li class="flex items-center">
                    @if(!$loop->last)
                        <a href="{{ $crumb['url'] }}"
                            class="hover:text-gray-900 dark:hover:text-gray-100 transition-colors">{{ $crumb['name'] }}</a>
                        <span class="mx-2">/</span>
                    @else
                        <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $crumb['name'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif