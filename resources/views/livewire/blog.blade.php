@section('page-title')
    {{ $title }}
@endsection

<div>
    <x-page-title :title="$title" :subtitle="$subtitle" />

    <section class="news-area ptb-100">
        <div class="container">
            <div class="section-title">
                <h2>Noticias y artículos de belleza</h2>
                <span>Nuestro BLog</span>
            </div>
            @if (count($favorites) > 0)
                <div class="row">
                    <h1 class="font-bold text-2xl">Favoritos</h1>
                    @foreach ($favorites as $favorite)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('post.id', $favorite->id) }}">
                                <div class="single-news">
                                    <div class="news-img">
                                        <img src="{{ asset('storage/' . $favorite->image) }}" alt="Image"
                                            style="max-width: 100%; max-height: 32rem">
                                    </div>
                                    <div class="news-content-wrap">
                                        <div class="flex gap-3">
                                            <p>
                                                {{ $favorite->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="-mt-5 flex gap-3">
                                            @php
                                                $reactions = $favorite->get_reactions();
                                            @endphp
                                            <p class="inline-flex items-center gap-3">
                                                {{ $reactions[0] }}
                                                <x-lucide-thumbs-up class="size-4" />
                                            </p>
                                            <p class="inline-flex items-center gap-3">
                                                {{ $reactions[1] }}
                                                <x-lucide-thumbs-down class="size-4" />
                                            </p>
                                            <p class="inline-flex items-center gap-3">
                                                {{ $favorite->comments()->where('active', 1)->count() }}
                                                <x-lucide-message-circle class="size-4" />
                                            </p>
                                        </div>
                                        <h3 class="text-xl">{{ $favorite->title }}</h3>
                                        <p>{{ $favorite->description }}</p>
                                        <a class="read-more" href="{{ route('post.id', $favorite->id) }}">
                                            Leer más
                                            <i class="flaticon-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    {{ $favorites->links() }}
                </div>
            @endif
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('post.id', $post->id) }}">
                            <div class="single-news">
                                <div class="news-img">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Image"
                                        style="max-width: 100%; max-height: 32rem">
                                </div>
                                <div class="news-content-wrap">
                                    <div class="flex gap-3">
                                        <p>
                                            {{ $post->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="-mt-5 flex gap-3">
                                        @php
                                            $reactions = $post->get_reactions();
                                        @endphp
                                        <p class="inline-flex items-center gap-3">
                                            {{ $reactions[0] }}
                                            <x-lucide-thumbs-up class="size-4" />
                                        </p>
                                        <p class="inline-flex items-center gap-3">
                                            {{ $reactions[1] }}
                                            <x-lucide-thumbs-down class="size-4" />
                                        </p>
                                        <p class="inline-flex items-center gap-3">
                                            {{ $post->comments()->where('active', 1)->count() }}
                                            <x-lucide-message-circle class="size-4" />
                                        </p>
                                    </div>
                                    <h3 class="text-xl">{{ $post->title }}</h3>
                                    <p>{{ $post->description }}</p>
                                    <a class="read-more" href="{{ route('post.id', $post->id) }}">
                                        Leer más
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                {{ $posts->links() }}
            </div>
        </div>
    </section>
</div>
