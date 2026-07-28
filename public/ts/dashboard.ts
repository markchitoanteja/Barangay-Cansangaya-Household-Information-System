document.addEventListener("DOMContentLoaded", () => {

    // ===============================
    // SAMPLE DATA
    // ===============================

    const genderData = {
        male: 325,
        female: 348
    };

    const residentStatus = {
        active: 640,
        deceased: 18,
        transferred: 15
    };

    const employmentData = {
        labels: [
            "Employed",
            "Unemployed",
            "Self-employed",
            "Student",
            "Retired"
        ],
        values: [210, 72, 98, 180, 35]
    };

    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const births = [3, 5, 6, 4, 7, 5, 8, 6, 4, 7, 5, 3];
    const deaths = [1, 0, 2, 1, 1, 2, 1, 3, 0, 1, 2, 1];


    // ===============================
    // Population by Sex
    // ===============================

    new Chart(document.getElementById("genderChart"), {
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


    // ===============================
    // Resident Status
    // ===============================

    new Chart(document.getElementById("residentStatusChart"), {
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


    // ===============================
    // Births vs Deaths
    // ===============================

    new Chart(document.getElementById("birthDeathChart"), {
        type: "line",
        data: {
            labels: months,
            datasets: [
                {
                    label: "Births",
                    data: births,
                    tension: .35,
                    fill: false
                },
                {
                    label: "Deaths",
                    data: deaths,
                    tension: .35,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });


    // ===============================
    // Employment Status
    // ===============================

    new Chart(document.getElementById("employmentChart"), {
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

});
