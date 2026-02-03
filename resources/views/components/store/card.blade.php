@props(['store'])

<div class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition overflow-hidden">
    {{-- Header --}}
    <div class="p-5">
        <h2 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition">
            {{ $store->name }}
        </h2>
        <img
            src="{{ $store->cover_url }}"
            alt="{{ $store->name }}"
            class="h-36 w-full object-cover"
        />


        @if($store->description)
            <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                {{ $store->description }}
            </p>
        @else
            <p class="mt-2 text-sm text-gray-400 italic">
                No description provided
            </p>
        @endif

        {{-- Owner info --}}
        @if($store->user)
            <div class="mt-4 flex items-center gap-3">
                <span class="inline-flex rounded-full p-0.5 {{ $store->user->last_online_at && $store->user->last_online_at->diffInMinutes(now()) < 1 ? 'border border-green-400 ring-2 ring-green-200' : 'border border-gray-200' }}">
                    <img
                        src="{{ $store->user->avatar ? asset($store->user->avatar) : 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 width=%2240%22 height=%2240%22><rect width=%22100%25%22 height=%22100%25%22 fill=%22%23e5e7eb%22/><path d=%22M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z%22 fill=%22%236b7280%22/></svg>' }}"
                        alt="{{ $store->user->name }}"
                        class="w-10 h-10 rounded-full object-cover border border-white"
                    />
                </span>

                <div class="text-sm">
                    <div class="font-medium text-gray-900">{{ $store->user->name }}</div>
                    @if($store->user->last_online_at)
                        <div class="text-xs mt-0.5">
                            @if($store->user->last_online_at->diffInMinutes(now()) < 5)
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                    ONLINE
                                </span>
                            @else
                                <span class="text-gray-500">
                                    Last online {{ $store->user->last_online_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    @endif

                    @if($store->user->twitter || $store->user->telegram || $store->user->discord)
                        <div class="text-xs text-gray-500 mt-0.5">
                            @if($store->user->twitter)
                                <a href="https://x.com/{{ ltrim($store->user->twitter, '@') }}" target="_blank" rel="noopener" class="hover:underline">X</a>
                            @endif

                            @if($store->user->telegram)
                                @if($store->user->twitter)
                                    <span class="mx-1">·</span>
                                @endif
                                <a href="https://t.me/{{ ltrim($store->user->telegram, '@') }}" target="_blank" rel="noopener" class="hover:underline">Telegram</a>
                            @endif

                            @if($store->user->discord)
                                <span class="mx-1">·</span>
                                <span>Discord: {{ $store->user->discord }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- Divider --}}
    <div class="border-t border-gray-100"></div>

    {{-- Actions --}}
    <div class="flex items-center justify-between px-5 py-3 text-sm bg-gray-50">
        <a
            href="{{ route('stores.show', $store) }}"
            class="text-indigo-600 font-medium hover:underline"
        >
            View store →
        </a>
        @if(Auth::user() && Auth::user()->id === $store->user_id)
        <a
            href="{{ route('stores.edit', $store) }}"
            class="text-gray-500 hover:text-yellow-600 transition"
        >
            Edit
        </a>
        @endif
    </div>
</div>
