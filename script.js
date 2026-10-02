const toast = document.getElementById("toast");
const toastMessage = document.getElementById("toast-message");

const deleteModal = document.getElementById("delete-modal");
const deleteModalContent = document.getElementById("delete-modal-content");
const cancelDelete = document.getElementById("cancel-delete");
const confirmDelete = document.getElementById("confirm-delete");

let toastTimeout;
let deleteUrl = null;

function showToast(message) {
    clearTimeout(toastTimeout);

    toastMessage.textContent = message;

    toast.classList.remove("translate-y-4", "opacity-0");
    toast.classList.add("translate-y-0", "opacity-100");

    toastTimeout = setTimeout(() => {
        toast.classList.remove("translate-y-0", "opacity-100");
        toast.classList.add("translate-y-4", "opacity-0");
    }, 2500);
}

function openDeleteModal(url) {
    deleteUrl = url;

    deleteModal.classList.remove("pointer-events-none", "opacity-0");
    deleteModal.classList.add("opacity-100");

    deleteModalContent.classList.remove("translate-y-3", "scale-95");
    deleteModalContent.classList.add("translate-y-0", "scale-100");
}

function closeDeleteModal() {
    deleteModal.classList.remove("opacity-100");
    deleteModal.classList.add("opacity-0");

    deleteModalContent.classList.remove("translate-y-0", "scale-100");
    deleteModalContent.classList.add("translate-y-3", "scale-95");

    setTimeout(() => {
        deleteModal.classList.add("pointer-events-none");
        deleteUrl = null;
    }, 300);
}

function createEditForm(todoItem) {
    const titleElement = todoItem.querySelector(".todo-title");
    const editButton = todoItem.querySelector(".edit-button");
    const deleteButton = todoItem.querySelector(".delete-button");

    const currentTitle = titleElement.textContent.trim();

    const form = document.createElement("form");

    form.action = "edit.php";
    form.method = "POST";
    form.className = "flex w-full items-center gap-3";

    form.innerHTML = `
        <input
            type="hidden"
            name="id"
            value="${todoItem.dataset.id}"
        >

        <input
            type="text"
            name="title"
            value="${currentTitle.replace(/"/g, "&quot;")}"
            required
            autocomplete="off"
            class="min-w-0 flex-1 rounded-xl border border-violet-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none focus:border-violet-400 focus:ring-4 focus:ring-violet-100"
        >

        <button
            type="submit"
            class="rounded-xl bg-violet-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-violet-700"
        >
            ذخیره
        </button>

        <button
            type="button"
            class="cancel-edit rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-200"
        >
            لغو
        </button>
    `;

    titleElement.replaceWith(form);
    editButton.remove();
    deleteButton.remove();

    const input = form.querySelector("input[name='title']");

    input.focus();
    input.select();

    form.querySelector(".cancel-edit").addEventListener("click", () => {
        window.location.reload();
    });
}

document.querySelectorAll(".edit-button").forEach((button) => {
    button.addEventListener("click", () => {
        const todoItem = button.closest(".todo-item");

        createEditForm(todoItem);
    });
});

document.querySelectorAll(".delete-button").forEach((button) => {
    button.addEventListener("click", () => {
        const todoItem = button.closest(".todo-item");

        openDeleteModal(`delete.php?id=${todoItem.dataset.id}`);
    });
});

cancelDelete.addEventListener("click", closeDeleteModal);

confirmDelete.addEventListener("click", () => {
    if (!deleteUrl) {
        return;
    }

    window.location.href = deleteUrl;
});

deleteModal.addEventListener("click", (event) => {
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
});

document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && deleteUrl) {
        closeDeleteModal();
    }
});

const params = new URLSearchParams(window.location.search);
const status = params.get("status");

const messages = {
    added: "وظیفه با موفقیت اضافه شد",
    updated: "تغییرات با موفقیت ذخیره شد",
    deleted: "وظیفه با موفقیت حذف شد"
};

if (status && messages[status]) {
    showToast(messages[status]);

    window.history.replaceState(
        {},
        document.title,
        window.location.pathname
    );
}