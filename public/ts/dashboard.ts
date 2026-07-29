document.addEventListener("DOMContentLoaded", () => {
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

    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const births = [
        birthsRaw.jan, birthsRaw.feb, birthsRaw.mar, birthsRaw.apr, birthsRaw.may, birthsRaw.jun,
        birthsRaw.jul, birthsRaw.aug, birthsRaw.sep, birthsRaw.oct, birthsRaw.nov, birthsRaw.dec
    ];
    
    const deaths = [
        deathsRaw.jan, deathsRaw.feb, deathsRaw.mar, deathsRaw.apr, deathsRaw.may, deathsRaw.jun,
        deathsRaw.jul, deathsRaw.aug, deathsRaw.sep, deathsRaw.oct, deathsRaw.nov, deathsRaw.dec
    ];

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
