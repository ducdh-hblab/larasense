@props(['material'])

<article
    class="relative flex flex-col border-2 border-secondary hover:border-primary cursor-pointer p-4 rounded-xl"
    x-intersect.once.full="$wire.viewed()"
>
    <a
        class="absolute size-full inset-0"
        x-on:click="() => {
            $dispatch('open-modal', { slug: 'material.{{ $material->slug }}' });
            $wire.expanded();
        }"
    ></a>
    <div class="flex flex-col h-full space-y-4">
        <div class="flex justify-between items-center">
            <div class="avatar">
                <div class="w-8 rounded-full">
                    <img src="{{ asset('storage/' . $material->source->publisher->logo) }}" />
                </div>
            </div>
            <div>
                @if ($material->isArticle())
                    <span class="inline-flex items-center justify-center mx-0 size-8 rounded-full bg-stone-700">
                        <x-heroicon-o-pencil-square class="inline size-4 stroke-white" />
                    </span>
                @elseif ($material->isYoutube())
                    <span class="inline-flex items-center justify-center mx-0 size-8 rounded-full bg-red-500">
                        <x-heroicon-o-video-camera class="inline size-4 stroke-white fill-white" />
                    </span>
                @elseif ($material->isPodcast())
                    <span class="inline-flex items-center justify-center mx-0 size-8 rounded-full bg-purple-500">
                        <x-heroicon-o-microphone class="inline size-4 stroke-white" />
                    </span>
                @endif
            </div>
        </div>
        <figure class="relative rounded-box overflow-hidden flex justify-center items-center pointer-events-none">
            <img
                src="{{ $material->thumbnail }}"
                alt=""
                class="rounded-box w-full h-40 object-cover"
            >
            @if ($material->isYoutube() || $material->isPodcast())
                <span class="absolute size-full bg-[#00000052] hover:bg-inherit"></span>
                <div class="absolute size-full flex justify-center items-center">
                    <button class="btn btn-primary btn-circle border-2 border-white">
                        <x-heroicon-s-play class="size-6 stroke-white fill-white" />
                    </button>
                </div>
            @endif
        </figure>
        <div class="flex gap-x-1 text-xs opacity-70 pointer-events-none">
            <div>
                {{ $material->published_at->inUserTimezone()->toFormattedDateString() }}
            </div>
            <div>
                ·
            </div>
            <div>
                5mins
            </div>
        </div>
        <div class="flex-1">
            <h1 class="font-bold text-sm line-clamp-2">
                {!! $material->title !!}
            </h1>
            <h2 class="text-xs line-clamp-2">
                {{ str($material->description)->stripTags() }}
            </h2>
        </div>
        <div class="flex justify-between items-center">
            <div
                class="tooltip"
                data-tip="Like this post"
                x-data="likeMaterial(
                    '{{ $material->slug }}',
                    @js($this->isLiked),
                    {{ $this->likesCount }}
                )"
                x-on:dislike-material.window="unlike($event.detail.slug)"
            >
                <button
                    class="inline-flex items-center gap-x-1"
                    x-on:click="like"
                >
                    <x-heroicon-o-hand-thumb-up
                        x-cloak
                        class="inline-flex size-6 hover:stroke-primary"
                        x-bind:class="{
                            'stroke-primary fill-primary': isLiked,
                            'stroke-stone-800': !isLiked
                        }"
                    />
                    <span
                        class="opacity-70 text-sm"
                        x-text="likesCount > 0 ? likesCount : null"
                    >
                    </span>
                </button>
            </div>
            <div
                class="tooltip"
                data-tip="Disike this post"
                x-data="dislikeMaterial('{{ $material->slug }}', {{ $this->isDisliked }})"
                x-on:like-material.window="undislike($event.detail.slug)"
            >
                <button
                    class="inline-flex"
                    x-on:click="dislike"
                >
                    <x-heroicon-o-hand-thumb-down
                        x-cloak
                        class="inline-flex size-6 hover:stroke-primary"
                        x-bind:class="{
                            'stroke-primary fill-primary': isDisliked,
                            'stroke-stone-800': !isDisliked
                        }"
                    />
                </button>
            </div>
            <div
                class="tooltip"
                data-tip="Bookmark"
            >
                <button class="inline-flex">
                    <x-heroicon-o-bookmark class="inline-flex size-6 hover:stroke-primary stroke-stone-800" />
                </button>
            </div>
            <div
                class="tooltip"
                data-tip="Copy Link"
            >
                <button class="inline-flex">
                    <x-heroicon-o-link class="inline-flex size-6 hover:stroke-primary stroke-stone-800" />
                </button>
            </div>
            @if ($material->isPodcast())
                <div
                    class="tooltip tooltip-left"
                    data-tip="Play/Pause"
                >
                    <button
                        class="inline-flex"
                        x-on:click="() => {
                            $dispatch('play-podcast', { title: '{{ $material->title }}', url: '{{ $material->url }}', thumbnail: '{{ $material->thumbnail }}' });
                            $wire.played();
                        }"
                        x-show="$store.mainPodcastPlayer.url !== '{{ $material->url }}' || !$store.mainPodcastPlayer.isPlaying"
                    >
                        <x-heroicon-o-play class="inline-flex size-6 hover:stroke-primary stroke-stone-800" />
                    </button>
                    <button
                        class="inline-flex"
                        x-on:click="$dispatch('pause-podcast')"
                        x-show="$store.mainPodcastPlayer.url === '{{ $material->url }}' && $store.mainPodcastPlayer.isPlaying"
                    >
                        <x-heroicon-o-pause class="inline-flex size-6 hover:stroke-primary stroke-stone-800" />
                    </button>
                </div>
            @elseif ($material->isYoutube())
                <div
                    class="tooltip tooltip-left"
                    data-tip="Play"
                >
                    <button
                        class="inline-flex"
                        x-on:click="() => {
                            $dispatch('open-modal', { slug: 'material.{{ $material->slug }}' });
                            $wire.expanded();
                        }"
                    >
                        <x-heroicon-o-play class="inline-flex size-6 hover:stroke-primary stroke-stone-800" />
                    </button>
                </div>
            @elseif ($material->isArticle())
                <div
                    class="tooltip tooltip-left"
                    data-tip="Redirect to source"
                >
                    <a
                        class="inline-flex"
                        href="{{ $material->url }}"
                        target="_blank"
                        x-on:click="$wire.redirected()"
                    >
                        <x-heroicon-o-arrow-top-right-on-square class="inline-flex size-6 hover:stroke-primary stroke-stone-800" />
                    </a>
                </div>
            @endif
        </div>
    </div>

    <x-material-modal :$material />
</article>
