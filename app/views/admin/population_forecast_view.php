<?php

$population = $db_data['total_population'] ?? 0;
$households = $db_data['total_households'] ?? 0;
$male = $db_data['total_male'] ?? 0;
$female = $db_data['total_female'] ?? 0;
$births = $db_data['total_birth_records'] ?? 0;
$deaths = $db_data['total_death_records'] ?? 0;
$migrationIn = $db_data['total_migration_in_records'] ?? 0;
$migrationOut = $db_data['total_migration_out_records'] ?? 0;
$children = $db_data['total_children'] ?? 0;
$workingAge = $db_data['total_working_age'] ?? 0;
$seniors = $db_data['total_seniors'] ?? 0;
$employed = $db_data['total_employed'] ?? 0;
$averageIncome = $db_data['averageIncome'] ?? 0;
$pwd = $db_data['total_pwd'] ?? 0;
$chronic = $db_data['total_chronic_illness'] ?? 0;


/*
|--------------------------------------------------------------------------
| HISTORICAL POPULATION
|--------------------------------------------------------------------------
| Retrieved from Resident_Model through the controller.
|
| Expected structure:
|
| [
|     ['year' => 2016, 'population' => 1820],
|     ['year' => 2017, 'population' => 1845],
|     ...
| ]
|--------------------------------------------------------------------------
*/

$populationHistory = $db_data['population_history'] ?? [];


if (!is_array($populationHistory)) {
    $populationHistory = [];
}


/*
|--------------------------------------------------------------------------
| CURRENT YEAR
|--------------------------------------------------------------------------
*/

$currentYear = $db_data['year'] ?? (int) date('Y');


/*
|--------------------------------------------------------------------------
| CONVERT HISTORICAL DATA TO JSON
|--------------------------------------------------------------------------
*/

$populationHistoryJson = json_encode(
    $populationHistory,
    JSON_HEX_TAG |
    JSON_HEX_APOS |
    JSON_HEX_AMP |
    JSON_HEX_QUOT
);

?>

