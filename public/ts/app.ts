/// <reference types="jquery" />

$((): void => {

    const today: Date = new Date();
    let currentDate: Date = new Date(today.getFullYear(), today.getMonth(), 1);

    updateTopbarDate();
    updateCalendarReferenceDate();
    enableDevOptions(APP_DEBUG);

    $("#calendarModal").on("shown.bs.modal", (): void => {
        renderCalendar(currentDate);
    });

    $("#prevMonthBtn").on("click", (): void => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    $("#nextMonthBtn").on("click", (): void => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    $(document).on("click", ".btn_logout", (): void => {

        Swal.fire({
            title: "Logout?",
            text: "Are you sure you want to logout?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#1f4e79",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, logout",
            cancelButtonText: "Cancel"
        }).then((result: any) => {

            if (result.isConfirmed) {

                showLoading();

                setTimeout((): void => {

                    $.ajax({
                        url: "logout",
                        type: "POST",
                        dataType: "json",
                        processData: false,
                        contentType: false,

                        success: (response: { success: boolean }): void => {

                            if (response.success) {
                                location.reload();
                            } else {
                                hideLoading();
                            }

                        },

                        error: (_xhr: JQuery.jqXHR, _status: string, error: string): void => {

                            console.error(error);
                            hideLoading();

                        }

                    });

                }, 250);
            }
        });
    });

    $(document).on("click", ".loadable", function (this: HTMLAnchorElement, e: JQuery.ClickEvent): void {

        e.preventDefault();

        const url: string | undefined = $(this).attr("href");

        showLoading();

        setTimeout((): void => {

            if (url) {
                window.location.href = url;
            }

        }, 250);

    });

    $(document).on("click", ".toggle-password", function (this: HTMLElement): void {

        const target = $(this).data("target") as string;
        const input = $(target);
        const icon = $(this).find("i");

        if (input.attr("type") === "password") {

            input.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");

        } else {

            input.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");

        }

    });

    $("#accountSettingsForm").on("submit", (): void => {

        console.log("test");

    });

});


function enableDevOptions(enable: boolean): void {

    if (!enable) {

        $(document).on("contextmenu", (e: JQuery.ContextMenuEvent): void => {

            e.preventDefault();

        });

        $(document).on("keydown", (e: JQuery.KeyDownEvent): boolean | void => {

            if (e.keyCode === 123) return false; // F12

            if (e.ctrlKey && e.shiftKey && e.keyCode === 73) return false; // Ctrl+Shift+I
            if (e.ctrlKey && e.shiftKey && e.keyCode === 74) return false; // Ctrl+Shift+J
            if (e.ctrlKey && e.shiftKey && e.keyCode === 67) return false; // Ctrl+Shift+C

            if (e.ctrlKey && e.keyCode === 85) return false; // Ctrl+U
            if (e.ctrlKey && e.keyCode === 83) return false; // Ctrl+S

        });

    }

}


function updateTopbarDate(): void {

    const today: Date = new Date();

    $("#todayText").text(

        today.toLocaleDateString("en-PH", {
            weekday: "short",
            year: "numeric",
            month: "short",
            day: "numeric"
        })

    );

}


function updateCalendarReferenceDate(): void {

    const today: Date = new Date();

    $("#calendarTodayText").text(

        today.toLocaleDateString("en-PH", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric"
        })

    );

}


function isSameDay(a: Date, b: Date): boolean {

    return (
        a.getFullYear() === b.getFullYear() &&
        a.getMonth() === b.getMonth() &&
        a.getDate() === b.getDate()
    );

}


function renderCalendar(dateObj: Date): void {

    const today: Date = new Date();

    const year: number = dateObj.getFullYear();
    const month: number = dateObj.getMonth();

    $("#calendarTitle").text(

        new Date(year, month, 1).toLocaleDateString("en-PH", {
            month: "long",
            year: "numeric"
        })

    );

    const firstDayOfMonth: Date = new Date(year, month, 1);
    const startWeekday: number = firstDayOfMonth.getDay();
    const daysInMonth: number = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth: number = new Date(year, month, 0).getDate();

    const totalCells: number = 42;

    let html: string = "";

    for (let i = 0; i < totalCells; i++) {

        let dayNumber: number;
        let cellMonth: number = month;
        let cellYear: number = year;
        let classes: string = "calendar-day";

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

        const thisDate: Date = new Date(cellYear, cellMonth, dayNumber);

        const isTodayCell: boolean = isSameDay(thisDate, today);

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


function showLoading(): void {

    $("#loadingOverlay").removeClass("d-none");

}


function hideLoading(): void {

    $("#loadingOverlay").addClass("d-none");

}