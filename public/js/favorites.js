/**
 * Favorites.js - Handles favorite toggling functionality for Jamu products
 * Fixed logic and improved error handling
 */

document.addEventListener("DOMContentLoaded", function () {
    // Initialize favorites functionality
    initializeFavorites();

    // CSS Animations for better UX
    addCustomStyles();
});

function initializeFavorites() {
    // Handle favorite toggle buttons
    handleFavoriteToggle();

    // Handle favorite delete buttons (for favorites page)
    handleFavoriteDelete();
}

function handleFavoriteToggle() {
    const favoriteButtons = document.querySelectorAll(".favorite-toggle-btn");

    favoriteButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            toggleFavorite(this);
        });
    });
}

function handleFavoriteDelete() {
    const deleteForms = document.querySelectorAll(".delete-favorite-form");

    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            confirmAndDeleteFavorite(this);
        });
    });
}

async function toggleFavorite(button) {
    const jamuId = button.dataset.jamuId;

    if (!jamuId) {
        showToast("error", "ID Jamu tidak ditemukan");
        return;
    }

    // Disable button and show loading
    const originalContent = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    try {
        const response = await fetch("/favorites/toggle", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCSRFToken(),
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: JSON.stringify({
                jamu_id: jamuId,
            }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            updateButtonState(button, data.action);
            updateFavoritesCount(data.action === "added" ? 1 : -1);

            // Handle removal from favorites page
            if (data.action === "removed" && isOnFavoritesPage()) {
                removeCardFromFavoritesPage(button);
                return;
            }

            showToast("success", data.message);
        } else {
            throw new Error(data.message || "Operasi gagal");
        }
    } catch (error) {
        console.error("Error toggling favorite:", error);
        button.innerHTML = originalContent;
        handleToggleError(error);
    } finally {
        button.disabled = false;
    }
}

function updateButtonState(button, action) {
    if (action === "added") {
        // Added to favorites
        button.classList.remove("btn-outline-danger", "btn-outline-success");
        button.classList.add("btn-danger");
        button.innerHTML = '<i class="fas fa-heart"></i>';
        button.title = "Hapus dari favorit";

        // Add bounce animation
        button.style.animation = "heartBeat 0.6s ease-in-out";
    } else if (action === "removed") {
        // Removed from favorites
        button.classList.remove("btn-danger", "btn-success");
        button.classList.add("btn-outline-danger");
        button.innerHTML = '<i class="far fa-heart"></i>';
        button.title = "Tambahkan ke favorit";

        // Add pulse animation
        button.style.animation = "pulse 0.5s ease-in-out";
    }

    // Remove animation after completion
    setTimeout(() => {
        button.style.animation = "";
    }, 600);
}

function confirmAndDeleteFavorite(form) {
    const confirmMessage =
        "Apakah Anda yakin ingin menghapus jamu ini dari favorit?";

    if (typeof Swal !== "undefined") {
        Swal.fire({
            title: "Hapus dari favorit?",
            text: "Jamu ini akan dihapus dari daftar favorit Anda",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                deleteFavorite(form);
            }
        });
    } else if (confirm(confirmMessage)) {
        deleteFavorite(form);
    }
}

