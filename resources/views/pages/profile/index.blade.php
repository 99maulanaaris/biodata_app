<x-app-layout title="Profile" :sidebar="true">
    <div class="d-flex p-4 w-100" style="margin-left: 280px;">
        <div class="container-fluid">
            <h3 class="text-center">Data Pribadi Pelamar</h3>
            <hr>
            <form action="{{ route('store.profile') }}" method="POST">
                @csrf
                @method('POST')
                @php
                     $title = "Simpan";
                @endphp
                @if ($user->biodata)
                    @php
                        if($user->biodata->id)
                            $title = "update";
                    @endphp
                <input type="hidden" name="id_biodata" value="{{ $user->biodata->id }}">
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="position" class="form-label">Posisi Yang Dilamar</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="text" class="form-control" value="{{ old('position', ($user->biodata->position ?? '')) }}" id="position" name="position">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="email" class="form-control" value="{{ old('email', ($user->email ?? '')) }}" id="email" placeholder="Input Your Email" name="email">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="text" class="form-control" value="{{ old('name', ($user->name ?? '')) }}" id="name" placeholder="Input Your Name" name="name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No Telp</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="text" class="form-control" id="no_telp" placeholder="Input Your Phone Number" name="no_telp" value="{{ old('no_telp', ($user->biodata->no_telp ?? '')) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="no_ktp" class="form-label">No KTP</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="text" class="form-control" id="no_ktp" placeholder="Input Your Phone Number" name="no_ktp" value="{{ old('no_ktp', ($user->biodata->no_ktp ?? '')) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="brithday" class="form-label">Tempat, Tanggal Lahir</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="text" class="form-control" id="brithday" placeholder="Jakarta, 20 April 1998" name="brithday" value="{{ old('brithday', ($user->biodata->brithday ?? '')) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" aria-label="Default select example" name="gender">
                                @if ($user->biodata)
                                    <option selected>Pilih Jenis Kelamin</option>
                                    <option value="male" {{ $user->biodata->gender === 'male' ? 'selected' : ''}}>Laki - Laki</option>
                                    <option value="female" {{ $user->biodata->gender === 'female' ? 'selected' : ''}}>Perempuan</option>
                                @else
                                    <option selected>Pilih Jenis Kelamin</option>
                                    <option value="male">Laki - Laki</option>
                                    <option value="female">Perempuan</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="religion" class="form-label">Agama</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="text" class="form-control" id="religion" name="religion" value="{{ old('religion', ($user->biodata->religion ?? '')) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="blood" class="form-label">Golongan Darah</label>
                            <input type="text" class="form-control" id="blood" name="blood" value="{{ old('blood', ($user->biodata->blood ?? '')) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="text" class="form-control" id="status" name="status" value="{{ old('status', ($user->biodata->status ?? '')) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contact_darurat" class="form-label">No Kontak Darurat</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="text" class="form-control" id="contact_darurat" name="contact_darurat" value="{{ old('contact_darurat', ($user->biodata->contact_darurat ?? '')) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="sallary" class="form-label">Gaji</label>
                            <span class="text-lg text-danger">*</span>
                            <input type="text" class="form-control" id="sallary" name="sallary" data-type='currency' value="{{ old('sallary', ($user->biodata ? formatRupiah($user->biodata->sallary) : '')) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address_ktp" class="form-label">Alamat KTP</label>
                            <span class="text-lg text-danger">*</span>
                            <textarea class="form-control" name="address_ktp" id="address_ktp" cols="3" rows="5">{{ old('address_ktp', ($user->biodata->address_ktp ?? '')) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <span class="text-lg text-danger">*</span>
                            <textarea class="form-control" name="address" id="address" cols="3" rows="5">{{ old('address', ($user->biodata->address ?? '')) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="skill" class="form-label">Skill</label>
                            <span class="text-lg text-danger">*</span>
                            <textarea class="form-control" name="skill" id="skill" cols="3" rows="5">{{ old('skill', ($user->biodata->skill ?? '')) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="skill" class="form-label">Pendidikan Terakhir</label>
                            <span class="text-lg text-danger">*</span>
                        </div>
                    </div>
                    <div class="col-md" style="text-align: end">
                        <div class="btn btn-success" id="btn-education"><i class="bi bi-plus-lg"></i></div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped mb-3">
                            <thead>
                                <tr>
                                    <th>Pendidikan Terakhir</th>
                                    <th>Nama Institusi Akademik</th>
                                    <th>Jurusan</th>
                                    <th>Tahun Lulus</th>
                                    <th>IPK</th>
                                </tr>
                            </thead>
                            <tbody id="clone-education">
                                @if ($user->education->isNotEmpty())
                                    @foreach ($user->education as $education)
                                        <input type="hidden" name="id_education[]" value="{{ $education->id }}">
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" id="last_education" name="last_education[]" value="{{ old('last_education.' . $loop->index, $education->last_education ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="name_of_institution" name="name_of_institution[]" value="{{ old('name_of_institution.' . $loop->index, $education->name_of_institution ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="major" name="major[]" value="{{ old('major.' . $loop->index, $education->major ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="last_year_education" name="last_year_education[]" value="{{ old('last_year_education.' . $loop->index, $education->last_year_education ?? '') }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="ipk" name="ipk[]" value="{{ old('ipk.' . $loop->index, $education->ipk ?? '') }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="last_education" name="last_education[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="name_of_institution" name="name_of_institution[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="major" name="major[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="last_year_education" name="last_year_education[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="ipk" name="ipk[]">
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="skill" class="form-label">Riwayat Pelatihan</label>
                            <span class="text-lg text-danger">*</span>
                        </div>
                    </div>
                    <div class="col-md" style="text-align: end">
                        <div class="btn btn-success" id="btn-traning"><i class="bi bi-plus-lg"></i></div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped mb-3">
                            <thead>
                                <tr>
                                    <th>Nama Kursus / Seminar</th>
                                    <th>Sertifikat</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody id="clone-training">
                                @if ($user->training->isNotEmpty())
                                    @foreach ($user->training as $training)
                                        <input type="hidden" name="id_training[]" value="{{ $training->id }}">
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" id="name_course" name="name_course[]" value="{{ old('name_course', ($training->name_course ?? '')) }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="sertification" name="sertification[]" placeholder="ada / tidak" value="{{ old('sertification', ($training->sertification === null ? "" : ($training->sertification ? 'ada' : 'tidak'))) }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="last_year_course" name="last_year_course[]" value="{{ old('last_year_course', ($training->last_year ?? '')) }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="name_course" name="name_course[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="sertification" name="sertification[]" placeholder="ada / tidak">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="last_year_course" name="last_year_course[]">
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="skill" class="form-label">Riwayat Pekerjaan</label>
                            <span class="text-lg text-danger">*</span>
                        </div>
                    </div>
                    <div class="col-md" style="text-align: end">
                        <div class="btn btn-success" id="btn-work"><i class="bi bi-plus-lg"></i></div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped mb-3">
                            <thead>
                                <tr>
                                    <th>Nama Perusahaan</th>
                                    <th>Posisi Terakhir</th>
                                    <th>Pendapatan Terakhir</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody id="clone-work">
                                @if ($user->work->isNotEmpty())
                                    @foreach ($user->work as $work)
                                        <input type="hidden" name="id_work[]" value="{{ $work->id }}">
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" id="company_name" name="company_name[]" value="{{ old('company_name', ($work->company_name ?? '')) }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="last_position" name="last_position[]" value="{{ old('last_position', ($work->last_position ?? '')) }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="last_income" name="last_income[]" data-type='currency' value="{{ old('currency', (formatRupiah($work->last_income) ?? '')) }}">
                                            </td>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="last_year_work" name="last_year_work[]" value="{{ old('last_year_work', ($work->last_year ?? '')) }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="company_name" name="company_name[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="last_position" name="last_position[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="last_income" name="last_income[]" data-type='currency'>
                                        </td>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="last_year_work" name="last_year_work[]">
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" value="yes" id="assignments" name="assignments" {{ $user->biodata ? ($user->biodata->assignments ? 'checked' : '') : '' }}>
                            <label class="form-check-label" for="assignments">
                                Bersedia Di Tempatkan Di Seluruh Kantor Perusahaan
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4" style="text-align: end">
                        <button type="submit" class="btn btn-primary">{{ $title }}</button>
                    </div>
                </div>
            </form>
        </div>

    @push('script')
        <script src="{{ asset('assets/js/script.js') }}"></script>
    @endpush
</x-app-layout>
