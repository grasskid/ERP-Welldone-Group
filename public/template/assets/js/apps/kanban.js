$(function () {
  function kanbanSortable() {
    document.querySelectorAll('[data-sortable="true"]').forEach((el) => {
      new Sortable(el, {
        group: 'kanban-tasks',
        animation: 150,
        ghostClass: 'ui-state-highlight',
        onEnd: function (evt) {
          console.log('Moved item:', evt.item);
        }
      });
    });
  }

  function clearItem() {
    $(".list-clear-all")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();
        $(this)
          .parents('[data-action="sorting"]')
          .find(".connect-sorting-content .card")
          .remove();
      });
  }

  function addKanbanItem() {
  $(".addTask").on("click", function (event) {
    event.preventDefault();
    const getParentElement = $(this).parents('[data-action="sorting"]').attr("data-item");

    $(".edit-task-title").hide();
    $(".add-task-title").show();
    $('[data-btn-action="addTask"]').hide();
    $('[data-btn-action="editTask"]').hide();

    $("#addItemModal .modal-body").html(`
      <form id="kanban-form" enctype="multipart/form-data" method="post">
        <div class="mb-3">
          <label class="form-label">Nama Tugas</label>
          <input type="text" class="form-control" name="nama_tugas" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea class="form-control" name="deskripsi" rows="3"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Upload File</label>
          <input type="file" class="form-control" name="file" accept=".jpg,.jpeg,.png,.pdf" />
        </div>
        <input type="hidden" name="status" value="1" />
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    `);

    $("#addItemModal").modal("show");

    kanban_add();
  });
}

