<x-app-layout title="User" :sidebar="true">
    <x-sidebar/>
    <div class="d-flex p-4 w-100" style="margin-left: 280px;">
        <div class="container-fluid">
            <h3 class="text-center">Data Pelamar</h3>
            <hr>
            <div class="d-flex justify-content-end align-items-center gap-3">
                <div class="mb-3">
                    <label for="position" class="form-label">Pendidikan Terakhir</label>
                    <select id="filter_education" class="form-select">
                        <option value="">Pilih Pendidikan</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="SMK">SMK</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
                <div class="btn btn-danger" id="btn-reset">Reset</div>
            </div>
            <table id="dataTable" class="table table-striped mb-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Posisi Terakhir</th>
                        <th>Tempat Tanggal Lahir</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    @endpush
</x-app-layout>
