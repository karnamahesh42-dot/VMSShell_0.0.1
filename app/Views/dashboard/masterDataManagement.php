<?= $this->include('/dashboard/layouts/sidebar') ?>
<?= $this->include('/dashboard/layouts/navbar') ?>
<?php
function statusBadge($status) {
    return $status == 1
        ? '<span class="badge bg-success">Active</span>'
        : '<span class="badge bg-secondary">Inactive</span>';
}
?>

<main class="main-content" id="mainContent">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
           
        <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header py-2 d-flex justify-content-between">
                        <h5 class="m-0">Company Master</h5>
                        <button class="btn btn-sm btn-warning" onclick="openAddModal('company')">
                            <i class="bi bi-plus"></i> Add
                        </button>
                    </div>

                    <div class="card-body" style="max-height:300px;overflow:auto">
                        <table class="table table-sm">
                            <?php $i= 1; foreach ($companies as $c): ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= esc($c['company_name']) ?></td>
                                    <td><?= statusBadge($c['is_active']) ?></td>
                                    <!-- <td>
                                        <button class="btn btn-sm btn-outline-warning"
                                            onclick="toggleStatus('company', <?= $c['id'] ?>)">
                                            Toggle
                                        </button>
                                    </td> -->
                                </tr>
                            <?php  $i++; endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header py-2 d-flex justify-content-between">
                        <h5 class="m-0">Department Master</h5>
                        <button class="btn btn-sm btn-warning" onclick="openAddModal('department')">
                            <i class="bi bi-plus"></i> Add
                        </button>
                    </div>

                    <div class="card-body" style="max-height:300px;overflow:auto">
                        <table class="table table-sm">
                            <?php $i=1; foreach ($departments as $d): ?>
                                <tr>   
                                    <td><?= $i; ?></td>
                                    <td><?= esc($d['department_name']) ?></td>
                                    <td><?= statusBadge($d['status']) ?></td>
                                    <!-- <td>
                                        <button class="btn btn-sm btn-outline-warning"
                                            onclick="toggleStatus('department', <?= $d['id'] ?>)">
                                            Toggle
                                        </button>
                                    </td> -->
                                </tr>
                            <?php $i++; endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>

            
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header py-2 d-flex justify-content-between">
                        <h5 class="m-0">Purpose Master</h5>
                        <button class="btn btn-sm btn-warning" onclick="openAddModal('purpose')">
                            <i class="bi bi-plus"></i> Add
                        </button>
                    </div>

                    <div class="card-body" style="max-height:300px;overflow:auto">
                        <table class="table table-sm">
                            <?php $i=1; foreach ($purposes as $p): ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= esc($p['purpose_name']) ?></td>
                                    <td><?= statusBadge($p['status']) ?></td>
                                    <!-- <td>
                                        <button class="btn btn-sm btn-outline-warning"
                                            onclick="toggleStatus('purpose', <?= $p['id'] ?>)">
                                            Toggle
                                        </button>
                                    </td> -->
                                </tr>
                            <?php $i++; endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>

         <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header py-2 d-flex justify-content-between">
                    <h5 class="m-0">Category Master</h5>
                    <button class="btn btn-sm btn-warning" onclick="categoryModel('category')">
                        <i class="bi bi-plus"></i> Add
                    </button>
                </div>

                <div class="card-body" style="max-height:300px;overflow:auto">
                    <table class="table table-sm">
                        <?php $i=1; foreach ($categories as $p): ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= esc($p['purpose']) ?></td>
                                <td><?= esc($p['category_name']) ?></td>
                                <td><?= statusBadge($p['status']) ?></td>
                                <!-- <td>
                                    <button class="btn btn-sm btn-outline-warning"
                                        onclick="toggleStatus('purpose', <?= $p['id'] ?>)">
                                        Toggle
                                    </button>
                                </td> -->
                            </tr>
                        <?php $i++; endforeach; ?>
                    </table>
                </div>
            </div>
        </div>



        </div>
    </div>
</main>

<?= $this->include('/dashboard/layouts/footer') ?>


<!-- =============== VALIDATION + AJAX SUBMIT JS =============== -->

<script>

    function openAddModal(type) {
        Swal.fire({
            title: 'Add ' + type,
            input: 'text',
            inputPlaceholder: 'Enter ' + type + ' name',
            showCancelButton: true,
            confirmButtonText: 'Save'
        }).then((result) => {
            if (result.isConfirmed && result.value) {

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "<?= base_url('master/save') ?>";

                form.innerHTML = `
                    <input type="hidden" name="type" value="${type}">
                    <input type="hidden" name="name" value="${result.value}">
                    <?= csrf_field() ?>
                `;

                document.body.appendChild(form);
                form.submit();
            }
        });
    }


function categoryModel(type) {

    Swal.fire({
        title: 'Add Category',
        html: `
            <select id="swalPurpose" class="swal2-input">
                <option value="">-- Select Purpose --</option>
                <option value="Vendor">Vendor</option>
                <option value="Recce">Recce</option>
            </select>

            <input id="swalCategory" class="swal2-input" 
                   placeholder="Enter Category Name">
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Save',
        preConfirm: () => {

            const purpose = document.getElementById('swalPurpose').value;
            const category = document.getElementById('swalCategory').value;

            if (!purpose || !category) {
                Swal.showValidationMessage('Please select Purpose and enter Category');
                return false;
            }

            return { purpose, category };
        }
    }).then((result) => {

        if (result.isConfirmed) {

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "<?= base_url('master/save') ?>";

            form.innerHTML = `
                 <input type="hidden" name="type" value="${type}">
                <input type="hidden" name="purpose_name" value="${result.value.purpose}">
                <input type="hidden" name="name" value="${result.value.category}">
                <?= csrf_field() ?>
            `;

            document.body.appendChild(form);
            form.submit();
        }
    });
}



    //     function categoryModel(type) {
    //     Swal.fire({
    //         title: 'Add ' + type,
    //         input: 'text',
    //         inputPlaceholder: 'Enter ' + type + ' name',
    //         showCancelButton: true,
    //         confirmButtonText: 'Save'
    //     }).then((result) => {
    //         if (result.isConfirmed && result.value) {

    //             const form = document.createElement('form');
    //             form.method = 'POST';
    //             form.action = "<?= base_url('master/save') ?>";

    //             form.innerHTML = `
    //                 <input type="hidden" name="type" value="${type}">
    //                  <input type="hidden" name="name" value="${result.value}">
    //                 <input type="hidden" name="name" value="${result.value}">
    //                 <?= csrf_field() ?>
    //             `;

    //             document.body.appendChild(form);
    //             form.submit();
    //         }
    //     });
    // }

    
function toggleStatus(type, id) {
    Swal.fire({
        title: 'Change Status?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes'
    }).then((res) => {
        if (res.isConfirmed) {
            window.location.href = `<?= base_url('master/toggle') ?>/${type}/${id}`;
        }
    });
}

</script>
