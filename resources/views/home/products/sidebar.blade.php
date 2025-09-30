            <div class="col-lg-3 mt-5 mt-lg-0">
                <div class="card card-body shadow-sm border-0 mb-4 p-0">
                    <form action="{{ route('home.products.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari Produk..." name="search">
                            <button class="btn btn-outline-secondary" type="submit" value="{{ request('search') }}"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <div class="card card-body shadow-sm border-0 small p-0 mb-4">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                            Type yang Tersedia
                        </a>
                        @forelse ($types as $val)
                            <a href="{{ route('home.products.types', $val->id) }}"
                                class="list-group-item list-group-item-action">{{ $val->name }}</a>
                        @empty
                            <a href="#" class="list-group-item list-group-item-action">Belum Ada Type</a>
                        @endforelse
                    </div>
                </div>

                <div class="card card-body shadow-sm border-0 small p-0 mb-4">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                            Informasi Terbaru
                        </a>
                        @forelse ($sidebar as $val)
                            <a href="{{ route('home.information.show', $val->slug) }}"
                                class="list-group-item list-group-item-action">{{ $val->title }}</a>
                        @empty
                            <a href="#" class="list-group-item list-group-item-action">Belum Ada Informasi</a>
                        @endforelse
                    </div>
                </div>
            </div>