async function deleteFavorite(form) {
    const jamuId = form.dataset.jamuId;

    if (!jamuId) {
        showToast("error", "ID Jamu tidak ditemukan");
        return;
    }

    try {
        const response = await fetch(form.action, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": getCSRFToken(),
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: JSON.stringify({
                jamu_id: jamuId,
            }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            removeCardFromFavoritesPage(form);
            showToast("success", data.message);
        } else {
            throw new Error(data.message || "Gagal menghapus favorit");
        }
    } catch (error) {
        console.error("Error deleting favorite:", error);
        handleDeleteError(error);
    }
}

function removeCardFromFavoritesPage(element) {
    const card = element.closest(".jamu-card");
    const cardContainer = card ? card.closest(".col-lg-4, .col-md-6") : null;

    if (cardContainer) {
        // Add fade out animation
        cardContainer.style.transition = "all 0.3s ease-out";
        cardContainer.style.transform = "scale(0.95)";
        cardContainer.style.opacity = "0";

        setTimeout(() => {
            cardContainer.remove();
            checkEmptyFavorites();
        }, 300);
    }
}

function checkEmptyFavorites() {
    const remainingCards = document.querySelectorAll(".jamu-card");

    if (remainingCards.length === 0) {
        // Show empty state instead of reloading
        showEmptyState();
    } else {
        // Update count badge
        updateFavoritesCountBadge(remainingCards.length);
    }
}

function showEmptyState() {
    const container = document.querySelector(".container .row");
    const emptyStateHTML = `
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <div class="empty-state py-5">
                        <div class="mb-4">
                            <i class="fas fa-heart fa-4x text-muted opacity-50"></i>
                        </div>
                        <h3 class="text-muted mb-3">Belum ada jamu favorit</h3>
                        <p class="text-muted mb-4">Mulai jelajahi koleksi jamu kami dan simpan yang Anda sukai!</p>
                        <a href="/jamu" class="btn btn-success btn-lg px-4">
                            <i class="fas fa-leaf me-2"></i>Jelajahi Jamu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `;

    if (container) {
        container.innerHTML = emptyStateHTML;

        // Hide the count badge
        const badge = document.querySelector(".badge.bg-success");
        if (badge) {
            badge.style.display = "none";
        }
    }
}

function updateFavoritesCount(change) {
    // Update navigation counter if exists
    const navCounter = document.querySelector(".favorites-count");
    if (navCounter) {
        const currentCount = parseInt(navCounter.textContent) || 0;
        const newCount = Math.max(0, currentCount + change);
        navCounter.textContent = newCount;

        if (newCount === 0) {
            navCounter.style.display = "none";
        } else {
            navCounter.style.display = "inline";
        }
    }
}

function updateFavoritesCountBadge(count) {
    const badge = document.querySelector(".badge.bg-success");
    if (badge) {
        badge.textContent = `${count} Item${count !== 1 ? "s" : ""}`;
    }
}

function isOnFavoritesPage() {
    return window.location.pathname.includes("/favorites");
}

function getCSRFToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    if (!token) {
        console.error("CSRF token not found");
        return "";
    }
    return token.getAttribute("content");
}

function handleToggleError(error) {
    let message = "Terjadi kesalahan saat memproses favorit";

    if (error.name === "TypeError" || error.message.includes("fetch")) {
        message = "Terjadi kesalahan koneksi. Periksa jaringan Anda.";
    } else if (error.message.includes("401")) {
        message = "Silakan login terlebih dahulu.";
    } else if (error.message.includes("403")) {
        message = "Anda tidak memiliki izin untuk melakukan tindakan ini.";
    } else if (error.message.includes("429")) {
        message = "Terlalu banyak permintaan. Coba lagi nanti.";
    } else if (error.message.includes("500")) {
        message = "Terjadi kesalahan server. Coba lagi nanti.";
    }

    showToast("error", message);
}

function handleDeleteError(error) {
    let message = "Terjadi kesalahan saat menghapus favorit";

    if (error.name === "TypeError" || error.message.includes("fetch")) {
        message = "Terjadi kesalahan koneksi. Periksa jaringan Anda.";
    } else if (error.message.includes("403")) {
        message = "Anda tidak memiliki izin untuk menghapus favorit ini.";
    } else if (error.message.includes("404")) {
        message = "Favorit tidak ditemukan.";
    }

    showToast("error", message);
}

function showToast(type, message) {
    if (typeof Swal !== "undefined") {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });

        Toast.fire({
            icon: type === "success" ? "success" : "error",
            title: message,
        });
    } else {
        // Fallback: Create custom toast
        createCustomToast(type, message);
    }
}

function createCustomToast(type, message) {
    const toast = document.createElement("div");
    toast.className = `alert alert-${
        type === "success" ? "success" : "danger"
    } toast-custom`;
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${
                type === "success" ? "check-circle" : "exclamation-circle"
            } me-2"></i>
            <span>${message}</span>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;

    // Add to page
    document.body.appendChild(toast);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 3000);
}

function addCustomStyles() {
    if (document.getElementById("favorites-custom-styles")) return;

    const styles = document.createElement("style");
    styles.id = "favorites-custom-styles";
    styles.textContent = `
        @keyframes heartBeat {
            0% { transform: scale(1); }
            14% { transform: scale(1.3); }
            28% { transform: scale(1); }
            42% { transform: scale(1.3); }
            70% { transform: scale(1); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .toast-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            animation: slideInRight 0.3s ease-out;
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .fade-out {
            animation: fadeOut 0.3s ease-out forwards;
        }
        
        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.95); }
        }
        
        .favorite-toggle-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    `;

    document.head.appendChild(styles);
}
