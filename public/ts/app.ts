/// <reference types="jquery" />

$((): void => {
    const today: Date = new Date();
    let currentDate: Date = new Date(today.getFullYear(), today.getMonth(), 1);

    let originalContent = $('#systemInfoForm .bg-white').html();

    updateTopbarDate();
    updateCalendarReferenceDate();
    enableDevOptions(APP_DEBUG);
    checkUpdates();

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

        const clearInputs = (ids: string[]) => {
            ids.forEach(id => {
                const input = document.getElementById(id) as HTMLInputElement | null;
                if (input) input.value = '';
            });
        };

        clearInputs([
            'user_account_full_name',
            'user_account_username',
            'user_account_password',
            'user_account_confirm_password'
        ]);

        $("#user_management_title").html(title);
        $("#user_account_submit_text").html(submit_text);

        if (title === "ADD USER ACCOUNT") {
            $("#user_account_password_section").removeClass("d-none");
            $("#user_account_account_modal_body").removeClass("pb-0");

            // Use prop instead of attr
            $("#user_account_password").prop("required", true);
            $("#user_account_confirm_password").prop("required", true);
            $("#user_account_is_active").prop("disabled", false);
        }
    });

    $("#reset_filter_button").on("click", function (): void {
        const url = $(this).data('url') as string;

        showLoading();

        setTimeout(() => {
            location.href = url;
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

        clearValidation("#account_settings_username", ".username-error");
        clearValidation("#account_settings_current_password", ".password-error");
        clearValidation("#account_settings_new_password", ".password-error");

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
                console.log(xhr.responseText);
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

            clearValidation("#user_account_username", ".username-error");
            clearValidation("#user_account_password", ".password-error");
            clearValidation("#user_account_confirm_password", ".password-error");

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

            if (ROLE != 'SUPER_ADMIN') {
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
            } else {
                const password = $("#user_account_password").val()?.toString().trim();
                const confirm_password = $("#user_account_confirm_password").val()?.toString().trim();

                if (password != confirm_password) {
                    $("#user_account_password, #user_account_confirm_password").addClass("border-danger");
                    $("#user_account_password").parent().after(`<div class="text-danger small password-error">Passwords do not match.</div>`);
                } else {
                    showLoading();

                    const formData = { user_id, full_name, username, role, password };

                    $.ajax({
                        url: "update-user-account-super-admin-mode",
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
            }
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

        if (ROLE != 'SUPER_ADMIN') {
            $("#user_account_password_section").addClass("d-none");
            $("#user_account_account_modal_body").addClass("pb-0");
        }
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
                            console.log(_jqXHR.responseText);
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

    $(document).on("click", "#btnUpdateSystem", function (): void {
        Swal.fire({
            title: "Apply Updates?",
            text: "This will download the latest system changes and reload the application.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#1f4e79", // Official blue
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, update now",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then((result: any) => {
            if (result.isConfirmed) {
                showLoading();

                setTimeout(() => {
                    $.ajax({
                        url: "update-system",
                        type: "POST",
                        dataType: "json",
                        success: (response: { success: boolean; message?: string; updates?: number }) => {
                            hideLoading();

                            if (response.success) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    title: "Update Failed",
                                    text: response.message || "Something went wrong.",
                                    icon: "error"
                                });
                            }
                        },
                        error: (_jqXHR, _textStatus, errorThrown) => {
                            console.error(errorThrown);
                            hideLoading();
                            Swal.fire({
                                title: "Server Error",
                                text: "Failed to process update request.",
                                icon: "error"
                            });
                        }
                    });
                }, 250);
            }
        });
    });

    $('.info-text').each(function () {
        const $el = $(this);
        const tooltipText = $el.data('tooltip') as string || '';
        const $tooltip = $('<div>')
            .addClass('tooltip-custom')
            .text(tooltipText)
            .appendTo('body');

        // Mouse enter: show tooltip
        $el.on('mouseenter', () => {
            const offset = $el.offset();
            if (offset) {
                $tooltip.css({
                    top: offset.top + $el.outerHeight()! + 6,
                    left: offset.left,
                    display: 'block'
                });
            }
        });

        // Mouse leave: hide tooltip
        $el.on('mouseleave', () => {
            $tooltip.css('display', 'none');
        });

        // Click: toggle tooltip
        $el.on('click', () => {
            $tooltip.css('display', $tooltip.css('display') === 'block' ? 'none' : 'block');
        });
    });

    $('#system_info_official_logo').on('change', function () {
        const previewContainer = $('#systemInfoForm .bg-white');
        const input = this as HTMLInputElement; // ✅ fix here
        const files = input.files;

        if (!files || files.length === 0) {
            previewContainer.html(originalContent);
            return;
        }

        const file = files[0];

        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            $(this).val('');
            previewContainer.html(originalContent);
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            previewContainer.html(
                '<img src="' + e.target?.result + '" ' +
                'style="max-height: 100%; max-width: 100%; border-radius: 8px; object-fit: contain;">'
            );
        };

        reader.readAsDataURL(file);
    });

    $('#systemInfoForm').on('submit', function (e) {
        e.preventDefault();

        const id = $('#system_info_id').val()?.toString().trim();
        const barangay_name = $('#system_info_barangay_name').val()?.toString().trim();

        // File handling
        const fileInput = $('#system_info_official_logo')[0] as HTMLInputElement;
        const official_logo = fileInput.files && fileInput.files.length > 0 ? fileInput.files[0] : null;

        // Remove error states (if you plan to validate later)
        $('#system_info_barangay_name').removeClass('border-danger');

        showLoading();

        // Since there's a file, use FormData for AJAX
        const ajaxData = new FormData();

        ajaxData.append('id', id || '');
        ajaxData.append('barangay_name', barangay_name || '');

        if (official_logo) {
            ajaxData.append('official_logo', official_logo);
        }

        $.ajax({
            url: 'update-system-info',
            method: 'POST',
            data: ajaxData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: (response) => {
                setTimeout(() => {
                    if (response.success) {
                        location.reload();
                    } else {
                        hideLoading();
                        alert(response.error || 'Failed to update system information.');
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

    $("#householdSearchForm").on("submit", (): void => {
        const search_input = $("#search_input").val()?.toString().trim();
        const comfort_room = $("#comfort_room").val()?.toString().trim();
        const water_system = $("#water_system").val()?.toString().trim();

        // Build URL parameters
        const params = new URLSearchParams();

        if (search_input) params.set("search_input", search_input);
        if (comfort_room) params.set("comfort_room", comfort_room);
        if (water_system) params.set("water_system", water_system);

        // Reset page to 1 on new search
        params.set("page", "1");

        // Reload page with query string
        const baseUrl = window.location.pathname; // keeps /user-management

        showLoading();

        setTimeout(() => {
            window.location.href = `${baseUrl}?${params.toString()}`;
        }, 250);
    });

    $("#socioEconomicSearchForm").on("submit", (): void => {
        const search_input = $("#search_input").val()?.toString().trim();
        const comfort_room = $("#comfort_room").val()?.toString().trim();
        const water_system = $("#water_system").val()?.toString().trim();

        // Build URL parameters
        const params = new URLSearchParams();

        if (search_input) params.set("search_input", search_input);
        if (comfort_room) params.set("comfort_room", comfort_room);
        if (water_system) params.set("water_system", water_system);

        // Reset page to 1 on new search
        params.set("page", "1");

        // Reload page with query string
        const baseUrl = window.location.pathname; // keeps /user-management

        showLoading();

        setTimeout(() => {
            window.location.href = `${baseUrl}?${params.toString()}`;
        }, 250);
    });

    $("#residentsSearchForm").on("submit", (): void => {
        const search_input = $("#search_input").val()?.toString().trim();
        const sex = $("#sex").val()?.toString().trim();
        const relationship = $("#relationship").val()?.toString().trim();

        // Build URL parameters
        const params = new URLSearchParams();

        if (search_input) params.set("search_input", search_input);
        if (sex) params.set("sex", sex);
        if (relationship) params.set("relationship", relationship);

        // Reset page to 1 on new search
        params.set("page", "1");

        // Reload page with query string
        const baseUrl = window.location.pathname; // keeps /user-management

        showLoading();

        setTimeout(() => {
            window.location.href = `${baseUrl}?${params.toString()}`;
        }, 250);
    });

    $('#household_purok').on('change', function () {
        const purok = $(this).val()?.toString().trim();

        const formData = { purok };

        $.ajax({
            url: 'generate-household-code',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            success: (response) => {
                $('#household_household_code').val(response.household_code);
            },
            error: (xhr, status, error) => {
                hideLoading();
                console.error('AJAX Error:', error);
                console.log(xhr.responseText);
            }
        });
    });

    $('#household_form').on('submit', function (e) {
        e.preventDefault();

        const household_code = String($('#household_household_code').val() ?? '').trim();
        const purok = String($('#household_purok').val() ?? '').trim();
        const address = String($('#household_address').val() ?? '').trim();

        const housing_type = String($('#household_housing_type').val() ?? '').trim();
        const ownership_status = String($('#household_ownership_status').val() ?? '').trim();
        const comfort_room = String($('#household_comfort_room').val() ?? '').trim();
        const water_system = String($('#household_water_system').val() ?? '').trim();

        const electricity_access = $('#household_electricity_access').val();

        showLoading();

        const formData = {
            household_code,
            purok,
            address,
            housing_type,
            ownership_status,
            comfort_room,
            water_system,
            electricity_access
        };

        $.ajax({
            url: 'add-household',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            success: (response) => {
                setTimeout(() => {
                    if (response.success) {
                        location.reload();
                    } else {
                        hideLoading();
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

    $('#edit_household_form').on('submit', function (e) {
        e.preventDefault();

        const id = String($('#edit_household_id').val() ?? '').trim();

        const household_code = String($('#edit_household_household_code').val() ?? '').trim();
        const purok = String($('#edit_household_purok').val() ?? '').trim();
        const address = String($('#edit_household_address').val() ?? '').trim();

        const housing_type = String($('#edit_household_housing_type').val() ?? '').trim();
        const ownership_status = String($('#edit_household_ownership_status').val() ?? '').trim();
        const comfort_room = String($('#edit_household_comfort_room').val() ?? '').trim();
        const water_system = String($('#edit_household_water_system').val() ?? '').trim();

        const electricity_access = $('#edit_household_electricity_access').val();

        showLoading();

        const formData = {
            id,
            household_code,
            purok,
            address,
            housing_type,
            ownership_status,
            comfort_room,
            water_system,
            electricity_access
        };

        $.ajax({
            url: 'update-household',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            success: (response) => {
                setTimeout(() => {
                    if (response.success) {
                        location.reload();
                    } else {
                        hideLoading();
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

    $(document).on('click', '.btn-view-household', function () {
        const household = $(this).data('household');

        $('#view_household_household_code').text(household.household_code);
        $('#view_household_purok').text(household.purok);
        $('#view_household_address').text(household.address);
        $('#view_household_housing_type').text(household.housing_type);
        $('#view_household_ownership_status').text(household.ownership_status);
        $('#view_household_comfort_room').text(household.comfort_room);
        $('#view_household_water_system').text(household.water_system);
        $('#view_household_electricity_access').text(household.electricity_access == '1' ? 'Yes' : 'No');
    });

    $(document).on('click', '.btn-edit-household', function () {
        const household = $(this).data('household');

        $('#edit_household_id').val(household.id);
        $('#edit_household_household_code').val(household.household_code);
        $('#edit_household_purok').val(household.purok);
        $('#edit_household_address').val(household.address);
        $('#edit_household_housing_type').val(household.housing_type);
        $('#edit_household_ownership_status').val(household.ownership_status);
        $('#edit_household_comfort_room').val(household.comfort_room);
        $('#edit_household_water_system').val(household.water_system);
        $('#edit_household_electricity_access').val(household.electricity_access);

        $('#edit_original_household_purok').val(household.purok);
        $('#edit_original_household_household_code').val(household.household_code);
    });

    $('#edit_household_purok').on('change', function () {
        const purok = $(this).val()?.toString().trim();
        const originalPurok = $('#edit_original_household_purok').val()?.toString().trim();
        const originalCode = $('#edit_original_household_household_code').val()?.toString().trim();

        // If same as original → revert, no AJAX
        if (purok === originalPurok) {
            $('#edit_household_household_code').val(originalCode ?? '');

            return;
        }

        $.ajax({
            url: 'generate-household-code',
            method: 'POST',
            data: { purok },
            dataType: 'JSON',
            success: (response) => {
                $('#edit_household_household_code').val(response.household_code);
            },
            error: (xhr, status, error) => {
                hideLoading();
                console.error('AJAX Error:', error);
                console.log(xhr.responseText);
            }
        });
    });

    $('#add_resident_birthdate').on('change', function () {
        const birthdate = $(this).val()?.toString().trim();

        clearValidation("#add_resident_birthdate", ".birthdate-error");

        if (!birthdate) return; // ⬅️ ensures it's always a string below

        const birthDateObj = new Date(birthdate);

        if (birthDateObj > new Date()) {
            $('#add_resident_age').val('');

            $("#add_resident_birthdate")
                .addClass("border-danger")
                .parent()
                .after(`<div class="text-danger small birthdate-error">Invalid birthdate.</div>`);
        } else {
            const age = Math.floor(
                (new Date().getTime() - birthDateObj.getTime()) /
                (365.25 * 24 * 60 * 60 * 1000)
            );

            $('#add_resident_age').val(`${age} ${age < 2 ? 'year old' : 'years old'}`);
        }
    });

    $('#add_resident_form').on('submit', function (e) {
        e.preventDefault();

        const household_id = $('#add_resident_household_id').val()?.toString().trim();
        const first_name = $('#add_resident_first_name').val()?.toString().trim();
        const middle_name = $('#add_resident_middle_name').val()?.toString().trim();
        const last_name = $('#add_resident_last_name').val()?.toString().trim();
        const sex = $('#add_resident_sex').val()?.toString().trim();
        const birthdate = $('#add_resident_birthdate').val()?.toString().trim();
        const civil_status = $('#add_resident_civil_status').val()?.toString().trim();
        const relationship = $('#add_resident_relationship').val()?.toString().trim();
        const status = $('#add_resident_status').val()?.toString().trim();

        showLoading();

        const formData = { household_id, first_name, middle_name, last_name, sex, birthdate, civil_status, relationship, status };

        $.ajax({
            url: 'add-resident',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            success: (response) => {
                setTimeout(() => {
                    if (response.success) {
                        location.reload();
                    } else {
                        hideLoading();
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

    $(document).on('click', '.btn-view-resident', function () {
        const resident = $(this).data('resident');
        const birthDateObj = new Date(resident.birthdate);
        const age = Math.floor(
            (new Date().getTime() - birthDateObj.getTime()) /
            (365.25 * 24 * 60 * 60 * 1000)
        );
        const middleInitial = resident.middle_name ? ` ${resident.middle_name.charAt(0)}.` : '';

        $('#view_resident_fullname').html(`${resident.first_name}${middleInitial} ${resident.last_name}`.trim());
        $('#view_resident_household').html(resident.purok + ' - ' + resident.household_code);
        $('#view_resident_last_name').html(resident.last_name);
        $('#view_resident_first_name').html(resident.first_name);
        $('#view_resident_middle_name').html(resident.middle_name ? resident.middle_name : 'N/A');
        $('#view_resident_sex').html(resident.sex);
        $('#view_resident_birthdate').html(new Date(resident.birthdate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }));
        $('#view_resident_age').html(`${age} ${age < 2 ? 'year old' : 'years old'}`);
        $('#view_resident_civil_status').html(resident.civil_status);
        $('#view_resident_relationship').html(resident.relationship);
        $('#view_resident_status').html(resident.status);
        $('#view_resident_status_pill').html(resident.status);
        $('#view_resident_status').html(resident.status).attr('class', `${getStatusClass(resident.status, false)}`);
        $('#view_resident_status_pill').html(resident.status).attr('class', `pill ${getStatusClass(resident.status, true)}`);

        if (resident.middle_name) {
            $('#view_resident_middle_name').removeClass('text-muted');
        } else {
            $('#view_resident_middle_name').addClass('text-muted');
        }
    });

    $(document).on('click', '.btn-edit-resident', function () {
        const resident = $(this).data('resident');

        const birthDateObj = new Date(resident.birthdate);

        const age = Math.floor(
            (new Date().getTime() - birthDateObj.getTime()) /
            (365.25 * 24 * 60 * 60 * 1000)
        );

        $('#edit_resident_id').val(resident.id);
        $('#edit_resident_household_id').val(resident.household_id);
        $('#edit_resident_last_name').val(resident.last_name);
        $('#edit_resident_first_name').val(resident.first_name);
        $('#edit_resident_middle_name').val(resident.middle_name);
        $('#edit_resident_sex').val(resident.sex);
        $('#edit_resident_birthdate').val(resident.birthdate);
        $('#edit_resident_age').val(`${age} ${age < 2 ? 'year old' : 'years old'}`);
        $('#edit_resident_civil_status').val(resident.civil_status);
        $('#edit_resident_relationship').val(resident.relationship);
        $('#edit_resident_status').val(resident.status);
    });

    $('#edit_resident_birthdate').on('change', function () {
        const birthdate = $(this).val()?.toString().trim();

        clearValidation("#edit_resident_birthdate", ".birthdate-error");

        if (!birthdate) return; // ⬅️ ensures it's always a string below

        const birthDateObj = new Date(birthdate);

        if (birthDateObj > new Date()) {
            $('#edit_resident_age').val('');

            $("#edit_resident_birthdate")
                .addClass("border-danger")
                .parent()
                .after(`<div class="text-danger small birthdate-error">Invalid birthdate.</div>`);
        } else {
            const age = Math.floor(
                (new Date().getTime() - birthDateObj.getTime()) /
                (365.25 * 24 * 60 * 60 * 1000)
            );

            $('#edit_resident_age').val(`${age} ${age < 2 ? 'year old' : 'years old'}`);
        }
    });

    $('#edit_resident_form').on('submit', function (e) {
        e.preventDefault();

        const id = $('#edit_resident_id').val()?.toString().trim();
        const household_id = $('#edit_resident_household_id').val()?.toString().trim();
        const first_name = $('#edit_resident_first_name').val()?.toString().trim();
        const middle_name = $('#edit_resident_middle_name').val()?.toString().trim();
        const last_name = $('#edit_resident_last_name').val()?.toString().trim();
        const sex = $('#edit_resident_sex').val()?.toString().trim();
        const birthdate = $('#edit_resident_birthdate').val()?.toString().trim();
        const civil_status = $('#edit_resident_civil_status').val()?.toString().trim();
        const relationship = $('#edit_resident_relationship').val()?.toString().trim();
        const status = $('#edit_resident_status').val()?.toString().trim();

        showLoading();

        const formData = { id, household_id, first_name, middle_name, last_name, sex, birthdate, civil_status, relationship, status };

        $.ajax({
            url: 'edit-resident',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            success: (response) => {
                setTimeout(() => {
                    if (response.success) {
                        location.reload();
                    } else {
                        hideLoading();
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

    $('#socio_economic_form').on('submit', function (e) {
        e.preventDefault();

        const resident_id = $('#add_socio_economic_resident_id').val()?.toString().trim();
        const occupation = $('#add_socio_economic_occupation').val()?.toString().trim();
        const employment_status = $('#add_socio_economic_employment_status').val()?.toString().trim();
        const monthly_income = $('#add_socio_economic_monthly_income').val()?.toString().trim();
        const education_level = $('#add_socio_economic_education_level').val()?.toString().trim();
        const literacy_status = $('#add_socio_economic_literacy_status').val()?.toString().trim();

        clearValidation("#add_socio_economic_resident_id", ".resident_id-error");

        showLoading();

        const formData = { resident_id, occupation, employment_status, monthly_income, education_level, literacy_status };

        $.ajax({
            url: 'add-socio-economic-profile',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            success: (response) => {
                setTimeout(() => {
                    if (response.success) {
                        location.reload();
                    } else {
                        hideLoading();

                        $("#add_socio_economic_resident_id").addClass("border-danger").parent().after(`<div class="text-danger small resident_id-error">${response.error}</div>`);
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

    $('#edit_socio_economic_form').on('submit', function (e) {
        e.preventDefault();

        const id = $('#edit_socio_economic_id').val()?.toString().trim();
        const resident_id = $('#edit_socio_economic_resident_id').val()?.toString().trim();
        const occupation = $('#edit_socio_economic_occupation').val()?.toString().trim();
        const employment_status = $('#edit_socio_economic_employment_status').val()?.toString().trim();
        const monthly_income = $('#edit_socio_economic_monthly_income').val()?.toString().trim();
        const education_level = $('#edit_socio_economic_education_level').val()?.toString().trim();
        const literacy_status = $('#edit_socio_economic_literacy_status').val()?.toString().trim();

        clearValidation("#edit_socio_economic_resident_id", ".resident_id-error");

        showLoading();

        const formData = { id, resident_id, occupation, employment_status, monthly_income, education_level, literacy_status };

        $.ajax({
            url: 'edit-socio-economic-profile',
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            success: (response) => {
                setTimeout(() => {
                    if (response.success) {
                        location.reload();
                    } else {
                        hideLoading();

                        $("#edit_socio_economic_resident_id").addClass("border-danger").parent().after(`<div class="text-danger small resident_id-error">${response.error}</div>`);
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

    $("#add_socio_economic_resident_id").on("change", function () {
        clearValidation("#add_socio_economic_resident_id", ".resident_id-error");
    });

    $(document).on('click', '.btn-edit-socio-economic-profile', function () {
        const id = $(this).data('id');
        const resident_id = $(this).data('resident_id');
        const occupation = $(this).data('occupation');
        const employment_status = $(this).data('employment_status');
        const monthly_income = $(this).data('monthly_income');
        const education_level = $(this).data('education_level');
        const literacy_status = $(this).data('literacy_status');

        $('#edit_socio_economic_id').val(id);
        $('#edit_socio_economic_resident_id').val(resident_id);
        $('#edit_socio_economic_occupation').val(occupation);
        $('#edit_socio_economic_employment_status').val(employment_status);
        $('#edit_socio_economic_monthly_income').val(monthly_income);
        $('#edit_socio_economic_education_level').val(education_level);
        $('#edit_socio_economic_literacy_status').val(literacy_status);
    });

    $("#socioEconomicSearchForm").on("submit", (): void => {
        const search_input = $("#search_input").val()?.toString().trim();
        const employment_status = $("#employment_status").val()?.toString().trim();
        const education_level = $("#education_level").val()?.toString().trim();

        // Build URL parameters
        const params = new URLSearchParams();

        if (search_input) params.set("search_input", search_input);
        if (employment_status) params.set("employment_status", employment_status);
        if (education_level) params.set("education_level", education_level);

        // Reset page to 1 on new search
        params.set("page", "1");

        // Reload page with query string
        const baseUrl = window.location.pathname; // keeps /user-management

        showLoading();

        setTimeout(() => {
            window.location.href = `${baseUrl}?${params.toString()}`;
        }, 250);
    });

    $('#btnSeedSampleData').on('click', function () {
        Swal.fire({
            title: "Seed Sample Data?",
            text: "This will populate the system with sample data and delete existing data.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#1f4e79", // Official blue
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, seed now",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then((result: any) => {
            if (result.isConfirmed) {
                showLoading();

                $.ajax({
                    url: 'seed-sample-data',
                    method: 'POST',
                    dataType: 'JSON',
                    success: (response) => {
                        setTimeout(() => {
                            if (response.success) {
                                location.reload();
                            }
                        }, 250);
                    },
                    error: (xhr, status, error) => {
                        hideLoading();
                        console.error('AJAX Error:', error);
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
});

function getStatusClass(status: string | null | undefined, isPill: boolean): string {
    let bgClass = '';

    switch ((status || '').toLowerCase()) {
        case 'active':
            if (isPill) {
                bgClass = 'bg-success-subtle border border-success-subtle';
            }

            return 'text-success ' + bgClass;

        case 'inactive':
            if (isPill) {
                bgClass = 'bg-secondary-subtle border border-secondary-subtle';
            }

            return 'text-secondary ' + bgClass;

        case 'transferred':
            if (isPill) {
                bgClass = 'bg-warning-subtle border border-warning-subtle';
            }
            return 'text-warning ' + bgClass;

        case 'deceased':
            if (isPill) {
                bgClass = 'bg-danger-subtle border border-danger-subtle';
            }
            return 'text-danger ' + bgClass;

        default:
            return 'text-dark bg-light border';
    }
}

function checkUpdates() {
    $.ajax({
        url: 'check-updates',
        method: 'GET',
        dataType: 'JSON',
        success: (res) => {
            if (!res.success) return;

            const badge = $('#updateBadge');
            const status = $('#updateStatus');
            const drpdwn_updates = $('#drpdwn_updates');

            if (res.count > 0) {
                badge.removeClass('d-none').text(res.count);
                drpdwn_updates.removeClass('d-none');

                status.html(`
                    <div class="text-warning fw-bold mb-1">
                        ${res.count} update(s) available
                    </div>
                    <small>Click "Apply Updates" to sync system.</small>
                `);
            } else {
                drpdwn_updates.addClass('d-none');
                badge.addClass('d-none');

                status.html(`
                    <div class="text-success fw-bold">
                        System is up to date
                    </div>
                `);
            }
        }
    });
}

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