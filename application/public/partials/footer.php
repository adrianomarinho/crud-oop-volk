<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#rows').DataTable(
            {
                dom: 'rtip',
                searching: false,
                paging:   true,
                ordering: true,
                info:     true,
                language: {
                    // url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
                    emptyTable: "Nenhum registro encontrado",
                    info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    infoFiltered: "(Filtrados de _MAX_ registros)",
                    infoThousands: ".",
                    loadingRecords: "Carregando...",
                    zeroRecords: "Nenhum registro encontrado",
                    search: "Pesquisar",
                    paginate: {
                        next: "Próximo",
                        previous: "Anterior",
                        first: "Primeiro",
                        last: "Último"
                    },
                    aria: {
                        sortAscending: ": Ordenar colunas de forma ascendente",
                        sortDescending: ": Ordenar colunas de forma descendente"
                    },

                }
            })
    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.1/css/fontawesome.min.css" integrity="sha512-fZR38yq4xO90wo6TP7f0IltoS2HxJD3HmXEEt4cGU3BXPDjGZ6nun24myAgfajbfO1TOigLZT/ylZGRhA8vtZQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</body>
</html>