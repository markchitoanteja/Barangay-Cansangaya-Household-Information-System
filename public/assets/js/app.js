$(function () {
    const today = new Date();
    let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);

    updateTopbarDate();
    updateCalendarReferenceDate();
    disableDevOptions();

    $("#calendarModal").on("shown.bs.modal", function () {
        renderCalendar(currentDate);
    });

    $("#prevMonthBtn").on("click", function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    $("#nextMonthBtn").on("click", function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    $(document).on("click", ".btn_logout", function () {
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
                        url: 'logout',
                        type: 'POST',
                        dataType: 'JSON',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                hideLoading();
                            }
                        },
                        error: function (_, _, error) {
                            console.error(error);
                            hideLoading();
                        }
                    });
                }, 250);
            }
        });
    });

    $(document).on("click", ".loadable", function (e) {
        e.preventDefault(); // stop immediate redirect

        const url = $(this).attr("href");

        showLoading();

        setTimeout(function () {
            window.location.href = url;
        }, 250);
    });

    $(document).on("click", ".toggle-password", function () {

        const input = $($(this).data("target"));
        const icon = $(this).find("i");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            input.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }

    });

    function disableDevOptions() {
        // Disable right-click
        $(document).on("contextmenu", function (e) {
            e.preventDefault();
        });

        // Disable key combinations used for DevTools
        $(document).keydown(function (e) {

            // F12
            if (e.keyCode == 123) {
                return false;
            }

            // Ctrl+Shift+I
            if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                return false;
            }

            // Ctrl+Shift+J
            if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                return false;
            }

            // Ctrl+Shift+C
            if (e.ctrlKey && e.shiftKey && e.keyCode == 67) {
                return false;
            }

            // Ctrl+U (View Source)
            if (e.ctrlKey && e.keyCode == 85) {
                return false;
            }

            // Ctrl+S
            if (e.ctrlKey && e.keyCode == 83) {
                return false;
            }

        });
    }

    function updateTopbarDate() {
        $("#todayText").text(
            today.toLocaleDateString("en-PH", {
                weekday: "short",
                year: "numeric",
                month: "short",
                day: "numeric"
            })
        );
    }

    function updateCalendarReferenceDate() {
        $("#calendarTodayText").text(
            today.toLocaleDateString("en-PH", {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric"
            })
        );
    }

    function isSameDay(a, b) {
        return a.getFullYear() === b.getFullYear() &&
            a.getMonth() === b.getMonth() &&
            a.getDate() === b.getDate();
    }

    function renderCalendar(dateObj) {
        const year = dateObj.getFullYear();
        const month = dateObj.getMonth();

        $("#calendarTitle").text(
            new Date(year, month, 1).toLocaleDateString("en-PH", {
                month: "long",
                year: "numeric"
            })
        );

        const firstDayOfMonth = new Date(year, month, 1);
        const startWeekday = firstDayOfMonth.getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        let html = "";
        const totalCells = 42; // 6 rows x 7 columns for stable layout

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
            } else if (i >= startWeekday + daysInMonth) {
                dayNumber = i - (startWeekday + daysInMonth) + 1;
                cellMonth = month + 1;
                if (cellMonth > 11) {
                    cellMonth = 0;
                    cellYear = year + 1;
                }
                classes += " calendar-day--muted";
            } else {
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
                    ${isTodayCell ? `<div class="calendar-day__badge">Today</div>` : ``}
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
});