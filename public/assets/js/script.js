/**
 * File: public/assets/js/script.js
 * Deskripsi:
 *  - Validasi form sebelum submit
 *  - AJAX untuk submit data (store/update/delete)
 *  - Update tabel pendaftar tanpa reload
 *  - Fitur "Hapus Semua Data"
 *  - Simpan cookie, localStorage
 *  - Tambahkan fungsi Edit/Hapus dan Simpan/Cancel
 */

// Event saat halaman load
window.addEventListener("load", () => {
    console.log("Halaman dimuat.");

    // Cek kunjungan pertama (localStorage)
    if (!localStorage.getItem("visited")) {
        localStorage.setItem("visited", "true");
        console.log("Selamat datang, ini kunjungan pertama Anda!");
    }
});

// Ambil elemen form dan container tabel
const registrationForm = document.getElementById("registrationForm");
const tableContainer = document.getElementById("tableContainer");

/* ------------------------------------------
   1) HANDLE SUBMIT FORM (STORE)
   ------------------------------------------ */
if (registrationForm) {
    registrationForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const nameField  = document.getElementById("name");
        const emailField = document.getElementById("email");
        const agreeField = document.getElementById("agree_terms");

        let isValid = true;

        // Bersihkan pesan error sebelumnya
        document.querySelectorAll(".error-message").forEach((msg) => msg.remove());

        // Validasi nama
        if (!nameField.value.trim()) {
            showError(nameField, "Nama wajib diisi!");
            isValid = false;
        }

        // Validasi email
        if (!emailField.value.trim()) {
            showError(emailField, "Email wajib diisi!");
            isValid = false;
        } else if (!isValidEmail(emailField.value)) {
            showError(emailField, "Email tidak valid!");
            isValid = false;
        }

        // Validasi checkbox "agree_terms"
        if (!agreeField.checked) {
            showError(agreeField, "Anda harus menyetujui syarat & ketentuan!");
            isValid = false;
        }

        // Jika valid, kirim data via fetch
        if (isValid) {
            const formData = new FormData(registrationForm);
            fetch("api.php?action=store", {
                method: "POST",
                body: formData,
            })
            .then((resp) => resp.json())
            .then((data) => {
                if (data.status === "success") {
                    showFeedback(data.message, "success");
                    updateRegistrationsTable();
                    registrationForm.reset();
                } else {
                    showFeedback(data.message, "error");
                }
            })
            .catch(() => {
                showFeedback("Terjadi kesalahan server.", "error");
            });
        }
    });

    // Event onblur untuk email -> cek format
    const emailField = document.getElementById("email");
    emailField.addEventListener("blur", () => {
        if (emailField.value && !isValidEmail(emailField.value)) {
            showFeedback("Format email tidak valid!", "error");
        }
    });
}

/* ------------------------------------------
   2) HANDLE CLICK DI TABEL (EDIT/DELETE)
   ------------------------------------------ */
if (tableContainer) {
    tableContainer.addEventListener("click", (e) => {
        const target = e.target;
        const row = target.closest("tr");
        const id = row?.dataset?.id;

        // 1) Tombol Edit
        if (target.classList.contains("btn-edit")) {
            startEditingRow(row, target);
        }

        // 2) Tombol Simpan
        else if (target.classList.contains("btn-save")) {
            saveEditingRow(row, target, id);
        }

        // 3) Tombol Cancel
        else if (target.classList.contains("btn-cancel")) {
            cancelEditingRow(row, target);
        }

        // 4) Tombol Hapus (satu data)
        else if (target.classList.contains("btn-delete")) {
            if (confirm("Yakin ingin menghapus data ini?")) {
                fetch(`api.php?action=delete&id=${id}`, { method: "POST" })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.status === "success") {
                            row.remove();
                            showFeedback(data.message, "success");
                        } else {
                            showFeedback(data.message, "error");
                        }
                    })
                    .catch(() => {
                        showFeedback("Gagal menghapus data (Network error).", "error");
                    });
            }
        }
    });
}

/* ------------------------------------------
   FUNCTION: START EDITING
   ------------------------------------------ */
function startEditingRow(row, buttonEdit) {
    row.querySelectorAll(".editable").forEach((cell, index) => {
        const originalValue = cell.textContent.trim();
        cell.dataset.originalValue = originalValue; // simpan di <td> juga

        // index 3 = kolom Kursus (asumsi: ID, Name, Email, Gender, Kursus => cek urutan di table)
        if (index === 3) {
            let selectedId = 0;
            const valLower = originalValue.toLowerCase();
            if (valLower.includes("web"))    selectedId = 1;
            if (valLower.includes("data"))   selectedId = 2;
            if (valLower.includes("mobile")) selectedId = 3;
            if (valLower.includes("ux"))     selectedId = 4;

            cell.innerHTML = `
                <select data-original-value="${originalValue}">
                    <option value="1" ${selectedId === 1 ? "selected" : ""}>Web Development</option>
                    <option value="2" ${selectedId === 2 ? "selected" : ""}>Data Science</option>
                    <option value="3" ${selectedId === 3 ? "selected" : ""}>Mobile Apps</option>
                    <option value="4" ${selectedId === 4 ? "selected" : ""}>UI/UX Design</option>
                </select>
            `;
        } else {
            // name, email, gender dsb
            cell.innerHTML = `<input type="text" value="${originalValue}" data-original-value="${originalValue}" />`;
        }
    });

    // Tombol Edit -> Simpan
    buttonEdit.textContent = "Simpan";
    buttonEdit.classList.replace("btn-edit", "btn-save");

    // Tombol Hapus -> Cancel
    const deleteButton = row.querySelector(".btn-delete");
    deleteButton.textContent = "Cancel";
    deleteButton.classList.replace("btn-delete", "btn-cancel");
}

