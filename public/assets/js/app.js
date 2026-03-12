"use strict";
/// <reference types="jquery" />
$(() => {
    const today = new Date();
    let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
    updateTopbarDate();
    updateCalendarReferenceDate();
    enableDevOptions(APP_DEBUG);
    // Show flash message if available
    if (typeof flashData !== 'undefined' && flashData) {
        showFlash(flashData.title, flashData.text, flashData.icon);
    }
    // Calendar modal events
    $("#calendarModal").on("shown.bs.modal", () => {
        renderCalendar(currentDate);
    });
    $("#prevMonthBtn").on("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });
    $("#nextMonthBtn").on("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });
    // Logout
    $(document).on("click", ".btn_logout", () => {
        Swal.fire({
            title: "Logout?",
            text: "Are you sure you want to logout?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#1f4e79",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, logout",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                setTimeout(() => {
                    $.ajax({
                        url: "logout",
                        type: "POST",
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        success: (response) => {
                            if (response.success) {
                                location.reload();
                            }
                            else {
                                hideLoading();
                            }
                        },
                        error: (_jqXHR, _textStatus, errorThrown) => {
                            console.error(errorThrown);
                            hideLoading();
                        }
                    });
                }, 250);
            }
        });
    });
    // Loadable links
    $(document).on("click", ".loadable", function (e) {
        e.preventDefault();
        const url = $(this).attr("href");
        showLoading();
        setTimeout(() => {
            if (url) {
                window.location.href = url;
            }
        }, 250);
    });
    $(document).on("click", ".toggle-password", function () {
        const input = $(this).siblings("input"); // find the input next to the button
        const icon = $(this).find("i");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
        }
        else {
            input.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });
    $("#account_settings_current_password, #account_settings_new_password, #account_settings_confirm_password, #account_settings_username").on("input", () => {
        clearValidation();
    });
    $("#accountSettingsForm").on("submit", (e) => {
        const getTrimmedValue = (selector) => { var _a; return ((_a = $(selector).val()) !== null && _a !== void 0 ? _a : "").toString().trim(); };
        const user_id = getTrimmedValue("#account_settings_user_id");
        const full_name = getTrimmedValue("#account_settings_full_name");
        const username = getTrimmedValue("#account_settings_username");
        const current_password = getTrimmedValue("#account_settings_current_password");
        const new_password = getTrimmedValue("#account_settings_new_password");
        const confirm_password = getTrimmedValue("#account_settings_confirm_password");
        clearValidation();
        let valid = true;
        // --- Password mutual requirement ---
        if (current_password && (!new_password || !confirm_password)) {
            valid = false;
            if (!new_password) {
                $("#account_settings_new_password").addClass("border-danger").parent().after(`<div class="text-danger small password-error">New password is required when changing password.</div>`);
            }
            if (!confirm_password) {
                $("#account_settings_confirm_password").addClass("border-danger").parent().after(`<div class="text-danger small password-error">Confirm password is required when changing password.</div>`);
            }
        }
        else if ((new_password || confirm_password) && !current_password) {
            valid = false;
            $("#account_settings_current_password").addClass("border-danger").parent().after(`<div class="text-danger small password-error">Current password is required to change password.</div>`);
        }
        // --- New & Confirm match ---
        if ((new_password && confirm_password) && new_password !== confirm_password) {
            valid = false;
            $("#account_settings_new_password, #account_settings_confirm_password").addClass("border-danger");
            $("#account_settings_new_password").parent().after(`<div class="text-danger small password-error">Passwords do not match.</div>`);
        }
        if (!valid)
            return;
        showLoading();
        // --- Prepare data for AJAX submission ---
        const formData = {
            user_id,
            full_name,
            username,
            current_password,
            new_password,
            confirm_password
        };
        $.ajax({
            url: "update-account",
            method: "POST",
            data: formData,
            dataType: "JSON",
            success: (response) => {
                setTimeout(() => {
                    if (response.success) {
                        location.reload();
                    }
                    else {
                        hideLoading();
                        if (response.errors.username) {
                            $("#account_settings_username").addClass("border-danger").parent().after(`<div class="text-danger small username-error">${response.errors.username}</div>`);
                        }
                        if (response.errors.current_password) {
                            $("#account_settings_current_password").addClass("border-danger").parent().after(`<div class="text-danger small password-error">${response.errors.current_password}</div>`);
                        }
                    }
                }, 250);
            },
            error: (xhr, status, error) => {
                console.error("AJAX Error:", error);
            }
        });
    });
});
function clearValidation() {
    $(".password-error, .username-error").remove();
    $(".gov-input").removeClass("border-danger");
}
function showFlash(title, text, icon = "success") {
    Swal.fire({ title, text, icon });
}
function enableDevOptions(enable) {
    if (!enable) {
        $(document).on("contextmenu", (e) => e.preventDefault());
        $(document).on("keydown", (e) => {
            const key = e.which || e.keyCode;
            if (key === 123)
                return false; // F12
            if (e.ctrlKey && e.shiftKey && [73, 74, 67].includes(key))
                return false;
            if (e.ctrlKey && [85, 83].includes(key))
                return false;
        });
    }
}
function updateTopbarDate() {
    const today = new Date();
    $("#todayText").text(today.toLocaleDateString("en-PH", {
        weekday: "short",
        year: "numeric",
        month: "short",
        day: "numeric"
    }));
}
function updateCalendarReferenceDate() {
    const today = new Date();
    $("#calendarTodayText").text(today.toLocaleDateString("en-PH", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
    }));
}
function isSameDay(a, b) {
    return (a.getFullYear() === b.getFullYear() &&
        a.getMonth() === b.getMonth() &&
        a.getDate() === b.getDate());
}
function renderCalendar(dateObj) {
    const today = new Date();
    const year = dateObj.getFullYear();
    const month = dateObj.getMonth();
    $("#calendarTitle").text(new Date(year, month, 1).toLocaleDateString("en-PH", {
        month: "long",
        year: "numeric"
    }));
    const firstDayOfMonth = new Date(year, month, 1);
    const startWeekday = firstDayOfMonth.getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    const totalCells = 42;
    let html = "";
    for (let i = 0; i < totalCells; i++) {
        let dayNumber;
        let cellMonth = month;
        let cellYear = year;
        let classes = "calendar-day";
        if (i < startWeekday) {
            dayNumber = daysInPrevMonth - startWeekday + i + 1;
            cellMonth = month - 1;
            if (cellMonth < 0) {
                cellMonth = 11;
                cellYear = year - 1;
            }
            classes += " calendar-day--muted";
        }
        else if (i >= startWeekday + daysInMonth) {
            dayNumber = i - (startWeekday + daysInMonth) + 1;
            cellMonth = month + 1;
            if (cellMonth > 11) {
                cellMonth = 0;
                cellYear = year + 1;
            }
            classes += " calendar-day--muted";
        }
        else {
            dayNumber = i - startWeekday + 1;
        }
        const thisDate = new Date(cellYear, cellMonth, dayNumber);
        const isTodayCell = isSameDay(thisDate, today);
        if (isTodayCell) {
            classes += " calendar-day--today";
        }
        html += `
            <div class="${classes}">
                <div class="calendar-day__number">${dayNumber}</div>
                ${isTodayCell
            ? `<div class="calendar-day__badge">Today</div>`
            : ""}
            </div>
        `;
    }
    $("#calendarDays").html(html);
}
function showLoading() {
    $("#loadingOverlay").removeClass("d-none");
}
function hideLoading() {
    $("#loadingOverlay").addClass("d-none");
}
//# sourceMappingURL=app.js.map