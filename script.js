function openInsertForm() {
    
    const insertForm = document.getElementById('form-insert');
    insertForm.style.display = 'block';
}

function closeInsertForm() {

    const insertForm = document.getElementById('form-insert');
    insertForm.style.display = 'none';
}

function closeForm() {

    location.href = "?";
}

function openViewForm(id) {
    
    location.href = "?view_id=" + id;
}

function openEditForm(id) {
    
    location.href = "?edit_id=" + id;
}

function openDeleteForm(id) {
    
    location.href = "?delete_id=" + id;
}