$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
        },
    });
    function formatNumber(n) {
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatCurrency(input, blur) {
        var input_val = input.val();
        if (input_val === "") {
            return;
        }
        var original_len = input_val.length;
        var caret_pos = input.prop("selectionStart");
        if (input_val.indexOf(".") >= 0) {
            var decimal_pos = input_val.indexOf(".");
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            left_side = formatNumber(left_side);
            right_side = formatNumber(right_side);
            right_side = right_side.substring(0, 2);
            input_val = left_side + "." + right_side;
        } else {
            input_val = formatNumber(input_val);
            input_val = input_val;
        }
        input.val(input_val);
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    // Bind event handler menggunakan event delegation untuk input currency
    $(document).on('keyup', "input[data-type='currency']", function() {
        formatCurrency($(this));
    });

    $(document).on('blur', "input[data-type='currency']", function() {
        formatCurrency($(this), "blur");
    });

    // Handler untuk menambahkan baris pada tabel training
    $('#btn-training').on('click', function() {
        $('#clone-training').append(`<tr>
            <td>
                <input type="text" class="form-control" id="name_course" name="name_course[]">
            </td>
            <td>
                <input type="text" class="form-control" id="sertification" name="sertification[]" placeholder="ada / tidak">
            </td>
            <td>
                <input type="text" class="form-control" id="last_year_course" name="last_year_course[]">
            </td>
        </tr>`);
    });

    // Handler untuk menambahkan baris pada tabel education
    $('#btn-education').on('click', function() {
        $('#clone-education').append(`<tr>
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
        </tr>`);
    });

    // Handler untuk menambahkan baris pada tabel work
    $('#btn-work').on('click', function() {
        $('#clone-work').append(`<tr>
            <td>
                <input type="text" class="form-control" id="company_name" name="company_name[]">
            </td>
            <td>
                <input type="text" class="form-control" id="last_position" name="last_position[]">
            </td>
            <td>
                <input type="text" class="form-control" id="last_income" name="last_income[]" data-type='currency'>
            </td>
            <td>
                <input type="text" class="form-control" id="last_year_work" name="last_year_work[]">
            </td>
        </tr>`);

        // Mengikat ulang event handler untuk input currency yang baru ditambahkan
        $("input[data-type='currency']").off('keyup').off('blur')
            .on('keyup', function() {
                formatCurrency($(this));
            })
            .on('blur', function() {
                formatCurrency($(this), "blur");
            });
    });

    const table = $("#dataTable").DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 500, -1],
            [10, 25, 50, 100, 500, "All"],
        ],
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        order: [],
        pagingType: "full_numbers",
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari...",
        },
        oLanguage: {
            sSearch: "",
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: `${prefixUrl}/user/datatable`,
            method: "POST",
            data: function(d) {
                filterSearch  = d.search?.value;
                d.name        = $('#name').val();
                d.position    = $('#position').val();
                d.education   = $('#filter_education').val();
            }

        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'position', name: 'position' },
            { data: 'ttl', name: 'ttl' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
    });

    $('#filter_education').on('change', function() {
        table.draw();
    });

    $('#btn-reset').on('click',function(){
        $('#filter_education').val('')
        table.draw();
    })

    table.on('click','.btn-delete',function(){
        let id = $(this).data('id');
        Swal.fire({
            title: "Apakah yakin?",
            text: `Data User akan dihapus`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#6492b8da",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yakin",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${prefixUrl}/user/${id}`,
                    method: "post",
                    data: [{ name: "_method", value: "DELETE" }],
                    success: function (res) {
                        table.draw();
                        Swal.fire(`Berhasil dihapus`, res.message, "success");
                    },
                    error: function (res) {
                        console.log(res);
                        Swal.fire(`Gagal`, `${res.responseJSON.message}`, "error");
                    },
                });
            }
        });
    })
});
