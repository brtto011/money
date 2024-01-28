<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagination Example</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>


<style>
    body {
        font-family: Arial, sans-serif;
    }

    #data-container {
        margin: 20px;
    }

    #data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    #data-table th,
    #data-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #data-table th {
        background-color: #f2f2f2;
    }

    #pagination {
        margin-top: 10px;
    }

    #pagination button {
        padding: 8px;
        margin-right: 5px;
        cursor: pointer;
    }

    #pagination button:disabled {
        cursor: not-allowed;
    }
</style>

<body>

    <div id="data-container">
        <table id="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data Cadastro</th>
                    <th>Email</th>
                    <th>Senha</th>
                    <th>Telefone</th>
                    <th>Saldo</th>
                    <th>Link Afiliado</th>
                    <th>Plano</th>
                    <th>Depositou</th>
                    <th>Bloc</th>
                    <th>Saldo Comissão</th>
                    <th>Percas</th>
                    <th>Ganhos</th>
                    <th>CPA</th>
                    <th>CPA Fake</th>
                    <th>Comissão Fake</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div id="pagination">
        <button id="prev">Previous</button>
        <button id="next">Next</button>
    </div>

    <script>
        $(document).ready(function () {
            var currentPage = 1;

            function loadData(page) {
                $.ajax({
                    url: 'bd.php?page=' + page,
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        displayData(data.data);
                        updatePagination(data.currentPage, data.totalPages);
                    },
                    error: function (error) {
                        console.error('Error loading data:', error);
                    }
                });
            }

            function displayData(data) {
                var tableBody = $('#data-table tbody');
                tableBody.empty();

                for (var i = 0; i < data.length; i++) {
                    var row = '<tr>';
                    row += '<td>' + data[i].id + '</td>';
                    row += '<td>' + data[i].data_cadastro + '</td>';
                    row += '<td>' + data[i].email + '</td>';
                    row += '<td>' + data[i].senha + '</td>';
                    row += '<td>' + data[i].telefone + '</td>';
                    row += '<td>' + data[i].saldo + '</td>';
                    row += '<td>' + data[i].linkafiliado + '</td>';
                    row += '<td>' + data[i].plano + '</td>';
                    row += '<td>' + data[i].depositou + '</td>';
                    row += '<td>' + data[i].bloc + '</td>';
                    row += '<td>' + data[i].saldo_comissao + '</td>';
                    row += '<td>' + data[i].percas + '</td>';
                    row += '<td>' + data[i].ganhos + '</td>';
                    row += '<td>' + data[i].cpa + '</td>';
                    row += '<td>' + data[i].cpafake + '</td>';
                    row += '<td>' + data[i].comissaofake + '</td>';
                    row += '</tr>';
                    tableBody.append(row);
                }
            }

            function updatePagination(currentPage, totalPages) {
                $("#prev").prop('disabled', currentPage === 1);
                $("#next").prop('disabled', currentPage === totalPages);
            }

            loadData(currentPage);

            $("#prev").click(function () {
                if (currentPage > 1) {
                    loadData(currentPage - 1);
                }
            });

            $("#next").click(function () {
                if (currentPage < totalPages) {
                    loadData(currentPage + 1);
                }
            });
        });
    </script>

</body>

</html>