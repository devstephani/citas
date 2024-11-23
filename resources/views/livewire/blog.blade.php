@section('page-title')
    {{ $title }}
@endsection

<div>
    <x-page-title :title="$title" :subtitle="$subtitle" />

    <section class="news-area ptb-100">
        <div class="container">
            <div class="section-title">
                <span>Nuestro BLog</span>
                <h2>Noticias y artículos de belleza</h2>
            </div>
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-news">
                            <div class="news-img">
                                <a href="news-details.html">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Image">
                                </a>
                            </div>
                            <div class="news-content-wrap">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="flaticon-user"></i>
                                            {{ $post->user->name }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="flaticon-conversation"></i>
                                            {{ $post->comments()->count() }}
                                        </a>
                                    </li>
                                </ul>
                                <a href="{{ route('post.id', $post->id) }}">
                                    <h3>{{ $post->title }}</h3>
                                </a>
                                <p>{{ $post->description }}</p>
                                <a class="read-more" href="{{ route('post.id', $post->id) }}">
                                    Leer más
                                    <i class="flaticon-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $posts->links() }}
            </div>
        </div>
    </section>
</div>
