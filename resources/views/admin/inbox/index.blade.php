@extends('layouts.admin.master')

@section('inboxActive')
    text-primary
@endsection

@section('content')
    <div class="container">
        <h1><i class="fa-solid fa-inbox"></i> Managenen Pesan</h1>
        <p class="lead">Kelola daftar pesan yang masuk.</p>
    </div>
    <br>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-list"></i> Daftar Pesan Masuk</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="servicesTable">
                            <thead>
                                <tr class="text-center bg-light">
                                    <th>No.</th>
                                    <th>Nama Pengirim</th>
                                    <th>Alamat Email</th>
                                    <th>Subject</th>
                                    <th>Status</th> {{-- Kolom baru untuk Status --}}
                                    <th>Dibuat Pada</th>
                                    <th>Aksi</th>
                                    <th>Respon</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inbox as $val)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + ($inbox->currentPage() - 1) * $inbox->perPage() }}</td>
                                        <td class="text-center">{{ $val->name }}</td>
                                        <td class="text-center">{{ $val->email }}</td>
                                        <td class="text-center">{{ $val->subject }}</td>
                                        <td class="text-center">
                                            @if ($val->status)
                                                <span class="badge bg-primary">Direspon</span>
                                            @else
                                                <span class="badge bg-danger">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $val->created_at->format('d M Y H:i') }}</td>
                                        <td class="text-center">
                                            {{-- Tombol "Lihat" untuk detail pesan menggunakan modal --}}
                                            <button type="button" class="btn btn-sm btn-info text-white view-message-btn"
                                                data-bs-toggle="modal" data-bs-target="#messageModal"
                                                data-name="{{ $val->name }}" data-email="{{ $val->email }}"
                                                data-subject="{{ $val->subject }}" data-message="{{ $val->message }}"
                                                title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            {{-- Tombol kirim pesan balasan --}}
                                            <a target="_blank"
                                                href="https://mail.google.com/mail/u/0/?view=cm&tf=1&fs=1&to={{ $val->email }}"
                                                class="btn btn-sm btn-success" title="Kirim"><i
                                                    class="fa fa-paper-plane"></i></a>
                                            {{-- Tombol hapus --}}
                                            <form action="{{ route('admin.inbox.destroy', $val->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus Pesan ini? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            {{-- Tombol untuk mengubah status dari false menjadi true atau sebaliknya --}}
                                            <form action="{{ route('admin.inbox.toggleStatus', $val->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT') {{-- Menggunakan metode PUT untuk update --}}
                                                <button type="submit"
                                                    class="btn btn-sm {{ $val->status ? 'btn-primary' : 'btn-danger' }}"
                                                    title="{{ $val->status ? 'Set Pending' : 'Set Direspon' }}"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengubah status pesan ini?')">
                                                    <i
                                                        class="fas {{ $val->status ? 'fa-check-circle' : 'fa-circle-exclamation' }}"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Struktur Modal Pesan -->
    <div class="modal fade" data-bs-backdrop="static" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Detail Pesan Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Pengirim:</strong> <span id="modalSenderName"></span></p>
                    <p><strong>Email:</strong> <span id="modalSenderEmail"></span></p>
                    <p><strong>Subjek:</strong> <span id="modalSubject"></span></p>
                    <hr>
                    <p><strong>Pesan:</strong></p>
                    <p id="modalMessageContent" class="text-break"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var messageModal = document.getElementById('messageModal');
            // Tambahkan event listener untuk saat modal akan ditampilkan
            messageModal.addEventListener('show.bs.modal', function(event) {
                // Dapatkan tombol yang memicu modal
                var button = event.relatedTarget;

                // Ekstrak informasi dari atribut data-bs-* tombol
                var name = button.getAttribute('data-name');
                var email = button.getAttribute('data-email');
                var subject = button.getAttribute('data-subject');
                var message = button.getAttribute('data-message');

                // Dapatkan elemen modal tempat konten akan ditampilkan
                var modalSenderName = messageModal.querySelector('#modalSenderName');
                var modalSenderEmail = messageModal.querySelector('#modalSenderEmail');
                var modalSubject = messageModal.querySelector('#modalSubject');
                var modalMessageContent = messageModal.querySelector('#modalMessageContent');

                // Perbarui konten modal dengan data yang diekstrak
                modalSenderName.textContent = name;
                modalSenderEmail.textContent = email;
                modalSubject.textContent = subject;
                modalMessageContent.textContent = message;
            });
        });
    </script>
@endpush