/* ------------------------------------------
   FUNCTION: SAVE EDITING
   ------------------------------------------ */
function saveEditingRow(row, buttonSave, id) {
    // Kumpulkan input di kolom .editable
    const inputs = row.querySelectorAll("input, select");

    // Buat payload data
    // Pastikan urutan input sesuai: 
    //   index 0 -> name, 1 -> email, 2 -> gender, 3 -> course
    const updatedData = {
        id:        id,
        name:      inputs[0].value,
        email:     inputs[1].value,
        gender:    inputs[2].value,
        course_id: inputs[3].value
    };

    // Kirim ke server: update
    fetch("api.php?action=update", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(updatedData),
    })
    .then((res) => res.json())
    .then((data) => {
        if (data.status === "success") {
            // Perbarui tampilan
            inputs.forEach((input, index) => {
                const cell = row.children[index + 1];
                cell.textContent = convertDisplayValue(index, input.value);
            });

            // Kembalikan tombol
            buttonSave.textContent = "Edit";
            buttonSave.classList.replace("btn-save", "btn-edit");

            const cancelButton = row.querySelector(".btn-cancel");
            cancelButton.textContent = "Hapus";
            cancelButton.classList.replace("btn-cancel", "btn-delete");

            showFeedback(data.message, "success");
        } else {
            showFeedback(data.message, "error");
        }
    })
    .catch(() => {
        showFeedback("Gagal memperbarui data (Network error).", "error");
    });
}

/* ------------------------------------------
   FUNCTION: CANCEL EDIT
   ------------------------------------------ */
function cancelEditingRow(row, buttonCancel) {
    row.querySelectorAll(".editable").forEach((cell) => {
        const input = cell.querySelector("input, select");
        if (input) {
            const oldVal = input.dataset.originalValue;
            cell.textContent = oldVal;
        }
    });

    buttonCancel.textContent = "Hapus";
    buttonCancel.classList.replace("btn-cancel", "btn-delete");

    const saveButton = row.querySelector(".btn-save");
    saveButton.textContent = "Edit";
    saveButton.classList.replace("btn-save", "btn-edit");
}

/* ------------------------------------------
   3) TOMBOL "HAPUS SEMUA DATA"
   ------------------------------------------ */
const deleteAllBtn = document.getElementById("btnDeleteAll");
if (deleteAllBtn) {
    deleteAllBtn.addEventListener("click", () => {
        if (confirm("Anda yakin ingin menghapus SEMUA data?")) {
            fetch("api.php?action=delete_all", { method: "POST" })
                .then((resp) => resp.json())
                .then((data) => {
                    if (data.status === "success") {
                        showFeedback(data.message, "success");
                        updateRegistrationsTable(); // Refresh tabel
                    } else {
                        showFeedback(data.message, "error");
                    }
                })
                .catch(() => {
                    showFeedback("Gagal menghapus semua data (Network error).", "error");
                });
        }
    });
}

/* ------------------------------------------
   FUNGSI BANTUAN
   ------------------------------------------ */

/**
 * Menampilkan feedback di <div id="feedbackMessage">
 */
function showFeedback(msg, type) {
    const fb = document.getElementById("feedbackMessage");
    if (!fb) return;

    fb.textContent = msg;
    fb.style.color = (type === "error") ? "red" : "green";
}

/**
 * Menampilkan pesan error di elemen input
 */
function showError(element, message) {
    const error = document.createElement("span");
    error.className = "error-message";
    error.style.color = "red";
    error.style.fontSize = "0.85rem";
    error.textContent = message;
    if (element.parentElement) {
        element.parentElement.appendChild(error);
    }
}

/**
 * Validasi email di client side
 */
function isValidEmail(email) {
    const re = /\S+@\S+\.\S+/;
    return re.test(email);
}

/**
 * Convert value untuk tampilan di tabel
 * index 2 -> gender, index 3 -> course
 */
function convertDisplayValue(index, rawValue) {
    if (index === 2) {
        return rawValue === "Male" ? "Laki-laki" : "Perempuan";
    }
    if (index === 3) {
        switch (rawValue) {
            case "1": return "Web Development";
            case "2": return "Data Science";
            case "3": return "Mobile Apps";
            case "4": return "UI/UX Design";
            default:  return rawValue;
        }
    }
    return rawValue;
}

/**
 * Update isi tabel pendaftar (tanpa reload halaman)
 */
function updateRegistrationsTable() {
    fetch("register.php")
        .then((resp) => resp.text())
        .then((html) => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");
            const newTable = doc.querySelector("#tableContainer");
            if (newTable) {
                tableContainer.innerHTML = newTable.innerHTML;
            }
        })
        .catch(() => {
            console.error("Gagal memuat tabel pendaftar.");
        });
}