function kanban_add() {
  $(document).off("submit", "#kanban-form").on("submit", "#kanban-form", function (e) {
    e.preventDefault();

    const form = document.getElementById("kanban-form");
    const formData = new FormData(form);

    fetch("/tugas/saveTugas", {
      method: "POST",
      body: formData
    })
      .then(res => res.ok ? location.reload() : alert("Gagal menambahkan tugas."))
      .catch(err => {
        console.error("Upload error:", err);
        alert("Terjadi kesalahan saat mengirim tugas.");
      });
  });
}

  $("#add-list")
    .off("click")
    .on("click", function (event) {
      event.preventDefault();

      $(".add-list").show();
      $(".edit-list").hide();
      $(".edit-list-title").hide();
      $(".add-list-title").show();
      $("#addListModal").modal("show");
    });

  $(".add-list")
    .off("click")
    .on("click", function (event) {
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0");

      today = mm + "." + dd;

      var itemTitle = document.getElementById("item-name").value;
      var itemNameLowercase = itemTitle.toLowerCase();
      var itemNameRemoveWhiteSpace = itemNameLowercase.split(" ").join("_");
      var itemDataAttr = itemNameRemoveWhiteSpace;

      var item_html = `
        <div data-item="item-${itemDataAttr}" class="task-list-container mb-4" data-action="sorting">
          <div class="connect-sorting">
            <div class="task-container-header d-flex justify-content-between">
              <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="${itemTitle}">${itemTitle}</h6>
              <div class="hstack gap-2">
                <div class="dropdown">
                  <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical text-dark"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                    <a class="dropdown-item list-delete" href="javascript:void(0);">Delete</a>
                    <a class="dropdown-item list-clear-all" href="javascript:void(0);">Clear All</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="connect-sorting-content" data-sortable="true"></div>
            <div class="text-center mt-2">
              <button class="btn btn-sm btn-outline-primary addTask">+ Add Task</button>
            </div>
          </div>
        </div>
      `;

      $(".task-list-section").append(item_html);
      $("#addListModal").modal("hide");
      $("#item-name").val("");

      kanbanSortable();
      editItem();
      deleteItem();
      clearItem();
      addKanbanItem();
      kanbanEdit();
      kanbanDelete();

      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });

  function editItem() {
    $(".list-edit")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();

        var parentItem = $(this);

        $(".add-list").hide();
        $(".edit-list").show();
        $(".add-list-title").hide();
        $(".edit-list-title").show();

        var itemTitle = parentItem.parents('[data-action="sorting"]').find(".item-head").attr("data-item-title");
        $("#item-name").val(itemTitle);

        $(".edit-list")
          .off("click")
          .on("click", function () {
            var newTitle = $("#item-name").val();
            parentItem.parents('[data-action="sorting"]').find(".item-head").text(newTitle).attr("data-item-title", newTitle);
            $("#addListModal").modal("hide");
            $("#item-name").val("");
          });

        $("#addListModal").modal("show");
      });
  }

  function deleteItem() {
    $(".list-delete")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();
        $(this).parents("[data-action]").remove();
      });
  }

  function kanbanDelete() {
    $(".card .kanban-item-delete")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();
        var get_card_parent = $(this).parents(".card");
        $("#deleteConformation").modal("show");

        $('[data-remove="task"]').off("click").on("click", function (event) {
          event.preventDefault();
          get_card_parent.remove();
          $("#deleteConformation").modal("hide");
        });
      });
  }

  function kanbanEdit() {
    $(".card .kanban-item-edit")
      .off("click")
      .on("click", function (event) {
        event.preventDefault();
        var parentItem = $(this);

        $(".add-task-title").hide();
        $(".edit-task-title").show();
        $('[data-btn-action="addTask"]').hide();
        $('[data-btn-action="editTask"]').show();

        var itemKanbanTitle = parentItem.parents(".card").find("h4").attr("data-item-title");
        var itemText = parentItem.parents(".card").find("p").attr("data-item-text");

        $("#addItemModal .modal-body").html(`
          <form id="kanban-form">
            <div class="mb-3">
              <label for="kanban-title" class="form-label">Title</label>
              <input type="text" class="form-control" id="kanban-title" value="${itemKanbanTitle}" />
            </div>
            <div class="mb-3">
              <label for="kanban-text" class="form-label">Description</label>
              <textarea class="form-control" id="kanban-text" rows="3">${itemText}</textarea>
            </div>
          </form>
        `);

        $('[data-btn-action="editTask"]')
          .off("click")
          .on("click", function () {
            var newTitle = $("#kanban-title").val();
            var newText = $("#kanban-text").val();
            parentItem.parents(".card").find("h4").text(newTitle).attr("data-item-title", newTitle);
            parentItem.parents(".card").find("p").text(newText).attr("data-item-text", newText);
            $("#addItemModal").modal("hide");
          });

        $("#addItemModal").modal("show");
      });
  }

  $("#addItemModal").on("hidden.bs.modal", function () {
    $("#kanban-form")[0]?.reset();
  });

  editItem();
  deleteItem();
  clearItem();
  addKanbanItem();
  kanbanEdit();
  kanbanDelete();
  kanbanSortable();

  document.querySelectorAll('.connect-sorting-content').forEach(list => {
    new Sortable(list, {
        group: 'kanban',
        animation: 150,
        onAdd: function (evt) {
            const card = evt.item;
            const targetColumn = evt.to.closest('.task-list-container').getAttribute('data-item');
            const dropdown = card.querySelector('.dropdown-toggle');

            if (!dropdown) return;

            const idtugas = dropdown.id.replace('dropdownMenuLink-', '');

            // Remove any previous confirm buttons
            card.querySelectorAll('.confirm-status-btn')?.forEach(el => el.remove());

            const confirmBtn = document.createElement('button');
confirmBtn.innerText = '✔ Confirm';
confirmBtn.className = 'btn btn-sm btn-success mb-2 ms-2 confirm-status-btn';
card.querySelector('.card-body').appendChild(confirmBtn);

            let newStatus = 1;
            if (targetColumn === 'item-inprogress') newStatus = 2;
            else if (targetColumn === 'item-pending') newStatus = 3;
            else if (targetColumn === 'item-done') newStatus = 4;

            confirmBtn.addEventListener('click', function () {
                fetch('/tugas/updateStatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ id: idtugas, status: newStatus })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        confirmBtn.remove();
                    } else {
                        alert('Failed to update status.');
                    }
                })
                .catch(err => {
                    console.error('AJAX error:', err);
                    alert('AJAX request failed.');
                });
            });
        }
    });
});


});
