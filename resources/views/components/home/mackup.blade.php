@props(['posts'])

<section class="news-area pb-60">
    <div class="container">
        <div class="section-title">
            <span>BELLEZA</span>
            <h2>Blog</h2>
        </div>
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('post.id', $post->id) }}">
                        <div class="single-news">
                            <div class="news-img">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Image" class="rounded-md" style="max-width: 100%; max-height: 32rem">
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
        </div>
    </div>
</section>
