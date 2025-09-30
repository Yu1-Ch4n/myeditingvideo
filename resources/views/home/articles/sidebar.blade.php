            <div class="col-lg-3 mt-5 mt-lg-0">
                <div class="card card-body shadow-sm border-0 mb-4 p-0">
                    <form action="{{ route('home.information.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari Portofolio..." name="search">
                            <button class="btn btn-outline-secondary" type="submit" value="{{ request('search') }}"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <div class="card card-body shadow-sm border-0 small p-0 mb-4">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                            Kategori Populer
                        </a>
                        @forelse ($categories as $val)
                            <a href="{{ route('home.articles.categories', $val->id) }}"
                                class="list-group-item list-group-item-action">{{ $val->name }}</a>
                        @empty
                            <a href="#" class="list-group-item list-group-item-action">Belum Ada Kategori</a>
                        @endforelse
                    </div>
                </div>

                <div class="card card-body shadow-sm border-0 small p-0 mb-4">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                            Produk Terbaru
                        </a>
                        @forelse ($sidebar as $val)
                            <a href="{{ route('home.articles.show', $val->slug) }}"
                                class="list-group-item list-group-item-action">{{ $val->title }}</a>
                        @empty
                            <a href="#" class="list-group-item list-group-item-action">Belum Ada Produk</a>
                        @endforelse
                    </div>
                </div>
            </div>
