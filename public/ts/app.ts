/// <reference types="jquery" />

$((): void => {
    const today: Date = new Date();
    let currentDate: Date = new Date(today.getFullYear(), today.getMonth(), 1);

    updateTopbarDate();
    updateCalendarReferenceDate();
    enableDevOptions(APP_DEBUG);

    if (typeof flashData !== 'undefined' && flashData) {
        showFlash(flashData.title, flashData.text, flashData.icon as "success" | "error" | "warning");
    }

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

                setTimeout(() => {
                    $.ajax({
                        url: "logout",
                        type: "POST",
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        success: (response: { success: boolean }) => {
                            if (response.success) {
                                location.href = "login";
                            } else {
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

    $(document).on("click", ".loadable", function (this: HTMLAnchorElement, e: JQuery.ClickEvent): void {
        e.preventDefault();

        const url = $(this).attr("href");

        showLoading();

        setTimeout(() => {
            if (url) {
                window.location.href = url;
            }
        }, 250);
    });

    $(document).on("click", ".toggle-password", function (): void {
        const input = $(this).siblings("input"); // find the input next to the button
        const icon = $(this).find("i");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            input.attr("type", "password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });

    $(document).on("click", ".btn-user-management", function (): void {
        const title = $(this).data('title');
        const submit_text = $(this).data('submit-text');

        $("#user_management_title").html(title);
        $("#user_account_submit_text").html(submit_text);

        if (title === "ADD USER ACCOUNT") {
            $("#user_account_password_section").removeClass("d-none");
            $("#user_account_account_modal_body").removeClass("pb-0");

            // Use prop instead of attr
            $("#user_account_password").prop("required", true);
            $("#user_account_confirm_password").prop("required", true);
        }
    });

    $("#reset_filter_button").on("click", (): void => {
        showLoading();

        setTimeout(() => {
            location.href = "user-management";
        }, 250);
    });

    $("#account_settings_username").on("input", (): void => {
        clearValidation("#account_settings_username", ".username-error");
    });

    $("#account_settings_current_password, #account_settings_new_password, #account_settings_confirm_password").on("input", (): void => {
        clearValidation("#account_settings_current_password, #account_settings_new_password, #account_settings_confirm_password", ".password-error");
    });

    $("#accountSettingsForm").on("submit", (): void => {
        const getTrimmedValue = (selector: string) => ($(selector).val() ?? "").toString().trim();

        const user_id = getTrimmedValue("#account_settings_user_id");
        const full_name = getTrimmedValue("#account_settings_full_name");
        const username = getTrimmedValue("#account_settings_username");
        const current_password = getTrimmedValue("#account_settings_current_password");
        const new_password = getTrimmedValue("#account_settings_new_password");
        const confirm_password = getTrimmedValue("#account_settings_confirm_password");

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
        } else if ((new_password || confirm_password) && !current_password) {
            valid = false;
            $("#account_settings_current_password").addClass("border-danger").parent().after(`<div class="text-danger small password-error">Current password is required to change password.</div>`);
        }

        // --- New & Confirm match ---
        if ((new_password && confirm_password) && new_password !== confirm_password) {
            valid = false;
            $("#account_settings_new_password, #account_settings_confirm_password").addClass("border-danger");
            $("#account_settings_new_password").parent().after(`<div class="text-danger small password-error">Passwords do not match.</div>`);
        }

        if (!valid) return;

        showLoading();

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
                    } else {
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

    $("#searchForm").on("submit", (): void => {
        const search_input = $("#searchUser").val()?.toString().trim();
        const role = $("#filterRole").val()?.toString().trim();
        const status = $("#filterStatus").val()?.toString().trim();

        // Build URL parameters
        const params = new URLSearchParams();

        if (search_input) params.set("search_input", search_input);
        if (role) params.set("role", role);
        if (status) params.set("status", status);

        // Reset page to 1 on new search
        params.set("page", "1");

        // Reload page with query string
        const baseUrl = window.location.pathname; // keeps /user-management

        showLoading();

        setTimeout(() => {
            window.location.href = `${baseUrl}?${params.toString()}`;
        }, 250);
    });

    $("#user_account_form").on("submit", (): void => {
        const full_name = $("#user_account_full_name").val()?.toString().trim();
        const username = $("#user_account_username").val()?.toString().trim();
        const role = $("#user_account_role").val()?.toString().trim();

        if ($("#user_management_title").text() == "ADD USER ACCOUNT") {
            const is_active = $("#user_account_is_active").val()?.toString().trim();
            const password = $("#user_account_password").val()?.toString().trim();
            const confirm_password = $("#user_account_confirm_password").val()?.toString().trim();

            if (password != confirm_password) {
                $("#user_account_password, #user_account_confirm_password").addClass("border-danger");
                $("#user_account_password").parent().after(`<div class="text-danger small password-error">Passwords do not match.</div>`);
            } else {
                showLoading();

                const formData = { full_name, username, role, is_active, password };

                $.ajax({
                    url: "add-user-account",
                    method: "POST",
                    data: formData,
                    dataType: "JSON",
                    success: (response) => {
                        setTimeout(() => {
                            if (response.success) {
                                location.href = "user-management";
                            } else {
                                hideLoading();

                                $("#user_account_username").addClass("border-danger").parent().after(`<div class="text-danger small username-error">${response.error}</div>`);
                            }
                        }, 250);
                    },
                    error: (xhr, status, error) => {
                        console.error("AJAX Error:", error);

                        console.log(xhr.responseText);
                    }
                });
            }
        } else {
            const user_id = $("#user_account_user_id").val()?.toString().trim();

            showLoading();

            const formData = { user_id, full_name, username, role };

            $.ajax({
                url: "update-user-account",
                method: "POST",
                data: formData,
                dataType: "JSON",
                success: (response) => {
                    setTimeout(() => {
                        if (response.success) {
                            location.reload();
                        } else {
                            hideLoading();

                            $("#user_account_username").addClass("border-danger").parent().after(`<div class="text-danger small username-error">${response.error}</div>`);
                        }
                    }, 250);
                },
                error: (xhr, status, error) => {
                    console.error("AJAX Error:", error);

                    console.log(xhr.responseText);
                }
            });
        }
    });

    $("#user_account_username").on("input", (): void => {
        clearValidation("#user_account_username", ".username-error");
    });

    $("#user_account_password, #user_account_confirm_password").on("input", (): void => {
        clearValidation("#user_account_password, #user_account_confirm_password", ".password-error");
    });

    $("#logsFilterForm").on("submit", (): void => {
        const search = $("#search").val()?.toString().trim();

        // Build URL parameters
        const params = new URLSearchParams();

        if (search) params.set("search", search);

        // Reset page to 1 on new search
        params.set("page", "1");

        // Reload page with query string
        const baseUrl = window.location.pathname; // keeps /dashboard or /logs

        showLoading(); // optional overlay function

        setTimeout(() => {
            window.location.href = `${baseUrl}?${params.toString()}`;
        }, 250);
    });

    $("#reset_logs_filter").on("click", (): void => {
        showLoading();

        setTimeout(() => {
            location.href = "dashboard";
        }, 250);
    });

    $(document).on("click", "#clearLogsBtn", (): void => {
        Swal.fire({
            title: "Clear all logs?",
            text: "This will permanently delete all system logs.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, clear logs",
            cancelButtonText: "Cancel"
        }).then((result: any) => {
            if (result.isConfirmed) {
                showLoading();

                setTimeout(() => {
                    $.ajax({
                        url: "clear-logs",
                        type: "POST",
                        dataType: "json",
                        success: (response: { success: boolean; message: string }) => {
                            if (response.success) {
                                location.href = "dashboard";
                            } else {
                                hideLoading();

                                Swal.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            }

                        },
                        error: (_jqXHR, _textStatus, errorThrown) => {
                            console.error(errorThrown);
                            hideLoading();

                            Swal.fire({
                                title: "Server Error",
                                text: "Unable to clear logs.",
                                icon: "error"
                            });
                        }
                    });
                }, 250);
            }
        });
    });

    $(document).on("click", "#exportLogsBtn", (): void => {
        showLoading();

        setTimeout(() => {
            window.location.href = "export-logs";

            hideLoading();
        }, 250);
    });

    $(document).on("click", ".btn-edit-user", function (): void {
        const user_id = $(this).data('user_id');
        const full_name = $(this).data('full_name');
        const username = $(this).data('username');
        const role = $(this).data('role');
        const is_active = $(this).data('is_active');

        $("#user_account_user_id").val(user_id);
        $("#user_account_full_name").val(full_name);
        $("#user_account_username").val(username);
        $("#user_account_role").val(role);
        $("#user_account_is_active").val(is_active);

        $("#user_account_is_active").prop("disabled", true);
        $("#user_account_password, #user_account_confirm_password").prop("required", false);
        $("#user_account_password_section").addClass("d-none");
        $("#user_account_account_modal_body").addClass("pb-0");
    });

    $(document).on("click", ".disable-user-account", function (): void {
        const user_id = $(this).data('user_id');
        const username = $(this).data('username');

        Swal.fire({
            title: "Disable this account?",
            text: "This action will deactivate the user account. The user will not be able to log in.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, disable",
            cancelButtonText: "Cancel"
        }).then((result: any) => {
            if (result.isConfirmed) {
                showLoading();

                setTimeout(() => {
                    $.ajax({
                        url: "disable-user-account",
                        type: "POST",
                        dataType: "json",
                        data: { user_id, username },
                        success: (response: { success: boolean; message: string }) => {
                            hideLoading();

                            if (response.success) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: (_jqXHR, _textStatus, errorThrown) => {
                            console.error(errorThrown);
                            hideLoading();

                            Swal.fire({
                                title: "Server Error",
                                text: "Unable to disable user account.",
                                icon: "error"
                            });
                        }
                    });
                }, 250);
            }
        });
    });

    $(document).on("click", ".enable-user-account", function (): void {
        const user_id = $(this).data('user_id');
        const username = $(this).data('username');

        Swal.fire({
            title: "Enable this account?",
            text: "This action will reactivate the user account. The user will be able to log in.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745", // Green for enabling
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, enable",
            cancelButtonText: "Cancel"
        }).then((result: any) => {
            if (result.isConfirmed) {
                showLoading();

                setTimeout(() => {
                    $.ajax({
                        url: "enable-user-account",
                        type: "POST",
                        dataType: "json",
                        data: { user_id, username },
                        success: (response: { success: boolean; message: string }) => {
                            hideLoading();

                            if (response.success) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: (_jqXHR, _textStatus, errorThrown) => {
                            console.error(errorThrown);
                            hideLoading();

                            Swal.fire({
                                title: "Server Error",
                                text: "Unable to enable user account.",
                                icon: "error"
                            });
                        }
                    });
                }, 250);
            }
        });
    });

    $(document).on('click', '.btn-security-questions', function () {
        const $btn = $(this);
        const userId: number = Number($btn.data('user_id'));
        const username: string = String($btn.data('username'));
        const questions: Array<{ id: number, question: string, answer?: string }> = $btn.data('security_questions');

        // Set hidden input and modal title
        $('#security_user_id').val(userId);

        const $form = $('#securityQuestionsForm');

        // Reset selects and answers
        $form.find('select').each(function () {
            $(this).find('option[value=""]').remove(); // Remove the first placeholder option
            $(this).val('');
            $(this).find('option').prop('disabled', false);
        });
        $form.find('input[type="text"]').val('');

        // Prefill questions and answers
        questions.forEach((q, index) => {
            const $select = $form.find(`select[name="questions[${index}]"]`);
            $select.val(q.question);
            if (q.answer) {
                $form.find(`input[name="answers[${index}]"]`).val(q.answer);
            }
        });

        // Function to update disabled options dynamically
        const updateDisabledOptions = () => {
            const selectedValues = $form.find('select').map(function () {
                return $(this).val() as string;
            }).get();

            $form.find('select').each(function () {
                const $current = $(this);
                $current.find('option').each(function () {
                    const $opt = $(this);
                    const val = $opt.val() as string;
                    if (!val) return; // Skip empty values
                    // Disable if selected in another select
                    $opt.prop('disabled', selectedValues.includes(val) && $current.val() !== val);
                });
            });
        };

        // Initialize disabled options on load
        updateDisabledOptions();

        // Update on change
        $form.find('select').off('change').on('change', updateDisabledOptions);
    });

    $('#securityQuestionsForm').on('submit', function (e) {
        e.preventDefault();

        const user_id = $('#security_user_id').val()?.toString().trim();
        const questions: string[] = [];
        const answers: (string | null)[] = [];

        $('#securityQuestionsForm select').each(function (i) {
            const question = $(this).val()?.toString().trim();
            const answer = $(`#securityQuestionsForm input[name="answers[${i}]"]`).val()?.toString().trim();

            if (question) {
                questions.push(question);
                // push answer only if not empty, otherwise null to indicate "keep old"
                answers.push(answer ? answer : null);
            }

            // remove error styling
            $(this).removeClass('border-danger');
            $(`#securityQuestionsForm input[name="answers[${i}]"]`).removeClass('border-danger');
        });

        if (!questions.length) {
            // No question selected, do nothing
            return;
        }

        showLoading();

        const formData = { user_id, questions, answers };

        $.ajax({
            url: 'update-security-questions', // your endpoint
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            success: (response) => {
                setTimeout(() => {
                    if (response.success) {
                        location.reload(); // or show a success notification
                    } else {
                        hideLoading();
                        alert(response.error || 'Failed to update security questions.');
                    }
                }, 250);
            },
            error: (xhr, status, error) => {
                hideLoading();
                console.error('AJAX Error:', error);
                console.log(xhr.responseText);
            }
        });
    });
});

function clearValidation(inputSelector: string, errorSelector: string): void {
    $(errorSelector).remove();
    $(inputSelector).removeClass("border-danger");
}

function showFlash(title: string, text: string, icon: "success" | "error" | "warning" = "success"): void {
    Swal.fire({ title, text, icon });
}

function enableDevOptions(enable: boolean): void {
    if (!enable) {
        $(document).on(
            "contextmenu",
            (e: JQuery.ContextMenuEvent): void => e.preventDefault()
        );

        $(document).on(
            "keydown",
            (e: JQuery.KeyDownEvent): boolean | void => {
                const key = e.which || e.keyCode;

                if (key === 123) return false; // F12
                if (e.ctrlKey && e.shiftKey && [73, 74, 67].includes(key)) return false;
                if (e.ctrlKey && [85, 83].includes(key)) return false;
            }
        );
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

    const totalCells = 42;

    let html = "";

    for (let i = 0; i < totalCells; i++) {
        let dayNumber: number;
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
                ${isTodayCell
                ? `<div class="calendar-day__badge">Today</div>`
                : ""
            }
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