// ===============================
// Global PHP-generated data
// ===============================

interface EmploymentDataRaw {
    employed: number;
    unemployed: number;
    self_employed: number;
    student: number;
    retired: number;
}

interface MonthlyData {
    jan: number;
    feb: number;
    mar: number;
    apr: number;
    may: number;
    jun: number;
    jul: number;
    aug: number;
    sep: number;
    oct: number;
    nov: number;
    dec: number;
}

interface GenderData {
    male: number;
    female: number;
}

interface ResidentStatus {
    active: number;
    deceased: number;
    transferred: number;
}

// ===============================
// DOM Loaded
// ===============================

document.addEventListener("DOMContentLoaded", (): void => {

    // ===============================
    // Employment Data
    // ===============================

    const employmentData = {
        labels: [
            "Employed",
            "Unemployed",
            "Self-employed",
            "Student",
            "Retired"
        ],

        values: [
            employmentDataRaw.employed,
            employmentDataRaw.unemployed,
            employmentDataRaw.self_employed,
            employmentDataRaw.student,
            employmentDataRaw.retired
        ]
    };


    // ===============================
    // Months
    // ===============================

    const months: string[] = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];


    // ===============================
    // Births
    // ===============================

    const births: number[] = [
        birthsRaw.jan,
        birthsRaw.feb,
        birthsRaw.mar,
        birthsRaw.apr,
        birthsRaw.may,
        birthsRaw.jun,
        birthsRaw.jul,
        birthsRaw.aug,
        birthsRaw.sep,
        birthsRaw.oct,
        birthsRaw.nov,
        birthsRaw.dec
    ];


    // ===============================
    // Deaths
    // ===============================

    const deaths: number[] = [
        deathsRaw.jan,
        deathsRaw.feb,
        deathsRaw.mar,
        deathsRaw.apr,
        deathsRaw.may,
        deathsRaw.jun,
        deathsRaw.jul,
        deathsRaw.aug,
        deathsRaw.sep,
        deathsRaw.oct,
        deathsRaw.nov,
        deathsRaw.dec
    ];


    // ===============================
    // Population by Sex
    // ===============================

    const genderCanvas = document.getElementById(
        "genderChart"
    ) as HTMLCanvasElement | null;

    if (genderCanvas) {
        new Chart(genderCanvas, {
            type: "doughnut",

            data: {
                labels: ["Male", "Female"],

                datasets: [{
                    data: [
                        genderData.male,
                        genderData.female
                    ]
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: "bottom"
                    }
                }
            }
        });
    }


    // ===============================
    // Resident Status
    // ===============================

    const residentStatusCanvas = document.getElementById(
        "residentStatusChart"
    ) as HTMLCanvasElement | null;

    if (residentStatusCanvas) {
        new Chart(residentStatusCanvas, {
            type: "pie",

            data: {
                labels: [
                    "Active",
                    "Deceased",
                    "Transferred"
                ],

                datasets: [{
                    data: [
                        residentStatus.active,
                        residentStatus.deceased,
                        residentStatus.transferred
                    ]
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: "bottom"
                    }
                }
            }
        });
    }


    // ===============================
    // Births vs Deaths
    // ===============================

    const birthDeathCanvas = document.getElementById(
        "birthDeathChart"
    ) as HTMLCanvasElement | null;

    if (birthDeathCanvas) {
        new Chart(birthDeathCanvas, {
            type: "line",

            data: {
                labels: months,

                datasets: [
                    {
                        label: "Births",
                        data: births,
                        tension: 0.35,
                        fill: false
                    },

                    {
                        label: "Deaths",
                        data: deaths,
                        tension: 0.35,
                        fill: false
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }


    // ===============================
    // Employment Status
    // ===============================

    const employmentCanvas = document.getElementById(
        "employmentChart"
    ) as HTMLCanvasElement | null;

    if (employmentCanvas) {
        new Chart(employmentCanvas, {
            type: "bar",

            data: {
                labels: employmentData.labels,

                datasets: [{
                    label: "Residents",
                    data: employmentData.values,
                    borderRadius: 6
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

});