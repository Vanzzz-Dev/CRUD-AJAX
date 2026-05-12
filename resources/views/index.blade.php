<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Product</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7fc;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input:focus,
        textarea:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 5px rgba(79, 70, 229, .3);
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            transition: .3s;
        }

        #saveBtn {
            background: #4f46e5;
        }

        #saveBtn:hover {
            background: #3730a3;
        }

        .edit-btn {
            background: #f59e0b;
        }

        .edit-btn:hover {
            background: #d97706;
        }

        .delete-btn {
            background: #ef4444;
        }

        .delete-btn:hover {
            background: #dc2626;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        th {
            background: #4f46e5;
            color: white;
            padding: 15px;
        }

        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        tr:hover {
            background: #f9fafb;
        }

        .action-btn {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

       
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>CRUD</h1>
        <div class="card">
            <form id="productForm">
                @csrf
                <input type="hidden" id="product_id">

                <input type="text" id="name" placeholder="Nama Produk" required>

                <textarea id="details" placeholder="Detail Produk"></textarea>

                <button type="submit" id="saveBtn">Simpan</button>
            </form>
        </div>

        <table id="productTable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Detail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr id="row_{{ $product->id }}">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->details }}</td>
                        <td>
                            <div class="action-btn">
                                <button class="edit-btn" onclick="editProduct({{ $product->id }})">
                                    Edit
                                </button>

                                <button class="delete-btn" onclick="deleteProduct({{ $product->id }})">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $('#productForm').on('submit', function (e) {
            e.preventDefault();

            let id = $('#product_id').val();
            let url = id ? `/products/${id}` : '/products';
            let type = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: type,
                data: {
                    name: $('#name').val(),
                    details: $('#details').val(),
                    _token: $('input[name=_token]').val()
                },
                success: function () {
                    location.reload();
                }
            });
        });

        function editProduct(id) {
            $.get(`/products/${id}/edit`, function (data) {
                $('#product_id').val(data.id);
                $('#name').val(data.name);
                $('#details').val(data.details);
                $('#saveBtn').text('Update');
            });
        }

        function deleteProduct(id) {
            if (confirm("Yakin hapus?")) {
                $.ajax({
                    url: `/products/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: $('input[name=_token]').val()
                    },
                    success: function () {
                        $(`#row_${id}`).remove();
                    }
                });
            }
        }
    </script>

</body>

</html>