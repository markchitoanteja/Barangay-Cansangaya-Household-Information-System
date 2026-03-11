/// <reference types="jquery" />
import Swal from "sweetalert2";
$(() => {
    const today = new Date();
    let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
    updateTopbarDate();
    updateCalendarReferenceDate();
    enableDevOptions(APP_DEBUG);
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
                            if (response.success)
                                location.reload();
                            else
                                hideLoading();
                        },
                        error: (jqXHR, textStatus, errorThrown) => {
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
            if (url)
                window.location.href = url;
        }, 250);
    });
    // Toggle password visibility
    $(document).on("click", ".toggle-password", function () {
        var _a;
        const target = (_a = $(this).data("target")) !== null && _a !== void 0 ? _a : "";
        const input = $(target);
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
    // Account settings form
    $("#accountSettingsForm").on("submit", () => {
        console.log("Account settings form submitted");
    });
});
function enableDevOptions(enable) {
    if (!enable) {
        $(document).on("contextmenu", (e) => e.preventDefault());
        $(document).on("keydown", (e) => {
            const key = e.which || e.keyCode;
            if (key === 123)
                return false; // F12
            if (e.ctrlKey && e.shiftKey && [73, 74, 67].includes(key))
                return false; // Ctrl+Shift+I/J/C
            if (e.ctrlKey && [85, 83].includes(key))
                return false; // Ctrl+U/S
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
    return a.getFullYear() === b.getFullYear() &&
        a.getMonth() === b.getMonth() &&
        a.getDate() === b.getDate();
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
        if (isTodayCell)
            classes += " calendar-day--today";
        html += `
            <div class="${classes}">
                <div class="calendar-day__number">${dayNumber}</div>
                ${isTodayCell ? `<div class="calendar-day__badge">Today</div>` : ""}
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