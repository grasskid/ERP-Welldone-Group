<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Stok Opname</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Stok</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Stok Opname</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <div class="d-flex gap-2 mb-3 px-4">
            <button class="btn btn-primary" onclick="loadTable('tabledaraft')">Draft</button>
            <button class="btn btn-success" onclick="loadTable('tablefix')">Fixed</button>
        </div>

    </div>

    <div style="width: 300px; padding-left: 30px; margin-bottom: 10px;">
        <label for="filterUnit" class="form-label fw-bold">Filter Nama Unit:</label>
        <select id="filterUnit" class="form-select" onchange="filterByUnit()">
            <option value="">Semua Unit</option>
            <!-- Option lainnya akan diisi lewat JavaScript -->
        </select>
    </div>

    <div class="table-responsive mb-4 px-4">
        <div id="table-container" class="px-4">
            <!-- Table will be loaded here -->
        </div>
    </div>
</div>

<script>
    let tableElement;

    function loadTable(table) {
        fetch(`<?= base_url('stokopname/loadtable?table=') ?>${table}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('table-container').innerHTML = html;

                tableElement = $('#zero_config').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    responsive: true,
                    pageLength: 10,
                    initComplete: function() {
                        const unitColumn = this.api().column(2);
                        const unitSet = new Set();

                        unitColumn.data().each(function(d) {
                            unitSet.add(d.trim());
                        });

                        const select = document.getElementById('filterUnit');
                        select.innerHTML = `<option value="">Semua Unit</option>`;
                        unitSet.forEach(unit => {
                            const option = document.createElement('option');
                            option.value = unit;
                            option.textContent = unit;
                            select.appendChild(option);
                        });
                    }
                });


                document.querySelectorAll('.currency').forEach(function(el) {
                    new Cleave(el, {
                        numeral: true,
                        numeralThousandsGroupStyle: 'thousand'
                    });
                });
            })
            .catch(error => console.error('Error loading table:', error));
    }


    function filterByUnit() {
        const selectedUnit = document.getElementById('filterUnit').value;
        if (tableElement) {
            tableElement.column(2).search(selectedUnit).draw();
        }
    }

    window.addEventListener('DOMContentLoaded', () => loadTable('tabledaraft'));
</script>