$(function () {
    const today = new Date();

    $("#todayText").text(
        today.toLocaleDateString(undefined, {
            weekday: "short",
            year: "numeric",
            month: "short",
            day: "numeric"
        })
    );

    $("#calendarModal").on("shown.bs.modal", function () {
        renderCalendar(new Date()); // current month
    });

    $(document).on("click", ".btn_logout", function () {
        Swal.fire({
            title: "Logout?",
            text: "Are you sure you want to logout?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
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
                            }
                        },
                        error: function (_, _, error) {
                            console.error(error);
                        }
                    });
                }, 1000);
            }
        });
    });

    function isSameDay(a, b) {
        return a.getFullYear() === b.getFullYear() &&
            a.getMonth() === b.getMonth() &&
            a.getDate() === b.getDate();
    }

    function renderCalendar(dateObj) {
        const year = dateObj.getFullYear();
        const month = dateObj.getMonth(); // 0-11

        // Title: "March 2026"
        $("#calendarTitle").text(
            new Date(year, month, 1).toLocaleDateString(undefined, { month: "long", year: "numeric" })
        );

        const firstDayOfMonth = new Date(year, month, 1);
        const lastDayOfMonth = new Date(year, month + 1, 0);

        const startWeekday = firstDayOfMonth.getDay(); // 0=Sun..6=Sat
        const daysInMonth = lastDayOfMonth.getDate();

        // Days from previous month to show (leading cells)
        const prevMonthLastDay = new Date(year, month, 0).getDate();

        let html = "";

        // leading days (muted)
        for (let i = startWeekday - 1; i >= 0; i--) {
            const dayNum = prevMonthLastDay - i;
            html += `<div class="calendar-cell muted">${dayNum}</div>`;
        }

        // current month days
        for (let d = 1; d <= daysInMonth; d++) {
            const thisDate = new Date(year, month, d);
            const todayClass = isSameDay(thisDate, today) ? " today" : "";
            html += `<div class="calendar-cell${todayClass}">${d}</div>`;
        }

        // trailing days (muted) to complete the grid (multiple of 7)
        const totalCellsSoFar = startWeekday + daysInMonth;
        const trailing = (7 - (totalCellsSoFar % 7)) % 7;

        for (let t = 1; t <= trailing; t++) {
            html += `<div class="calendar-cell muted">${t}</div>`;
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