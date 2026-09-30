document.addEventListener('DOMContentLoaded', function () {


    /* ==========================================================
       STATE
    ========================================================== */

    let analysisComplete: boolean = false;

    let populationChart: any = null;

    let historicalPopulationChart: any = null;



    /* ==========================================================
       HISTORICAL DATA
    ========================================================== */

    interface HistoricalPopulation {

        year: number;

        population: number;

    }


    const historicalData: HistoricalPopulation[] =
        Array.isArray((window as any).populationHistory)

            ? (window as any).populationHistory
                .map(
                    (item: any): HistoricalPopulation => ({

                        year: Number(item.year),

                        population: Number(item.population)

                    })
                )
                .filter(
                    (item: HistoricalPopulation) =>

                        Number.isFinite(item.year) &&

                        Number.isFinite(item.population)

                )
                .sort(
                    (
                        a: HistoricalPopulation,
                        b: HistoricalPopulation
                    ) =>

                        a.year - b.year

                )

            : [];



    /* ==========================================================
       INTERFACES
    ========================================================== */

    interface DemographicMetrics {

        netMigration: number;

        naturalIncrease: number;

        totalChange: number;

        growthRate: number;

        birthRate: number;

        deathRate: number;

        migrationRate: number;

        dependencyRatio: number;

        employmentRate: number;

        malePercentage: number;

        femalePercentage: number;

        householdSize: number;

    }


    interface ForecastResult {

        population: number;

        growth: number;

        change: number;

    }



    /* ==========================================================
       ELEMENTS
    ========================================================== */

    const analyzeButton =
        document.getElementById(
            'analyzeButton'
        ) as HTMLButtonElement | null;


    const aiControl =
        document.getElementById(
            'aiControl'
        ) as HTMLElement | null;


    const analysisStatus =
        document.getElementById(
            'analysisStatus'
        ) as HTMLElement | null;


    const analysisStatusText =
        document.getElementById(
            'analysisStatusText'
        ) as HTMLElement | null;


    const analysisProgressBar =
        document.getElementById(
            'analysisProgressBar'
        ) as HTMLElement | null;


    const analysisResults =
        document.getElementById(
            'analysisResults'
        ) as HTMLElement | null;


    const forecastYears =
        document.getElementById(
            'forecastYears'
        ) as HTMLInputElement | null;


    const forecastYearsDecrease =
        document.getElementById(
            'forecastYearsDecrease'
        ) as HTMLButtonElement | null;


    const forecastYearsIncrease =
        document.getElementById(
            'forecastYearsIncrease'
        ) as HTMLButtonElement | null;


    const forecastYearsError =
        document.getElementById(
            'forecastYearsError'
        ) as HTMLElement | null;



    /* ==========================================================
       HELPERS
    ========================================================== */

    function formatNumber(
        value: number
    ): string {

        return Math.round(
            value
        ).toLocaleString();

    }


    function formatDecimal(
        value: number,
        decimals: number = 2
    ): string {

        return Number(
            value
        ).toFixed(
            decimals
        );

    }


    function delay(
        milliseconds: number
    ): Promise<void> {

        return new Promise(
            (
                resolve
            ) => {

                setTimeout(
                    resolve,
                    milliseconds
                );

            }
        );

    }


    function setText(
        id: string,
        value: string | number
    ): void {

        const element =
            document.getElementById(
                id
            );


        if (element) {

            element.textContent =
                String(value);

        }

    }


    function updateAnalysisStatus(
        message: string
    ): void {

        if (analysisStatusText) {

            analysisStatusText.textContent =
                message;

        }

    }


    function updateProgress(
        value: number
    ): void {

        if (analysisProgressBar) {

            analysisProgressBar.style.width =
                value + '%';

        }

    }



    /* ==========================================================
       SAFE DIVISION
    ========================================================== */

    function safeDivide(
        numerator: number,
        denominator: number
    ): number {

        if (!Number.isFinite(numerator)) {

            return 0;

        }


        if (
            !Number.isFinite(denominator) ||
            denominator === 0
        ) {

            return 0;

        }


        return numerator / denominator;

    }



    /* ==========================================================
       FORECAST ERROR DISPLAY
    ========================================================== */

    function showForecastYearsError(
        message: string
    ): void {

        if (forecastYearsError) {

            forecastYearsError.innerHTML =

                '<i class="fa-solid fa-circle-exclamation me-1"></i>' +

                message;

            forecastYearsError.classList.add(
                'show'
            );

        }


        if (forecastYears) {

            forecastYears.classList.add(
                'is-invalid'
            );

        }

    }


    function clearForecastYearsError(): void {

        if (forecastYearsError) {

            forecastYearsError.textContent =
                '';

            forecastYearsError.classList.remove(
                'show'
            );

        }


        if (forecastYears) {

            forecastYears.classList.remove(
                'is-invalid'
            );

        }

    }



    /* ==========================================================
       VALIDATE FORECAST YEARS
    ========================================================== */

    function validateForecastYears(): number | null {

        if (!forecastYears) {

            return 5;

        }


        const rawValue =
            forecastYears.value.trim();


        /*
         * Empty input.
         */

        if (rawValue === '') {

            showForecastYearsError(
                'Please enter the number of forecast years.'
            );

            return null;

        }


        const years =
            Number(rawValue);


        /*
         * Invalid number.
         */

        if (!Number.isFinite(years)) {

            showForecastYearsError(
                'Please enter a valid number of years.'
            );

            return null;

        }


        /*
         * Decimal numbers are not allowed.
         */

        if (!Number.isInteger(years)) {

            showForecastYearsError(
                'Forecast years must be a whole number.'
            );

            return null;

        }


        /*
         * Minimum.
         */

        if (years < 1) {

            showForecastYearsError(
                'Forecast period must be at least 1 year.'
            );

            return null;

        }


        /*
         * Maximum.
         */

        if (years > 100) {

            showForecastYearsError(
                'Forecast period cannot exceed 100 years.'
            );

            return null;

        }


        /*
         * Valid.
         */

        clearForecastYearsError();

        return years;

    }



    /* ==========================================================
       DEMOGRAPHICS
    ========================================================== */

    function calculateDemographics(): DemographicMetrics {

        const netMigration =
            dbData.migrationIn -
            dbData.migrationOut;


        const naturalIncrease =
            dbData.births -
            dbData.deaths;


        const totalChange =
            naturalIncrease +
            netMigration;


        const growthRate =
            safeDivide(
                totalChange,
                dbData.population
            ) * 100;


        const birthRate =
            safeDivide(
                dbData.births,
                dbData.population
            ) * 1000;


        const deathRate =
            safeDivide(
                dbData.deaths,
                dbData.population
            ) * 1000;


        const migrationRate =
            safeDivide(
                netMigration,
                dbData.population
            ) * 1000;


        const dependencyRatio =
            safeDivide(
                dbData.children +
                dbData.seniors,
                dbData.workingAge
            ) * 100;


        const employmentRate =
            safeDivide(
                dbData.employed,
                dbData.workingAge
            ) * 100;


        const malePercentage =
            safeDivide(
                dbData.male,
                dbData.population
            ) * 100;


        const femalePercentage =
            safeDivide(
                dbData.female,
                dbData.population
            ) * 100;


        const householdSize =
            safeDivide(
                dbData.population,
                dbData.households
            );


        return {

            netMigration,

            naturalIncrease,

            totalChange,

            growthRate,

            birthRate,

            deathRate,

            migrationRate,

            dependencyRatio,

            employmentRate,

            malePercentage,

            femalePercentage,

            householdSize

        };

    }



    /* ==========================================================
       FORECAST
    ========================================================== */

    function calculateForecast(
        years: number
    ): ForecastResult {

        const demographic =
            calculateDemographics();


        let annualGrowth =
            demographic.growthRate;


        /*
         * Demographic adjustment.
         */

        if (
            demographic.dependencyRatio > 60
        ) {

            annualGrowth *= 0.96;

        } else if (
            demographic.dependencyRatio < 40
        ) {

            annualGrowth *= 1.02;

        }


        /*
         * Positive migration momentum.
         */

        if (
            demographic.netMigration > 0
        ) {

            annualGrowth *= 1.01;

        }


        /*
         * Keep the demonstration model
         * within reasonable bounds.
         */

        annualGrowth =
            Math.max(
                -5,
                Math.min(
                    annualGrowth,
                    8
                )
            );


        const population =
            dbData.population *
            Math.pow(
                1 +
                annualGrowth / 100,
                years
            );


        return {

            population:
                Math.round(
                    population
                ),

            growth:
                annualGrowth,

            change:
                Math.round(
                    population -
                    dbData.population
                )

        };

    }



    /* ==========================================================
       BASIC DATA
    ========================================================== */

    function displayBasicData(): void {

        const demographic =
            calculateDemographics();


        setText(
            'currentPopulation',
            formatNumber(
                dbData.population
            )
        );


        setText(
            'birthsValue',
            formatNumber(
                dbData.births
            )
        );


        setText(
            'deathsValue',
            formatNumber(
                dbData.deaths
            )
        );


        const migrationElement =
            document.getElementById(
                'migrationValue'
            ) as HTMLElement | null;


        if (migrationElement) {

            migrationElement.textContent =
                (
                    demographic.netMigration >= 0
                        ? '+'
                        : ''
                ) +
                formatNumber(
                    demographic.netMigration
                );


            migrationElement.classList.remove(
                'value-positive',
                'value-negative'
            );


            if (
                demographic.netMigration > 0
            ) {

                migrationElement.classList.add(
                    'value-positive'
                );

            } else if (
                demographic.netMigration < 0
            ) {

                migrationElement.classList.add(
                    'value-negative'
                );

            }

        }


        updateMigrationStatus(
            demographic.netMigration
        );


        setText(
            'birthRate',
            formatDecimal(
                demographic.birthRate
            )
        );


        setText(
            'deathRate',
            formatDecimal(
                demographic.deathRate
            )
        );


        setText(
            'migrationRate',
            formatDecimal(
                demographic.migrationRate
            )
        );


        setText(
            'dependencyRatio',
            formatDecimal(
                demographic.dependencyRatio,
                1
            ) + '%'
        );


        setText(
            'malePopulation',
            formatDecimal(
                demographic.malePercentage,
                1
            ) + '%'
        );


        setText(
            'femalePopulation',
            formatDecimal(
                demographic.femalePercentage,
                1
            ) + '%'
        );


        setText(
            'employmentRate',
            formatDecimal(
                demographic.employmentRate,
                1
            ) + '%'
        );


        setText(
            'householdSize',
            formatDecimal(
                demographic.householdSize,
                2
            )
        );

    }



    /* ==========================================================
       MIGRATION STATUS
    ========================================================== */

    function updateMigrationStatus(
        value: number
    ): void {

        const status =
            document.getElementById(
                'migrationStatus'
            ) as HTMLElement | null;


        const icon =
            document.getElementById(
                'migrationIcon'
            ) as HTMLElement | null;


        if (!status) return;


        status.classList.remove(
            'positive',
            'negative',
            'neutral'
        );


        if (value > 0) {

            status.classList.add(
                'positive'
            );


            status.innerHTML =
                '<i class="fa-solid fa-arrow-trend-up"></i> INCREASING';


            if (icon) {

                icon.classList.remove(
                    'red',
                    'blue'
                );


                icon.classList.add(
                    'green'
                );

            }

        } else if (value < 0) {

            status.classList.add(
                'negative'
            );


            status.innerHTML =
                '<i class="fa-solid fa-arrow-trend-down"></i> DECLINING';


            if (icon) {

                icon.classList.remove(
                    'green',
                    'blue'
                );


                icon.classList.add(
                    'red'
                );

            }

        } else {

            status.classList.add(
                'neutral'
            );


            status.innerHTML =
                '<i class="fa-solid fa-minus"></i> BALANCED';

        }

    }



    /* ==========================================================
       HISTORICAL REPORT
    ========================================================== */

    function generateHistoricalReport(): void {

        const table =
            document.getElementById(
                'historicalTable'
            ) as HTMLElement | null;


        if (!table) return;


        table.innerHTML =
            '';


        /*
         * Only the latest 10 historical
         * records are displayed.
         */

        const history =
            historicalData.slice(-10);


        if (
            history.length === 0
        ) {

            table.innerHTML = `

                <tr>

                    <td
                        colspan="5"
                        class="text-center text-muted py-4"
                    >

                        <i class="fa-solid fa-database me-2"></i>

                        No historical population records
                        are available.

                    </td>

                </tr>

            `;


            setText(
                'historicalStartYear',
                'N/A'
            );


            setText(
                'historicalStartPopulation',
                'N/A'
            );


            setText(
                'historicalChange',
                'N/A'
            );


            return;

        }


        const first =
            history[0];


        const last =
            history[
            history.length - 1
            ];


        setText(
            'historicalStartYear',
            first.year
        );


        setText(
            'historicalStartPopulation',
            formatNumber(
                first.population
            )
        );


        const historicalChange =
            last.population -
            first.population;


        setText(
            'historicalChange',
            (
                historicalChange >= 0
                    ? '+'
                    : ''
            ) +
            formatNumber(
                historicalChange
            )
        );


        let previousPopulation =
            first.population;


        history.forEach(
            (
                record: HistoricalPopulation,
                index: number
            ) => {

                let change = 0;

                let growth = 0;


                if (index > 0) {

                    change =
                        record.population -
                        previousPopulation;


                    growth =
                        safeDivide(
                            change,
                            previousPopulation
                        ) * 100;

                }


                let trendClass =
                    'table-stable';


                let trendIcon =
                    'fa-minus';


                if (change > 0) {

                    trendClass =
                        'table-positive';


                    trendIcon =
                        'fa-arrow-trend-up';

                } else if (
                    change < 0
                ) {

                    trendClass =
                        'table-negative';


                    trendIcon =
                        'fa-arrow-trend-down';

                }


                const row =
                    document.createElement(
                        'tr'
                    );


                row.innerHTML = `

                    <td>

                        <div class="forecast-year-cell">

                            <div class="forecast-year-icon">

                                <i class="fa-solid ${trendIcon}"></i>

                            </div>

                            <strong>
                                ${record.year}
                            </strong>

                        </div>

                    </td>


                    <td>

                        <strong>

                            ${formatNumber(
                    record.population
                )}

                        </strong>

                    </td>


                    <td class="${trendClass}">

                        ${index === 0

                        ? '—'

                        : (
                            change >= 0
                                ? '+'
                                : ''
                        ) +
                        formatNumber(
                            change
                        )
                    }

                    </td>


                    <td class="${trendClass}">

                        ${index === 0

                        ? '—'

                        : formatDecimal(
                            growth
                        ) + '%'
                    }

                    </td>


                    <td>

                        <span class="forecast-badge">

                            <i class="fa-solid fa-database"></i>

                            HISTORICAL

                        </span>

                    </td>

                `;


                table.appendChild(
                    row
                );


                previousPopulation =
                    record.population;

            }
        );

    }



    /* ==========================================================
       HISTORICAL CHART
    ========================================================== */

    function updateHistoricalChart(): void {

        if (
            typeof Chart === 'undefined'
        ) {

            console.warn(
                'Chart.js is not loaded.'
            );

            return;

        }


        const canvas =
            document.getElementById(
                'historicalPopulationChart'
            ) as HTMLCanvasElement | null;


        if (!canvas) return;


        const history =
            historicalData.slice(-10);


        if (
            history.length === 0
        ) {

            return;

        }


        const labels =
            history.map(
                (
                    item: HistoricalPopulation
                ) =>
                    item.year
            );


        const values =
            history.map(
                (
                    item: HistoricalPopulation
                ) =>
                    item.population
            );


        if (
            historicalPopulationChart
        ) {

            historicalPopulationChart.destroy();

        }


        const ctx =
            canvas.getContext(
                '2d'
            );


        if (!ctx) return;


        const gradient =
            ctx.createLinearGradient(
                0,
                0,
                0,
                320
            );


        gradient.addColorStop(
            0,
            'rgba(37,99,235,.20)'
        );


        gradient.addColorStop(
            1,
            'rgba(37,99,235,0)'
        );


        historicalPopulationChart =
            new Chart(
                canvas,
                {

                    type: 'line',

                    data: {

                        labels,

                        datasets: [

                            {

                                label:
                                    'Historical Population',

                                data:
                                    values,

                                borderWidth: 3,

                                tension: 0.35,

                                pointRadius: 4,

                                pointHoverRadius: 7,

                                pointBackgroundColor:
                                    '#2563eb',

                                pointBorderColor:
                                    '#ffffff',

                                pointBorderWidth: 2,

                                fill: true,

                                backgroundColor:
                                    gradient,

                                borderColor:
                                    '#2563eb'

                            }

                        ]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        animation: {

                            duration: 1000,

                            easing: 'easeOutQuart'

                        },

                        plugins: {

                            legend: {

                                display: false

                            },

                            tooltip: {

                                callbacks: {

                                    label:
                                        function (
                                            context: any
                                        ) {

                                            return (
                                                ' Population: ' +
                                                Number(
                                                    context.raw
                                                ).toLocaleString()
                                            );

                                        }

                                }

                            }

                        },

                        scales: {

                            y: {

                                beginAtZero: false,

                                grid: {

                                    color:
                                        'rgba(100,116,139,.08)'

                                },

                                ticks: {

                                    callback:
                                        function (
                                            value: any
                                        ) {

                                            return Number(
                                                value
                                            ).toLocaleString();

                                        }

                                }

                            },

                            x: {

                                grid: {

                                    display: false

                                }

                            }

                        }

                    }

                }
            );

    }



    /* ==========================================================
       FORECAST YEAR VALIDATION
    ========================================================== */

    function getValidForecastYears(): number | null {

        return validateForecastYears();

    }



    /* ==========================================================
       FORECAST UPDATE
    ========================================================== */

    function updateForecast(): void {

        if (!analysisComplete) {

            return;

        }


        const years =
            getValidForecastYears();


        /*
         * Do not update anything if
         * the user's input is invalid.
         */

        if (years === null) {

            return;

        }


        const forecast =
            calculateForecast(
                years
            );


        const targetYear =
            Number(dbData.year) +
            years;


        setText(
            'forecastPopulation',
            formatNumber(
                forecast.population
            )
        );


        setText(
            'forecastYear',
            targetYear
        );


        setText(
            'forecastGrowth',
            formatDecimal(
                forecast.growth
            ) + '%'
        );


        setText(
            'forecastChange',
            (
                forecast.change >= 0
                    ? '+'
                    : ''
            ) +
            formatNumber(
                forecast.change
            )
        );


        updateForecastDirection(
            forecast.growth
        );


        updateForecastMeta(
            forecast.growth,
            forecast.change
        );


        const confidence =
            calculateConfidence(
                years
            );


        setText(
            'confidenceValue',
            confidence + '%'
        );


        updateSignal(
            forecast.growth
        );


        updateResources(
            forecast.population
        );


        generateInsight(
            forecast,
            targetYear
        );


        generateForecastTable(
            years
        );


        updateForecastChart(
            years
        );

    }



    /* ==========================================================
       FORECAST DIRECTION
    ========================================================== */

    function updateForecastDirection(
        growth: number
    ): void {

        const number =
            document.getElementById(
                'forecastPopulation'
            ) as HTMLElement | null;


        const direction =
            document.getElementById(
                'forecastDirection'
            ) as HTMLElement | null;


        if (
            !number ||
            !direction
        ) {

            return;

        }


        number.classList.remove(
            'growth-positive',
            'growth-negative'
        );


        direction.classList.remove(
            'positive',
            'negative',
            'stable'
        );


        if (
            growth > 0.1
        ) {

            number.classList.add(
                'growth-positive'
            );


            direction.classList.add(
                'positive'
            );


            direction.innerHTML =
                '<i class="fa-solid fa-arrow-trend-up"></i>';

        } else if (
            growth < -0.1
        ) {

            number.classList.add(
                'growth-negative'
            );


            direction.classList.add(
                'negative'
            );


            direction.innerHTML =
                '<i class="fa-solid fa-arrow-trend-down"></i>';

        } else {

            direction.classList.add(
                'stable'
            );


            direction.innerHTML =
                '<i class="fa-solid fa-minus"></i>';

        }

    }



    /* ==========================================================
       FORECAST META
    ========================================================== */

    function updateForecastMeta(
        growth: number,
        change: number
    ): void {

        const growthMeta =
            document.getElementById(
                'growthMeta'
            ) as HTMLElement | null;


        const changeMeta =
            document.getElementById(
                'changeMeta'
            ) as HTMLElement | null;


        if (growthMeta) {

            growthMeta.classList.remove(
                'meta-positive',
                'meta-negative'
            );


            if (
                growth > 0
            ) {

                growthMeta.classList.add(
                    'meta-positive'
                );

            } else if (
                growth < 0
            ) {

                growthMeta.classList.add(
                    'meta-negative'
                );

            }

        }


        if (changeMeta) {

            changeMeta.classList.remove(
                'meta-positive',
                'meta-negative'
            );


            if (
                change > 0
            ) {

                changeMeta.classList.add(
                    'meta-positive'
                );

            } else if (
                change < 0
            ) {

                changeMeta.classList.add(
                    'meta-negative'
                );

            }

        }

    }



    /* ==========================================================
       CONFIDENCE
    ========================================================== */

    function calculateConfidence(
        years: number
    ): number {

        let confidence =
            93 -
            (years - 1) * 1.5;


        confidence =
            Math.max(
                60,
                Math.min(
                    confidence,
                    93
                )
            );


        return Math.round(
            confidence
        );

    }



    /* ==========================================================
       DEMOGRAPHIC SIGNAL
    ========================================================== */

    function updateSignal(
        growth: number
    ): void {

        let title: string;

        let description: string;

        let state:
            'positive' |
            'negative' |
            'stable';


        if (
            growth >= 3
        ) {

            title =
                'Strong Growth';


            description =
                'The population is projected to grow rapidly, which may increase demand for public services, housing and infrastructure.';


            state =
                'positive';

        } else if (
            growth >= 1
        ) {

            title =
                'Moderate Growth';


            description =
                'The population is showing a steady upward trajectory based on the current demographic conditions.';


            state =
                'positive';

        } else if (
            growth >= 0
        ) {

            title =
                'Stable';


            description =
                'The population is expected to remain relatively stable over the selected forecast period.';


            state =
                'stable';

        } else {

            title =
                'Declining';


            description =
                'Current demographic conditions indicate a potential population decline that may affect future service demand.';


            state =
                'negative';

        }


        setText(
            'populationSignal',
            title
        );


        setText(
            'populationSignalText',
            description
        );


        const panel =
            document.getElementById(
                'signalPanel'
            ) as HTMLElement | null;


        const icon =
            document.getElementById(
                'signalIcon'
            ) as HTMLElement | null;


        const dot =
            document.getElementById(
                'signalIndicatorDot'
            ) as HTMLElement | null;


        if (!panel) return;


        panel.classList.remove(
            'signal-positive',
            'signal-negative'
        );


        if (
            state === 'positive'
        ) {

            panel.classList.add(
                'signal-positive'
            );


            if (icon) {

                icon.innerHTML =
                    '<i class="fa-solid fa-arrow-trend-up"></i>';

            }


            if (dot) {

                dot.style.background =
                    '#16a34a';

            }

        } else if (
            state === 'negative'
        ) {

            panel.classList.add(
                'signal-negative'
            );


            if (icon) {

                icon.innerHTML =
                    '<i class="fa-solid fa-arrow-trend-down"></i>';

            }


            if (dot) {

                dot.style.background =
                    '#dc2626';

            }

        } else {

            if (icon) {

                icon.innerHTML =
                    '<i class="fa-solid fa-minus"></i>';

            }


            if (dot) {

                dot.style.background =
                    '#2563eb';

            }

        }

    }



    /* ==========================================================
       RESOURCE PRESSURE
    ========================================================== */

    function updateResources(
        projectedPopulation: number
    ): void {

        const populationGrowth =
            safeDivide(
                projectedPopulation -
                dbData.population,

                dbData.population
            ) * 100;


        const housing =
            Math.min(
                100,
                Math.max(
                    15,
                    30 +
                    populationGrowth * 4
                )
            );


        const education =
            Math.min(
                100,
                Math.max(
                    0,

                    safeDivide(
                        dbData.children,
                        dbData.population
                    ) * 200 +

                    populationGrowth * 2

                )
            );


        const healthcare =
            Math.min(
                100,
                Math.max(

                    0,

                    safeDivide(
                        dbData.seniors,
                        dbData.population
                    ) * 300 +

                    safeDivide(
                        dbData.chronic,
                        dbData.population
                    ) * 100

                )
            );


        const infrastructure =
            Math.min(
                100,
                Math.max(
                    0,
                    30 +
                    populationGrowth * 5
                )
            );


        setPressure(
            'housing',
            housing
        );


        setPressure(
            'education',
            education
        );


        setPressure(
            'health',
            healthcare
        );


        setPressure(
            'infrastructure',
            infrastructure
        );

    }



    /* ==========================================================
       PRESSURE DISPLAY
    ========================================================== */

    function setPressure(
        name: string,
        value: number
    ): void {

        let label: string;

        let state:
            'low' |
            'moderate' |
            'high';


        if (
            value >= 70
        ) {

            label =
                'High';


            state =
                'high';

        } else if (
            value >= 40
        ) {

            label =
                'Moderate';


            state =
                'moderate';

        } else {

            label =
                'Low';


            state =
                'low';

        }


        setText(
            name + 'Pressure',
            label
        );


        const bar =
            document.getElementById(
                name + 'Bar'
            ) as HTMLElement | null;


        const resource =
            document.getElementById(
                name + 'Resource'
            ) as HTMLElement | null;


        if (bar) {

            bar.style.width =
                Math.round(
                    value
                ) + '%';

        }


        if (resource) {

            resource.classList.remove(
                'resource-low',
                'resource-moderate',
                'resource-high'
            );


            resource.classList.add(
                'resource-' +
                state
            );

        }

    }



    /* ==========================================================
       AI INSIGHT
    ========================================================== */

    function generateInsight(
        forecast: ForecastResult,
        year: number
    ): void {

        const demographic =
            calculateDemographics();


        let trend: string;


        if (
            forecast.growth >= 3
        ) {

            trend =
                'strong population growth';

        } else if (
            forecast.growth >= 1
        ) {

            trend =
                'moderate population growth';

        } else if (
            forecast.growth >= 0
        ) {

            trend =
                'a relatively stable population';

        } else {

            trend =
                'a population decline';

        }


        let migrationMessage: string;


        if (
            demographic.netMigration > 0
        ) {

            migrationMessage =
                `Positive net migration of
                <strong class="text-success">
                    +${formatNumber(
                    demographic.netMigration
                )}
                </strong>
                is contributing to population expansion.`;

        } else if (
            demographic.netMigration < 0
        ) {

            migrationMessage =
                `Negative net migration of
                <strong class="text-danger">
                    ${formatNumber(
                    demographic.netMigration
                )}
                </strong>
                is reducing population growth.`;

        } else {

            migrationMessage =
                'Migration is currently balanced.';

        }


        const insightElement =
            document.getElementById(
                'aiInsight'
            ) as HTMLElement | null;


        if (!insightElement) return;


        insightElement.innerHTML =

            `The demographic analysis indicates ` +

            `<strong>${trend}</strong>. ` +

            `The current population of ` +

            `<strong>
                ${formatNumber(
                dbData.population
            )}
            </strong> ` +

            `is projected to reach approximately ` +

            `<strong>
                ${formatNumber(
                forecast.population
            )}
            </strong> ` +

            `by <strong>${year}</strong>. ` +

            `The estimated annual growth rate is ` +

            `<strong>
                ${formatDecimal(
                forecast.growth
            )}%
            </strong>. ` +

            `${migrationMessage}`;

    }



    /* ==========================================================
       FORECAST TABLE
    ========================================================== */

    function generateForecastTable(
        years: number
    ): void {

        const table =
            document.getElementById(
                'forecastTable'
            ) as HTMLElement | null;


        if (!table) return;


        table.innerHTML =
            '';


        let previousPopulation =
            dbData.population;


        for (
            let yearOffset = 1;
            yearOffset <= years;
            yearOffset++
        ) {

            const forecast =
                calculateForecast(
                    yearOffset
                );


            const year =
                Number(dbData.year) +
                yearOffset;


            const change =
                forecast.population -
                previousPopulation;


            let trendClass =
                'table-stable';


            let trendIcon =
                'fa-minus';


            if (
                change > 0
            ) {

                trendClass =
                    'table-positive';


                trendIcon =
                    'fa-arrow-trend-up';

            } else if (
                change < 0
            ) {

                trendClass =
                    'table-negative';


                trendIcon =
                    'fa-arrow-trend-down';

            }


            const row =
                document.createElement(
                    'tr'
                );


            row.innerHTML = `

                <td>

                    <div class="forecast-year-cell">

                        <div class="forecast-year-icon">

                            <i class="fa-solid ${trendIcon}"></i>

                        </div>

                        <strong>
                            ${year}
                        </strong>

                    </div>

                </td>


                <td>

                    <strong>

                        ${formatNumber(
                forecast.population
            )}

                    </strong>

                </td>


                <td class="${trendClass}">

                    ${change >= 0
                    ? '+'
                    : ''
                }

                    ${formatNumber(
                    change
                )}

                </td>


                <td class="${trendClass}">

                    ${formatDecimal(
                    forecast.growth
                )}%

                </td>


                <td>

                    <span class="forecast-badge">

                        <i class="fa-solid fa-brain"></i>

                        AI FORECAST

                    </span>

                </td>

            `;


            table.appendChild(
                row
            );


            previousPopulation =
                forecast.population;

        }

    }



    /* ==========================================================
       FORECAST CHART
       CURRENT YEAR + FUTURE ONLY
    ========================================================== */

    function updateForecastChart(
        years: number
    ): void {

        if (
            typeof Chart === 'undefined'
        ) {

            console.warn(
                'Chart.js is not loaded.'
            );

            return;

        }


        const canvas =
            document.getElementById(
                'populationChart'
            ) as HTMLCanvasElement | null;


        if (!canvas) return;


        const labels: number[] = [];

        const values: number[] = [];


        /*
         * Current population is the
         * starting point of the forecast.
         */

        const currentYear =
            Number(
                dbData.year
            );


        labels.push(
            currentYear
        );


        values.push(
            dbData.population
        );


        /*
         * Future projection.
         */

        for (
            let yearOffset = 1;
            yearOffset <= years;
            yearOffset++
        ) {

            labels.push(
                currentYear +
                yearOffset
            );


            values.push(
                calculateForecast(
                    yearOffset
                ).population
            );

        }


        /*
         * Destroy previous chart.
         */

        if (
            populationChart
        ) {

            populationChart.destroy();

        }


        const ctx =
            canvas.getContext(
                '2d'
            );


        if (!ctx) return;


        const gradient =
            ctx.createLinearGradient(
                0,
                0,
                0,
                320
            );


        gradient.addColorStop(
            0,
            'rgba(37,99,235,.20)'
        );


        gradient.addColorStop(
            1,
            'rgba(37,99,235,0)'
        );


        populationChart =
            new Chart(
                canvas,
                {

                    type: 'line',

                    data: {

                        labels,

                        datasets: [

                            {

                                label:
                                    'Projected Population',

                                data:
                                    values,

                                borderWidth: 3,

                                tension: 0.35,

                                pointRadius: 4,

                                pointHoverRadius: 7,

                                pointBackgroundColor:
                                    '#2563eb',

                                pointBorderColor:
                                    '#ffffff',

                                pointBorderWidth: 2,

                                fill: true,

                                backgroundColor:
                                    gradient,

                                borderColor:
                                    '#2563eb'

                            }

                        ]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        animation: {

                            duration: 1200,

                            easing: 'easeOutQuart'

                        },

                        plugins: {

                            legend: {

                                display: false

                            },

                            tooltip: {

                                callbacks: {

                                    label:
                                        function (
                                            context: any
                                        ) {

                                            return (
                                                ' Population: ' +
                                                Number(
                                                    context.raw
                                                ).toLocaleString()
                                            );

                                        }

                                }

                            }

                        },

                        scales: {

                            y: {

                                beginAtZero: false,

                                grid: {

                                    color:
                                        'rgba(100,116,139,.08)'

                                },

                                ticks: {

                                    callback:
                                        function (
                                            value: any
                                        ) {

                                            return Number(
                                                value
                                            ).toLocaleString();

                                        }

                                }

                            },

                            x: {

                                grid: {

                                    display: false

                                }

                            }

                        }

                    }

                }
            );

    }



    /* ==========================================================
       FORECAST COUNTER
    ========================================================== */

    function changeForecastYears(
        amount: number
    ): void {

        if (!forecastYears) return;


        const currentValue =
            Number(
                forecastYears.value
            );


        /*
         * If the current input is invalid,
         * start from 1 when pressing +,
         * or 1 when pressing -.
         */

        if (
            !Number.isFinite(currentValue) ||
            !Number.isInteger(currentValue)
        ) {

            if (amount > 0) {

                forecastYears.value =
                    '1';

            }


            showForecastYearsError(
                'Please enter a valid whole number between 1 and 100.'
            );


            return;

        }


        const newValue =
            currentValue +
            amount;


        /*
         * Do not silently clamp.
         */

        if (
            newValue < 1
        ) {

            showForecastYearsError(
                'Forecast period cannot be less than 1 year.'
            );


            return;

        }


        if (
            newValue > 100
        ) {

            showForecastYearsError(
                'Forecast period cannot exceed 100 years.'
            );


            return;

        }


        forecastYears.value =
            String(
                newValue
            );


        clearForecastYearsError();


        if (
            analysisComplete
        ) {

            updateForecast();

        }

    }



    /* ==========================================================
       COUNTER BUTTON EVENTS
    ========================================================== */

    if (
        forecastYearsDecrease
    ) {

        forecastYearsDecrease.addEventListener(
            'click',
            function () {

                changeForecastYears(
                    -1
                );

            }
        );

    }


    if (
        forecastYearsIncrease
    ) {

        forecastYearsIncrease.addEventListener(
            'click',
            function () {

                changeForecastYears(
                    1
                );

            }
        );

    }



    /* ==========================================================
       DIRECT INPUT VALIDATION
    ========================================================== */

    if (
        forecastYears
    ) {

        /*
         * Validate immediately while typing.
         */

        forecastYears.addEventListener(
            'input',
            function () {

                validateForecastYears();

            }
        );


        /*
         * Update forecast after leaving
         * the input.
         */

        forecastYears.addEventListener(
            'change',
            function () {

                if (
                    !analysisComplete
                ) {

                    validateForecastYears();

                    return;

                }


                const years =
                    validateForecastYears();


                if (
                    years === null
                ) {

                    return;

                }


                updateForecast();

            }
        );


        /*
         * Allow Enter to apply the forecast.
         */

        forecastYears.addEventListener(
            'keydown',
            function (
                event: KeyboardEvent
            ) {

                if (
                    event.key !== 'Enter'
                ) {

                    return;

                }


                event.preventDefault();


                if (
                    !analysisComplete
                ) {

                    validateForecastYears();

                    return;

                }


                const years =
                    validateForecastYears();


                if (
                    years === null
                ) {

                    return;

                }


                updateForecast();

            }
        );

    }



    /* ==========================================================
       ANALYZE BUTTON
    ========================================================== */

    if (
        analyzeButton
    ) {

        analyzeButton.addEventListener(
            'click',
            async function () {

                if (
                    analysisComplete ||
                    analyzeButton.disabled
                ) {

                    return;

                }


                /*
                 * Validate the default/current
                 * forecast period before analysis.
                 */

                const initialYears =
                    validateForecastYears();


                if (
                    initialYears === null
                ) {

                    return;

                }


                analyzeButton.disabled =
                    true;


                analyzeButton.classList.add(
                    'is-loading'
                );


                if (
                    analysisStatus
                ) {

                    analysisStatus.classList.remove(
                        'd-none'
                    );

                }


                updateProgress(
                    5
                );


                updateAnalysisStatus(
                    'Initializing AI demographic analysis...'
                );


                await delay(
                    600
                );


                updateProgress(
                    18
                );


                updateAnalysisStatus(
                    'Analyzing population structure...'
                );


                await delay(
                    650
                );


                updateProgress(
                    32
                );


                updateAnalysisStatus(
                    'Processing ten-year historical population records...'
                );


                await delay(
                    650
                );


                updateProgress(
                    45
                );


                updateAnalysisStatus(
                    'Calculating birth and mortality indicators...'
                );


                await delay(
                    650
                );


                updateProgress(
                    58
                );


                updateAnalysisStatus(
                    'Analyzing migration patterns...'
                );


                await delay(
                    650
                );


                updateProgress(
                    72
                );


                updateAnalysisStatus(
                    'Evaluating historical demographic trends...'
                );


                await delay(
                    650
                );


                updateProgress(
                    86
                );


                updateAnalysisStatus(
                    'Generating population forecast...'
                );


                await delay(
                    650
                );


                updateProgress(
                    96
                );


                updateAnalysisStatus(
                    'Preparing demographic intelligence...'
                );


                await delay(
                    500
                );


                updateProgress(
                    100
                );


                /*
                 * Analysis is complete.
                 */

                analysisComplete =
                    true;


                displayBasicData();


                generateHistoricalReport();


                updateHistoricalChart();


                /*
                 * Use the validated initial
                 * forecast period.
                 */

                if (
                    forecastYears
                ) {

                    forecastYears.value =
                        String(
                            initialYears
                        );

                }


                updateForecast();


                if (
                    analysisStatus
                ) {

                    analysisStatus.classList.add(
                        'd-none'
                    );

                }


                if (
                    aiControl
                ) {

                    aiControl.classList.add(
                        'ai-control-hide'
                    );


                    setTimeout(
                        function () {

                            if (
                                aiControl
                            ) {

                                aiControl.style.display =
                                    'none';

                            }

                        },
                        600
                    );

                }


                if (
                    analysisResults
                ) {

                    analysisResults.classList.remove(
                        'd-none'
                    );


                    requestAnimationFrame(
                        function () {

                            requestAnimationFrame(
                                function () {

                                    if (
                                        analysisResults
                                    ) {

                                        analysisResults.classList.add(
                                            'analysis-visible'
                                        );

                                    }

                                }
                            );

                        }
                    );

                }

            }
        );

    }

});