<section class="panel">

    <!-- ======================================================
         HEADER
    ======================================================= -->

    <header class="population-page-header">

        <div class="population-page-header-main">

            <div class="population-header-icon">
                <i class="fa-solid fa-chart-line"></i>
            </div>

            <div>

                <div class="population-header-eyebrow">
                    DEMOGRAPHIC ANALYTICS
                </div>

                <h2 class="population-page-title">
                    AI Population Intelligence
                </h2>

                <p class="population-page-subtitle">
                    Historical population analysis and demographic forecasting
                </p>

            </div>

        </div>


        <div class="population-header-badge">

            <span class="population-header-badge-dot"></span>

            AI-ASSISTED

        </div>

    </header>



    <div class="population-page-body">


        <!-- ==================================================
             01 — OVERVIEW
        =================================================== -->

        <section class="population-section population-section-overview">

            <div class="population-section-heading">

                <div class="population-section-number">
                    01
                </div>

                <div class="population-section-heading-content">

                    <div class="population-section-kicker">
                        OVERVIEW
                    </div>

                    <h3>
                        Current Demographic Snapshot
                    </h3>

                    <p>
                        A summary of the population and the primary demographic
                        components currently recorded in the barangay database.
                    </p>

                </div>

            </div>


            <div class="population-kpi-grid">

                <!-- Current Population -->

                <article class="population-kpi-card population-kpi-primary">

                    <div class="population-kpi-top">

                        <div class="population-kpi-icon blue">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <span class="population-kpi-tag">
                            BASELINE
                        </span>

                    </div>

                    <div class="population-kpi-label">
                        Current Population
                    </div>

                    <div class="population-kpi-value" id="currentPopulation">
                        —
                    </div>

                    <div class="population-kpi-meta">
                        <i class="fa-solid fa-circle-check"></i>
                        Active residents
                    </div>

                </article>


                <!-- Births -->

                <article class="population-kpi-card">

                    <div class="population-kpi-top">

                        <div class="population-kpi-icon green">
                            <i class="fa-solid fa-baby"></i>
                        </div>

                        <span class="population-kpi-tag">
                            NATURAL
                        </span>

                    </div>

                    <div class="population-kpi-label">
                        Birth Records
                    </div>

                    <div class="population-kpi-value" id="birthsValue">
                        —
                    </div>

                    <div class="population-kpi-meta">
                        <i class="fa-solid fa-calendar-days"></i>
                        Current year
                    </div>

                </article>


                <!-- Deaths -->

                <article class="population-kpi-card">

                    <div class="population-kpi-top">

                        <div class="population-kpi-icon red">
                            <i class="fa-solid fa-heart-crack"></i>
                        </div>

                        <span class="population-kpi-tag">
                            MORTALITY
                        </span>

                    </div>

                    <div class="population-kpi-label">
                        Death Records
                    </div>

                    <div class="population-kpi-value" id="deathsValue">
                        —
                    </div>

                    <div class="population-kpi-meta">
                        <i class="fa-solid fa-calendar-days"></i>
                        Current year
                    </div>

                </article>


                <!-- Migration -->

                <article class="population-kpi-card">

                    <div class="population-kpi-top">

                        <div class="population-kpi-icon blue" id="migrationIcon">
                            <i class="fa-solid fa-right-left"></i>
                        </div>

                        <span class="population-kpi-status neutral" id="migrationStatus">
                            <i class="fa-solid fa-minus"></i>
                            BALANCED
                        </span>

                    </div>

                    <div class="population-kpi-label">
                        Net Migration
                    </div>

                    <div class="population-kpi-value" id="migrationValue">
                        —
                    </div>

                    <div class="population-kpi-meta">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        In − Out
                    </div>

                </article>

            </div>

        </section>



        <!-- ==================================================
             AI ANALYSIS CONTROL
        =================================================== -->

        <section class="population-analysis-control" id="aiControl">

            <div class="population-analysis-content">

                <div class="population-analysis-icon">
                    <i class="fa-solid fa-brain"></i>
                </div>

                <div>

                    <div class="population-analysis-kicker">
                        AI DEMOGRAPHIC ANALYSIS
                    </div>

                    <h3>
                        Analyze Population Data
                    </h3>

                    <p>
                        Process historical records, demographic indicators,
                        migration patterns, and population trends to generate
                        the analytical report.
                    </p>

                </div>

            </div>


            <button type="button" class="population-analyze-button" id="analyzeButton">

                <span class="analyze-normal">

                    <i class="fa-solid fa-wand-magic-sparkles"></i>

                    Analyze Population

                </span>

                <span class="analyze-loading">

                    <span class="spinner-border spinner-border-sm"></span>

                    Analyzing...

                </span>

            </button>

        </section>



        <!-- ==================================================
             ANALYSIS STATUS
        =================================================== -->

        <div id="analysisStatus" class="population-analysis-status d-none">

            <div class="population-status-top">

                <div class="population-status-icon">
                    <i class="fa-solid fa-microchip"></i>
                </div>

                <div>

                    <div class="population-status-title">
                        Population analysis in progress
                    </div>

                    <div id="analysisStatusText" class="population-status-text">
                        Initializing demographic analysis...
                    </div>

                </div>

            </div>


            <div class="population-progress">

                <div id="analysisProgressBar" class="population-progress-bar" style="width: 0%;"></div>

            </div>

        </div>



        <!-- ==================================================
             ANALYSIS RESULTS
        =================================================== -->

        <div id="analysisResults" class="d-none">


            <!-- ==================================================
                 02 — HISTORY
            =================================================== -->

            <section class="population-section population-section-history">

                <div class="population-section-heading">

                    <div class="population-section-number">
                        02
                    </div>

                    <div class="population-section-heading-content">

                        <div class="population-section-kicker">
                            HISTORICAL POPULATION
                        </div>

                        <h3>
                            What Happened in the Past?
                        </h3>

                        <p>
                            Population records from the previous ten years,
                            including annual changes and historical growth.
                        </p>

                    </div>

                    <div class="population-section-label history">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        HISTORICAL DATA
                    </div>

                </div>



                <!-- Historical Summary -->

                <div class="historical-summary-grid">

                    <div class="historical-summary-card">

                        <div class="historical-summary-icon">
                            <i class="fa-solid fa-calendar"></i>
                        </div>

                        <div>

                            <span>
                                START YEAR
                            </span>

                            <strong id="historicalStartYear">
                                N/A
                            </strong>

                        </div>

                    </div>


                    <div class="historical-summary-card">

                        <div class="historical-summary-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div>

                            <span>
                                STARTING POPULATION
                            </span>

                            <strong id="historicalStartPopulation">
                                N/A
                            </strong>

                        </div>

                    </div>


                    <div class="historical-summary-card">

                        <div class="historical-summary-icon">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                        </div>

                        <div>

                            <span>
                                OVERALL CHANGE
                            </span>

                            <strong id="historicalChange">
                                N/A
                            </strong>

                        </div>

                    </div>

                </div>



                <!-- Historical Chart -->

                <div class="population-chart-card history-chart-card">

                    <div class="population-chart-header">

                        <div>

                            <div class="population-chart-kicker">
                                POPULATION TREND
                            </div>

                            <h4>
                                10-Year Population History
                            </h4>

                            <p>
                                Recorded population by year
                            </p>

                        </div>

                        <div class="population-chart-badge history">
                            <i class="fa-solid fa-database"></i>
                            HISTORICAL
                        </div>

                    </div>


                    <div class="chart-container historical-chart-container">

                        <canvas id="historicalPopulationChart"></canvas>

                    </div>

                </div>



                <!-- Historical Table -->

                <div class="population-data-card">

                    <div class="population-data-card-header">

                        <div>

                            <div class="population-chart-kicker">
                                HISTORICAL RECORD
                            </div>

                            <h4>
                                Ten-Year Historical Report
                            </h4>

                        </div>

                        <span class="population-record-count">
                            LAST 10 RECORDS
                        </span>

                    </div>


                    <div class="population-table-wrapper">

                        <table class="population-data-table">

                            <thead>

                                <tr>

                                    <th>Year</th>

                                    <th>Population</th>

                                    <th>Annual Change</th>

                                    <th>Growth</th>

                                    <th>Record Type</th>

                                </tr>

                            </thead>

                            <tbody id="historicalTable"></tbody>

                        </table>

                    </div>

                </div>

            </section>



            <!-- ==================================================
                 DIVIDER
            =================================================== -->

            <div class="population-section-divider">

                <span></span>

                <i class="fa-solid fa-chevron-down"></i>

                <span></span>

            </div>



            <!-- ==================================================
                 03 — FORECAST
            =================================================== -->

            <section class="population-section population-section-forecast">

                <div class="population-section-heading">

                    <div class="population-section-number">
                        03
                    </div>

                    <div class="population-section-heading-content">

                        <div class="population-section-kicker">
                            POPULATION FORECAST
                        </div>

                        <h3>
                            What May Happen in the Future?
                        </h3>

                        <p>
                            Adjust the forecast period and generate a projection
                            based on the current demographic conditions.
                        </p>

                    </div>

                    <div class="population-section-label forecast">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                        AI FORECAST
                    </div>

                </div>



                <!-- Forecast Control -->

                <div class="forecast-control-panel">

                    <div class="forecast-control-info">

                        <div class="forecast-control-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>

                        <div>

                            <div class="forecast-control-title">
                                Forecast Period
                            </div>

                            <div class="forecast-control-description">
                                Choose between 1 and 100 future years
                            </div>

                        </div>

                    </div>


                    <div class="forecast-control-right">

                        <div class="forecast-year-counter">

                            <button type="button" class="forecast-counter-btn" id="forecastYearsDecrease" aria-label="Decrease forecast years">
                                <i class="fa-solid fa-minus"></i>
                            </button>


                            <div class="forecast-year-input-wrapper">

                                <input type="number" id="forecastYears" class="forecast-year-input" value="5" min="1" max="100" step="1" inputmode="numeric" aria-label="Forecast years">

                                <span class="forecast-year-unit">
                                    years
                                </span>

                            </div>


                            <button type="button" class="forecast-counter-btn" id="forecastYearsIncrease" aria-label="Increase forecast years">
                                <i class="fa-solid fa-plus"></i>
                            </button>

                        </div>


                        <div id="forecastYearsError" class="forecast-years-error"></div>

                    </div>

                </div>



                <!-- Forecast Main Result -->

                <div class="forecast-result-grid">

                    <div class="forecast-main-card">

                        <div class="forecast-result-header">

                            <div>

                                <div class="forecast-result-kicker">
                                    PROJECTED POPULATION
                                </div>

                                <div class="forecast-result-label">
                                    Population at target year
                                </div>

                            </div>

                            <div id="forecastDirection" class="forecast-direction stable">
                                <i class="fa-solid fa-minus"></i>
                            </div>

                        </div>


                        <div id="forecastPopulation" class="forecast-population-number">
                            —
                        </div>


                        <div class="forecast-target">

                            <i class="fa-solid fa-bullseye"></i>

                            Target year:

                            <strong id="forecastYear">
                                —
                            </strong>

                        </div>


                        <div class="forecast-metric-grid">

                            <div class="forecast-metric">

                                <span>
                                    Annual Growth
                                </span>

                                <strong id="forecastGrowth" class="forecast-growth-value">
                                    —
                                </strong>

                                <small id="growthMeta">
                                    Based on demographic conditions
                                </small>

                            </div>


                            <div class="forecast-metric">

                                <span>
                                    Population Change
                                </span>

                                <strong id="forecastChange" class="forecast-change-value">
                                    —
                                </strong>

                                <small id="changeMeta">
                                    Compared with current population
                                </small>

                            </div>


                            <div class="forecast-metric">

                                <span>
                                    Model Confidence
                                </span>

                                <strong id="confidenceValue">
                                    —
                                </strong>

                                <small>
                                    Estimated model confidence
                                </small>

                            </div>

                        </div>

                    </div>



                    <!-- Signal -->

                    <div id="signalPanel" class="signal-panel">

                        <div class="signal-panel-header">

                            <div id="signalIcon" class="signal-icon">
                                <i class="fa-solid fa-minus"></i>
                            </div>

                            <span class="signal-panel-label">
                                DEMOGRAPHIC SIGNAL
                            </span>

                        </div>


                        <h4 id="populationSignal">
                            Stable
                        </h4>


                        <p id="populationSignalText">
                            The population is expected to remain relatively
                            stable over the selected forecast period.
                        </p>


                        <div class="signal-indicator">

                            <span id="signalIndicatorDot" class="signal-indicator-dot"></span>

                            <span id="signalIndicatorText">
                                Based on current demographic conditions
                            </span>

                        </div>

                    </div>

                </div>



                <!-- Forecast Chart -->

                <div class="population-chart-card forecast-chart-card">

                    <div class="population-chart-header">

                        <div>

                            <div class="population-chart-kicker">
                                FUTURE PROJECTION
                            </div>

                            <h4>
                                Future Population Projection
                            </h4>

                            <p>
                                Current population compared with projected future values
                            </p>

                        </div>

                        <div class="population-chart-badge forecast">
                            <i class="fa-solid fa-brain"></i>
                            AI FORECAST
                        </div>

                    </div>


                    <div class="chart-container forecast-chart-container">

                        <canvas id="populationChart"></canvas>

                    </div>

                </div>



                <!-- ==================================================
                     04 — INTERPRETATION
                =================================================== -->

                <section class="population-subsection population-interpretation-section">

                    <div class="population-subsection-heading">

                        <div class="population-subsection-icon interpretation">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>

                        <div>

                            <div class="population-subsection-kicker">
                                04 · INTERPRETATION
                            </div>

                            <h4>
                                AI-Assisted Demographic Interpretation
                            </h4>

                            <p>
                                A concise interpretation of the calculated
                                population trajectory.
                            </p>

                        </div>

                    </div>


                    <div id="aiInsight" class="ai-insight">
                        Analysis will appear here.
                    </div>

                </section>



                <!-- ==================================================
                     05 — DEMOGRAPHIC INDICATORS
                =================================================== -->

                <section class="population-subsection">

                    <div class="population-subsection-heading">

                        <div class="population-subsection-icon indicators">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>

                        <div>

                            <div class="population-subsection-kicker">
                                05 · DEMOGRAPHIC PROFILE
                            </div>

                            <h4>
                                Demographic Indicators
                            </h4>

                            <p>
                                Key indicators calculated from the current
                                demographic records.
                            </p>

                        </div>

                    </div>


                    <div class="demographic-indicator-grid">

                        <div class="demographic-indicator">

                            <div class="demographic-indicator-icon birth">
                                <i class="fa-solid fa-baby"></i>
                            </div>

                            <div>

                                <span>Birth Rate</span>

                                <strong id="birthRate">—</strong>

                                <small>
                                    per 1,000 population
                                </small>

                            </div>

                        </div>


                        <div class="demographic-indicator">

                            <div class="demographic-indicator-icon death">
                                <i class="fa-solid fa-heart-crack"></i>
                            </div>

                            <div>

                                <span>Death Rate</span>

                                <strong id="deathRate">—</strong>

                                <small>
                                    per 1,000 population
                                </small>

                            </div>

                        </div>


                        <div class="demographic-indicator">

                            <div class="demographic-indicator-icon migration">
                                <i class="fa-solid fa-right-left"></i>
                            </div>

                            <div>

                                <span>Migration Rate</span>

                                <strong id="migrationRate">—</strong>

                                <small>
                                    per 1,000 population
                                </small>

                            </div>

                        </div>


                        <div class="demographic-indicator">

                            <div class="demographic-indicator-icon dependency">
                                <i class="fa-solid fa-people-roof"></i>
                            </div>

                            <div>

                                <span>Dependency Ratio</span>

                                <strong id="dependencyRatio">—</strong>

                                <small>
                                    dependent / working age
                                </small>

                            </div>

                        </div>


                        <div class="demographic-indicator">

                            <div class="demographic-indicator-icon gender">
                                <i class="fa-solid fa-venus-mars"></i>
                            </div>

                            <div>

                                <span>Male Population</span>

                                <strong id="malePopulation">—</strong>

                                <small>
                                    share of population
                                </small>

                            </div>

                        </div>


                        <div class="demographic-indicator">

                            <div class="demographic-indicator-icon gender">
                                <i class="fa-solid fa-venus"></i>
                            </div>

                            <div>

                                <span>Female Population</span>

                                <strong id="femalePopulation">—</strong>

                                <small>
                                    share of population
                                </small>

                            </div>

                        </div>


                        <div class="demographic-indicator">

                            <div class="demographic-indicator-icon employment">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>

                            <div>

                                <span>Employment Rate</span>

                                <strong id="employmentRate">—</strong>

                                <small>
                                    working-age population
                                </small>

                            </div>

                        </div>


                        <div class="demographic-indicator">

                            <div class="demographic-indicator-icon household">
                                <i class="fa-solid fa-house-user"></i>
                            </div>

                            <div>

                                <span>Average Household Size</span>

                                <strong id="householdSize">—</strong>

                                <small>
                                    persons per household
                                </small>

                            </div>

                        </div>

                    </div>

                </section>



                <!-- ==================================================
                     06 — RESOURCE PRESSURE
                =================================================== -->

                <section class="population-subsection resource-pressure-section">

                    <div class="population-subsection-heading">

                        <div class="population-subsection-icon resources">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>

                        <div>

                            <div class="population-subsection-kicker">
                                06 · RESOURCE PRESSURE
                            </div>

                            <h4>
                                Projected Resource Pressure
                            </h4>

                            <p>
                                Estimated pressure on major public-service
                                areas based on projected population conditions.
                            </p>

                        </div>

                    </div>


                    <div class="resource-grid">

                        <!-- Housing -->

                        <div id="housingResource" class="resource resource-low">

                            <div class="resource-header">

                                <div class="resource-icon housing">
                                    <i class="fa-solid fa-house"></i>
                                </div>

                                <div>

                                    <strong>
                                        Housing
                                    </strong>

                                    <span>
                                        Residential demand
                                    </span>

                                </div>

                                <b id="housingPressure">
                                    Low
                                </b>

                            </div>


                            <div class="resource-progress">

                                <div id="housingBar" class="resource-progress-bar" style="width: 0%;"></div>

                            </div>

                        </div>


                        <!-- Education -->

                        <div id="educationResource" class="resource resource-low">

                            <div class="resource-header">

                                <div class="resource-icon education">
                                    <i class="fa-solid fa-school"></i>
                                </div>

                                <div>

                                    <strong>
                                        Education
                                    </strong>

                                    <span>
                                        Student-age demand
                                    </span>

                                </div>

                                <b id="educationPressure">
                                    Low
                                </b>

                            </div>


                            <div class="resource-progress">

                                <div id="educationBar" class="resource-progress-bar" style="width: 0%;"></div>

                            </div>

                        </div>


                        <!-- Healthcare -->

                        <div id="healthResource" class="resource resource-low">

                            <div class="resource-header">

                                <div class="resource-icon health">
                                    <i class="fa-solid fa-heart-pulse"></i>
                                </div>

                                <div>

                                    <strong>
                                        Healthcare
                                    </strong>

                                    <span>
                                        Health-service demand
                                    </span>

                                </div>

                                <b id="healthPressure">
                                    Low
                                </b>

                            </div>


                            <div class="resource-progress">

                                <div id="healthBar" class="resource-progress-bar" style="width: 0%;"></div>

                            </div>

                        </div>


                        <!-- Infrastructure -->

                        <div id="infrastructureResource" class="resource resource-low">

                            <div class="resource-header">

                                <div class="resource-icon infrastructure">
                                    <i class="fa-solid fa-road"></i>
                                </div>

                                <div>

                                    <strong>
                                        Infrastructure
                                    </strong>

                                    <span>
                                        General service demand
                                    </span>

                                </div>

                                <b id="infrastructurePressure">
                                    Low
                                </b>

                            </div>


                            <div class="resource-progress">

                                <div id="infrastructureBar" class="resource-progress-bar" style="width: 0%;"></div>

                            </div>

                        </div>

                    </div>

                </section>



                <!-- ==================================================
                     07 — FORECAST DETAILS
                =================================================== -->

                <section class="population-subsection forecast-details-section">

                    <div class="population-subsection-heading">

                        <div class="population-subsection-icon details">
                            <i class="fa-solid fa-table-list"></i>
                        </div>

                        <div>

                            <div class="population-subsection-kicker">
                                07 · FORECAST DETAILS
                            </div>

                            <h4>
                                Year-by-Year Projection
                            </h4>

                            <p>
                                Population estimates for every year in the
                                selected forecast period.
                            </p>

                        </div>

                    </div>


                    <div class="population-data-card forecast-table-card">

                        <div class="population-data-card-header">

                            <div>

                                <div class="population-chart-kicker">
                                    PROJECTION TABLE
                                </div>

                                <h4>
                                    Future Population Estimates
                                </h4>

                            </div>

                            <span class="population-record-count forecast">
                                AI GENERATED
                            </span>

                        </div>


                        <div class="population-table-wrapper">

                            <table class="population-data-table">

                                <thead>

                                    <tr>

                                        <th>Year</th>

                                        <th>Population</th>

                                        <th>Annual Change</th>

                                        <th>Growth</th>

                                        <th>Projection</th>

                                    </tr>

                                </thead>

                                <tbody id="forecastTable"></tbody>

                            </table>

                        </div>

                    </div>

                </section>

            </section>



            <!-- ==================================================
                 DATA SOURCE
            =================================================== -->

            <div class="population-data-source">

                <div class="population-data-source-icon">
                    <i class="fa-solid fa-database"></i>
                </div>

                <div>

                    <strong>
                        Data Source
                    </strong>

                    <span>
                        Actual demographic records retrieved from the
                        barangay database and processed by the AI-assisted
                        analytics system.
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>


<script>
    window.populationHistory = <?= $populationHistoryJson ?: '[]' ?>;
</script>