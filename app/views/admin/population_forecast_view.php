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
?>

<section class="panel">

    <!-- ========================================================== -->
    <!-- HEADER -->
    <!-- ========================================================== -->

    <div class="panel-header">

        <div class="ai-header">

            <div>
                <h5 class="mb-1">
                    <i class="fa-solid fa-wand-magic-sparkles me-2"></i>
                    AI Population Intelligence
                </h5>

                <small class="text-muted">
                    Population forecasting and demographic analysis
                </small>
            </div>

            <span class="ai-badge">
                <span class="ai-dot"></span>
                AI-ASSISTED
            </span>

        </div>

    </div>


    <div class="panel-body">

        <!-- ====================================================== -->
        <!-- AI INTRO -->
        <!-- ====================================================== -->

        <div class="ai-banner">

            <div class="ai-icon">
                <i class="fa-solid fa-brain"></i>
            </div>

            <div>
                <div class="ai-title">
                    Population Analysis Engine
                </div>

                <div class="ai-description">
                    Analyze demographic information to generate
                    population projections and planning insights.
                </div>
            </div>

            <div class="ai-banner-status">
                <i class="fa-solid fa-shield-halved"></i>
                DEMOGRAPHIC MODEL
            </div>

        </div>


        <!-- ====================================================== -->
        <!-- KPI CARDS -->
        <!-- ====================================================== -->

        <div class="row g-3 mt-1">

            <!-- CURRENT POPULATION -->

            <div class="col-md-3">

                <div class="ai-card population-card">

                    <div class="ai-card-top">

                        <div class="ai-card-label">
                            <i class="fa-solid fa-users"></i>
                            CURRENT POPULATION
                        </div>

                        <div class="kpi-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>

                    </div>

                    <div id="currentPopulation" class="ai-card-value">
                        --
                    </div>

                    <div class="ai-card-bottom">
                        <span class="ai-card-note">
                            Active residents
                        </span>

                        <span class="kpi-status neutral">
                            <i class="fa-solid fa-circle"></i>
                            BASELINE
                        </span>
                    </div>

                </div>

            </div>


            <!-- BIRTHS -->

            <div class="col-md-3">

                <div class="ai-card birth-card">

                    <div class="ai-card-top">

                        <div class="ai-card-label">
                            <i class="fa-solid fa-baby"></i>
                            BIRTHS
                        </div>

                        <div class="kpi-icon green">
                            <i class="fa-solid fa-baby"></i>
                        </div>

                    </div>

                    <div id="birthsValue" class="ai-card-value">
                        --
                    </div>

                    <div class="ai-card-bottom">

                        <span class="ai-card-note">
                            Current year
                        </span>

                        <span class="kpi-status positive">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                            NATURAL
                        </span>

                    </div>

                </div>

            </div>


            <!-- DEATHS -->

            <div class="col-md-3">

                <div class="ai-card death-card">

                    <div class="ai-card-top">

                        <div class="ai-card-label">
                            <i class="fa-solid fa-person"></i>
                            DEATHS
                        </div>

                        <div class="kpi-icon red">
                            <i class="fa-solid fa-person"></i>
                        </div>

                    </div>

                    <div id="deathsValue" class="ai-card-value">
                        --
                    </div>

                    <div class="ai-card-bottom">

                        <span class="ai-card-note">
                            Current year
                        </span>

                        <span class="kpi-status negative">
                            <i class="fa-solid fa-arrow-trend-down"></i>
                            MORTALITY
                        </span>

                    </div>

                </div>

            </div>


            <!-- MIGRATION -->

            <div class="col-md-3">

                <div class="ai-card migration-card">

                    <div class="ai-card-top">

                        <div class="ai-card-label">
                            <i class="fa-solid fa-right-left"></i>
                            NET MIGRATION
                        </div>

                        <div id="migrationIcon" class="kpi-icon blue">
                            <i class="fa-solid fa-right-left"></i>
                        </div>

                    </div>

                    <div id="migrationValue" class="ai-card-value">
                        --
                    </div>

                    <div class="ai-card-bottom">

                        <span class="ai-card-note">
                            In − Out
                        </span>

                        <span id="migrationStatus" class="kpi-status neutral">

                            <i class="fa-solid fa-circle"></i>
                            ANALYZING

                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- ====================================================== -->
        <!-- AI ANALYSIS CONTROL -->
        <!-- ====================================================== -->

        <div class="ai-control mt-4" id="aiControl">

            <div class="ai-control-content">

                <div class="ai-control-icon">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                </div>

                <div class="ai-control-text">

                    <div class="ai-control-title">

                        AI Demographic Analysis

                        <span class="ai-live-badge">
                            <span class="ai-live-dot"></span>
                            READY
                        </span>

                    </div>

                    <div class="ai-control-description">

                        Process the demographic dataset to generate population
                        forecasts, demographic indicators, and AI-assisted insights.

                    </div>

                </div>

            </div>

            <button type="button" id="analyzeButton" class="btn ai-analyze-btn">

                <span class="analyze-normal">

                    <i class="fa-solid fa-wand-magic-sparkles me-2"></i>

                    Analyze Data

                </span>

                <span class="analyze-loading">

                    <span class="ai-spinner"></span>

                    AI Analyzing...

                </span>

            </button>

        </div>


        <!-- ====================================================== -->
        <!-- AI PROCESSING -->
        <!-- ====================================================== -->

        <div id="analysisStatus" class="ai-status d-none mt-3">

            <div class="ai-loader">
                <i class="fa-solid fa-microchip"></i>
            </div>

            <div class="status-content">

                <strong>
                    AI Analysis Running
                </strong>

                <div id="analysisStatusText" class="small text-muted">

                    Initializing analysis...

                </div>

                <div class="analysis-progress">
                    <div id="analysisProgressBar"></div>
                </div>

            </div>

        </div>


        <!-- ====================================================== -->
        <!-- RESULTS -->
        <!-- ====================================================== -->

        <div id="analysisResults" class="d-none">

            <!-- ================================================== -->
            <!-- FORECAST -->
            <!-- ================================================== -->

            <div class="row g-3 mt-4">

                <div class="col-lg-8">

                    <div class="forecast-panel">

                        <div class="forecast-panel-header">

                            <div>

                                <div class="section-label">
                                    POPULATION PROJECTION
                                </div>

                                <h4 class="mb-0">
                                    AI Forecast
                                </h4>

                            </div>

                            <select id="forecastYears" class="form-select form-select-sm">

                                <option value="1">
                                    1 Year
                                </option>

                                <option value="2">
                                    2 Years
                                </option>

                                <option value="3">
                                    3 Years
                                </option>

                                <option value="4">
                                    4 Years
                                </option>

                                <option value="5" selected>
                                    5 Years
                                </option>

                            </select>

                        </div>


                        <div class="forecast-main">

                            <div class="forecast-number-row">

                                <div id="forecastPopulation" class="forecast-number">

                                    --

                                </div>

                                <div id="forecastDirection" class="forecast-direction">

                                    <i class="fa-solid fa-arrow-trend-up"></i>

                                </div>

                            </div>

                            <div class="forecast-label">

                                Estimated population by

                                <span id="forecastYear">
                                    --
                                </span>

                            </div>

                        </div>


                        <div class="forecast-meta">

                            <div id="growthMeta">

                                <span>
                                    <i class="fa-solid fa-chart-line"></i>
                                    Annual trend
                                </span>

                                <strong id="forecastGrowth">
                                    --
                                </strong>

                            </div>

                            <div id="changeMeta">

                                <span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                    Population change
                                </span>

                                <strong id="forecastChange">
                                    --
                                </strong>

                            </div>

                            <div>

                                <span>
                                    <i class="fa-solid fa-crosshairs"></i>
                                    Model confidence
                                </span>

                                <strong id="confidenceValue">
                                    --
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- DEMOGRAPHIC SIGNAL -->

                <div class="col-lg-4">

                    <div id="signalPanel" class="signal-panel">

                        <div class="signal-header">

                            <div class="section-label">
                                DEMOGRAPHIC SIGNAL
                            </div>

                            <div id="signalIcon" class="signal-icon">

                                <i class="fa-solid fa-chart-line"></i>

                            </div>

                        </div>

                        <div id="populationSignal" class="signal-value">

                            --

                        </div>

                        <div id="populationSignalText" class="signal-text">

                            --

                        </div>

                        <div class="signal-indicator">

                            <span id="signalIndicatorDot"></span>

                            <span id="signalIndicatorText">
                                AI MODEL ANALYSIS
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ================================================== -->
            <!-- CHART -->
            <!-- ================================================== -->

            <div class="chart-container mt-4">

                <div class="chart-header">

                    <div>

                        <div class="section-label">
                            PROJECTED POPULATION TREND
                        </div>

                        <small class="text-muted">
                            AI-generated demographic trajectory
                        </small>

                    </div>

                    <span class="chart-ai-badge">
                        <i class="fa-solid fa-brain"></i>
                        AI MODEL
                    </span>

                </div>

                <div class="chart-wrapper">

                    <canvas id="populationChart"></canvas>

                </div>

            </div>


            <!-- ================================================== -->
            <!-- AI INSIGHT -->
            <!-- ================================================== -->

            <div class="ai-insight mt-4">

                <div class="ai-insight-icon">
                    <i class="fa-solid fa-brain"></i>
                </div>

                <div class="ai-insight-content">

                    <div class="section-label">
                        AI-ASSISTED INTERPRETATION
                    </div>

                    <div id="aiInsight" class="ai-insight-text">

                        --

                    </div>

                </div>

                <div class="insight-tag">
                    <i class="fa-solid fa-sparkles"></i>
                    GENERATED
                </div>

            </div>


            <!-- ================================================== -->
            <!-- DEMOGRAPHIC INDICATORS -->
            <!-- ================================================== -->

            <div class="mt-4">

                <div class="section-label mb-3">
                    DEMOGRAPHIC INDICATORS
                </div>

                <div class="row g-3">

                    <div class="col-md-3">
                        <div class="indicator">
                            <div class="indicator-icon blue">
                                <i class="fa-solid fa-baby"></i>
                            </div>

                            <span>Birth Rate</span>

                            <strong id="birthRate">--</strong>

                            <small>per 1,000</small>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="indicator">
                            <div class="indicator-icon red">
                                <i class="fa-solid fa-heart-crack"></i>
                            </div>

                            <span>Death Rate</span>

                            <strong id="deathRate">--</strong>

                            <small>per 1,000</small>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="indicator">
                            <div class="indicator-icon purple">
                                <i class="fa-solid fa-right-left"></i>
                            </div>

                            <span>Migration Rate</span>

                            <strong id="migrationRate">--</strong>

                            <small>per 1,000</small>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="indicator">
                            <div class="indicator-icon orange">
                                <i class="fa-solid fa-people-arrows"></i>
                            </div>

                            <span>Dependency Ratio</span>

                            <strong id="dependencyRatio">--</strong>

                            <small>dependents / working age</small>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="indicator">
                            <div class="indicator-icon blue">
                                <i class="fa-solid fa-person"></i>
                            </div>

                            <span>Male Population</span>

                            <strong id="malePopulation">--</strong>

                            <small>percentage</small>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="indicator">
                            <div class="indicator-icon pink">
                                <i class="fa-solid fa-person-dress"></i>
                            </div>

                            <span>Female Population</span>

                            <strong id="femalePopulation">--</strong>

                            <small>percentage</small>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="indicator">
                            <div class="indicator-icon green">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>

                            <span>Employment Rate</span>

                            <strong id="employmentRate">--</strong>

                            <small>working age</small>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="indicator">
                            <div class="indicator-icon cyan">
                                <i class="fa-solid fa-house"></i>
                            </div>

                            <span>Avg. Household Size</span>

                            <strong id="householdSize">--</strong>

                            <small>persons</small>
                        </div>
                    </div>

                </div>

            </div>


            <!-- ================================================== -->
            <!-- RESOURCE PRESSURE -->
            <!-- ================================================== -->

            <div class="mt-4">

                <div class="section-label mb-3">
                    PROJECTED RESOURCE PRESSURE
                </div>

                <div class="resource-grid">

                    <div id="housingResource" class="resource">

                        <div class="resource-title">
                            <span>
                                <i class="fa-solid fa-house"></i>
                                Housing
                            </span>

                            <strong id="housingPressure">
                                --
                            </strong>
                        </div>

                        <div class="progress">
                            <div id="housingBar" class="progress-bar" style="width:0%">
                            </div>
                        </div>

                    </div>


                    <div id="educationResource" class="resource">

                        <div class="resource-title">
                            <span>
                                <i class="fa-solid fa-school"></i>
                                Education
                            </span>

                            <strong id="educationPressure">
                                --
                            </strong>
                        </div>

                        <div class="progress">
                            <div id="educationBar" class="progress-bar" style="width:0%">
                            </div>
                        </div>

                    </div>


                    <div id="healthResource" class="resource">

                        <div class="resource-title">
                            <span>
                                <i class="fa-solid fa-heart-pulse"></i>
                                Healthcare
                            </span>

                            <strong id="healthPressure">
                                --
                            </strong>
                        </div>

                        <div class="progress">
                            <div id="healthBar" class="progress-bar" style="width:0%">
                            </div>
                        </div>

                    </div>


                    <div id="infrastructureResource" class="resource">

                        <div class="resource-title">
                            <span>
                                <i class="fa-solid fa-road"></i>
                                Infrastructure
                            </span>

                            <strong id="infrastructurePressure">
                                --
                            </strong>
                        </div>

                        <div class="progress">
                            <div id="infrastructureBar" class="progress-bar" style="width:0%">
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            <!-- ================================================== -->
            <!-- TABLE -->
            <!-- ================================================== -->

            <div class="mt-4">

                <div class="section-label mb-3">
                    FORECAST DETAILS
                </div>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

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

        </div>


        <!-- ====================================================== -->
        <!-- SOURCE -->
        <!-- ====================================================== -->

        <div class="data-source mt-3">
            <i class="fa-solid fa-database me-2"></i>
            Data Source — Actual demographic records retrieved from the barangay database and processed by the AI-assisted analytics system.
        </div>
    </div>

</section>