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

<style>
    /* ================================================================
   COLOR SYSTEM
   ================================================================ */

    :root {

        --ai-blue: #2563eb;
        --ai-blue-light: #0ea5e9;

        --ai-green: #16a34a;
        --ai-green-light: #22c55e;

        --ai-red: #dc2626;
        --ai-red-light: #ef4444;

        --ai-orange: #ea580c;
        --ai-purple: #7c3aed;
        --ai-cyan: #0891b2;

        --ai-text: #1e293b;
        --ai-muted: #64748b;

    }


    /* ================================================================
   HEADER
   ================================================================ */

    .ai-header {

        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;

    }


    .ai-badge {

        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 5px 10px;

        border-radius: 20px;

        background: rgba(37, 99, 235, .08);

        border: 1px solid rgba(37, 99, 235, .16);

        color: var(--ai-blue);

        font-size: 10px;
        font-weight: 700;

        letter-spacing: .6px;

    }


    .ai-dot {

        width: 7px;
        height: 7px;

        border-radius: 50%;

        background: var(--ai-blue);

        animation: aiPulse 1.5s infinite;

    }


    @keyframes aiPulse {

        0%,
        100% {
            opacity: .4;
            transform: scale(.8);
        }

        50% {
            opacity: 1;
            transform: scale(1.15);
        }

    }


    /* ================================================================
   AI BANNER
   ================================================================ */

    .ai-banner {

        position: relative;

        display: flex;
        align-items: center;
        gap: 15px;

        padding: 17px;

        border-radius: 14px;

        background:
            linear-gradient(135deg,
                rgba(37, 99, 235, .07),
                rgba(14, 165, 233, .04),
                rgba(124, 58, 237, .05));

        border: 1px solid rgba(37, 99, 235, .12);

        overflow: hidden;

    }


    .ai-banner::after {

        content: "";

        position: absolute;

        width: 130px;
        height: 130px;

        right: 60px;
        top: -70px;

        border-radius: 50%;

        background: rgba(37, 99, 235, .06);

        filter: blur(15px);

    }


    .ai-icon {

        width: 48px;
        height: 48px;

        min-width: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 13px;

        background:
            linear-gradient(135deg,
                rgba(37, 99, 235, .14),
                rgba(14, 165, 233, .12));

        color: var(--ai-blue);

        font-size: 21px;

    }


    .ai-title {

        font-weight: 700;
        color: var(--ai-text);

    }


    .ai-description {

        color: var(--ai-muted);

        font-size: 13px;

        margin-top: 3px;

    }


    .ai-banner-status {

        position: relative;

        z-index: 2;

        margin-left: auto;

        display: flex;

        align-items: center;

        gap: 6px;

        padding: 7px 10px;

        border-radius: 8px;

        background: rgba(255, 255, 255, .7);

        border: 1px solid rgba(37, 99, 235, .1);

        color: var(--ai-blue);

        font-size: 9px;

        font-weight: 800;

        letter-spacing: .5px;

    }


    /* ================================================================
   KPI CARDS
   ================================================================ */

    .ai-card {

        position: relative;

        height: 100%;

        padding: 17px;

        border-radius: 13px;

        background: #fff;

        border: 1px solid rgba(0, 0, 0, .07);

        overflow: hidden;

        transition:
            transform .25s ease,
            box-shadow .25s ease,
            border-color .25s ease;

    }


    .ai-card::before {

        content: "";

        position: absolute;

        left: 0;
        top: 0;
        bottom: 0;

        width: 3px;

        background: var(--ai-blue);

        opacity: .8;

    }


    .ai-card:hover {

        transform: translateY(-4px);

        box-shadow:
            0 12px 28px rgba(15, 23, 42, .08);

        border-color: rgba(37, 99, 235, .15);

    }


    .ai-card-top {

        display: flex;

        align-items: center;

        justify-content: space-between;

    }


    .ai-card-label {

        display: flex;

        align-items: center;

        gap: 7px;

        color: var(--ai-muted);

        font-size: 10px;

        font-weight: 700;

        letter-spacing: .5px;

    }


    .ai-card-label i {

        color: var(--ai-blue);

    }


    .kpi-icon {

        width: 35px;
        height: 35px;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 9px;

        color: var(--ai-blue);

        background: rgba(37, 99, 235, .08);

    }


    .kpi-icon.green {

        color: var(--ai-green);

        background: rgba(22, 163, 74, .09);

    }


    .kpi-icon.red {

        color: var(--ai-red);

        background: rgba(220, 38, 38, .08);

    }


    .kpi-icon.blue {

        color: var(--ai-blue);

        background: rgba(37, 99, 235, .08);

    }


    .ai-card-value {

        margin-top: 10px;

        font-size: 28px;

        font-weight: 750;

        letter-spacing: -.5px;

        color: var(--ai-text);

        transition:
            color .3s ease,
            transform .3s ease;

    }


    .ai-card-value.value-positive {

        color: var(--ai-green);

        animation: valuePop .5s ease;

    }


    .ai-card-value.value-negative {

        color: var(--ai-red);

        animation: valuePop .5s ease;

    }


    @keyframes valuePop {

        0% {
            transform: scale(.92);
        }

        60% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }

    }


    .ai-card-bottom {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 5px;

        margin-top: 3px;

    }


    .ai-card-note {

        color: var(--ai-muted);

        font-size: 11px;

    }


    .kpi-status {

        display: inline-flex;

        align-items: center;

        gap: 4px;

        padding: 3px 6px;

        border-radius: 20px;

        font-size: 8px;

        font-weight: 800;

        letter-spacing: .3px;

    }


    .kpi-status.positive {

        color: #15803d;

        background: #f0fdf4;

    }


    .kpi-status.negative {

        color: #b91c1c;

        background: #fef2f2;

    }


    .kpi-status.neutral {

        color: #1d4ed8;

        background: #eff6ff;

    }


    /* ================================================================
   AI CONTROL
   ================================================================ */

    .ai-control {

        position: relative;

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 24px;

        padding: 22px 24px;

        border: 1px solid rgba(37, 99, 235, .15);

        border-radius: 17px;

        background:
            linear-gradient(135deg,
                rgba(255, 255, 255, .98),
                rgba(248, 250, 255, .96));

        box-shadow:
            0 8px 30px rgba(30, 41, 59, .05);

        overflow: hidden;

        transition:
            opacity .45s ease,
            transform .45s ease,
            max-height .5s ease,
            margin .5s ease,
            padding .5s ease;

    }


    .ai-control::before {

        content: "";

        position: absolute;

        width: 180px;
        height: 180px;

        top: -100px;
        right: 120px;

        background: rgba(37, 99, 235, .07);

        border-radius: 50%;

        filter: blur(25px);

    }


    .ai-control::after {

        content: "";

        position: absolute;

        top: 0;
        left: -100%;

        width: 40%;
        height: 2px;

        background:
            linear-gradient(90deg,
                transparent,
                #2563eb,
                #0ea5e9,
                transparent);

        animation: aiScanLine 4s linear infinite;

        opacity: .55;

    }


    @keyframes aiScanLine {

        0% {
            left: -40%;
        }

        100% {
            left: 140%;
        }

    }


    .ai-control-content {

        display: flex;

        align-items: center;

        gap: 16px;

        position: relative;

        z-index: 2;

    }


    .ai-control-icon {

        width: 50px;
        height: 50px;

        flex-shrink: 0;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 14px;

        color: #fff;

        background:
            linear-gradient(135deg,
                #2563eb,
                #0ea5e9);

        box-shadow:
            0 8px 20px rgba(37, 99, 235, .25);

        animation: aiIconFloat 3s ease-in-out infinite;

    }


    @keyframes aiIconFloat {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-3px);
        }

    }


    .ai-control-title {

        display: flex;

        align-items: center;

        gap: 10px;

        font-size: 16px;

        font-weight: 700;

        color: var(--ai-text);

    }


    .ai-control-description {

        margin-top: 4px;

        max-width: 700px;

        font-size: 13px;

        line-height: 1.5;

        color: var(--ai-muted);

    }


    .ai-live-badge {

        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 4px 8px;

        border-radius: 999px;

        font-size: 9px;

        font-weight: 800;

        letter-spacing: .5px;

        color: #15803d;

        background: #f0fdf4;

        border: 1px solid #bbf7d0;

    }


    .ai-live-dot {

        width: 6px;
        height: 6px;

        border-radius: 50%;

        background: #22c55e;

        animation: livePulse 1.8s ease-in-out infinite;

    }


    @keyframes livePulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: .45;
            transform: scale(.8);
        }

    }


    /* ================================================================
   ANALYZE BUTTON
   ================================================================ */

    .ai-analyze-btn {

        position: relative;

        z-index: 3;

        min-width: 165px;

        padding: 11px 18px;

        border: 0;

        border-radius: 11px;

        color: #fff;

        font-size: 13px;

        font-weight: 600;

        background:
            linear-gradient(135deg,
                #2563eb,
                #0ea5e9);

        box-shadow:
            0 7px 18px rgba(37, 99, 235, .25);

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            filter .2s ease;

    }


    .ai-analyze-btn:hover {

        color: #fff;

        transform: translateY(-2px);

        filter: brightness(1.06);

        box-shadow:
            0 10px 24px rgba(37, 99, 235, .35);

    }


    .ai-analyze-btn:disabled {

        cursor: not-allowed;

        opacity: .85;

    }


    .analyze-loading {

        display: none;

        align-items: center;

        justify-content: center;

        gap: 9px;

    }


    .ai-analyze-btn.is-loading .analyze-normal {
        display: none;
    }


    .ai-analyze-btn.is-loading .analyze-loading {
        display: inline-flex;
    }


    .ai-spinner {

        width: 15px;
        height: 15px;

        border: 2px solid rgba(255, 255, 255, .35);

        border-top-color: #fff;

        border-radius: 50%;

        animation: aiSpinner .7s linear infinite;

    }


    @keyframes aiSpinner {

        to {
            transform: rotate(360deg);
        }

    }


    /* ================================================================
   HIDE CONTROL
   ================================================================ */

    .ai-control.ai-control-hide {

        opacity: 0;

        transform:
            translateY(-18px) scale(.98);

        max-height: 0;

        margin-top: 0 !important;

        padding-top: 0;
        padding-bottom: 0;

        border-width: 0;

        pointer-events: none;

    }


    /* ================================================================
   STATUS
   ================================================================ */

    #analysisStatus {

        position: relative;

        display: flex;

        align-items: center;

        gap: 12px;

        padding: 15px;

        border-radius: 13px;

        border: 1px solid rgba(37, 99, 235, .15);

        background:
            linear-gradient(135deg,
                #f8faff,
                #f0f7ff);

        overflow: hidden;

    }


    .ai-loader {

        width: 40px;
        height: 40px;

        flex-shrink: 0;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: rgba(37, 99, 235, .1);

        color: var(--ai-blue);

        animation: aiRotate 1.3s linear infinite;

    }


    @keyframes aiRotate {

        to {
            transform: rotate(360deg);
        }

    }


    .status-content {

        flex: 1;

    }


    .analysis-progress {

        width: 100%;

        height: 4px;

        margin-top: 9px;

        overflow: hidden;

        border-radius: 20px;

        background: rgba(37, 99, 235, .08);

    }


    #analysisProgressBar {

        width: 0%;

        height: 100%;

        border-radius: 20px;

        background:
            linear-gradient(90deg,
                #2563eb,
                #0ea5e9);

        transition: width .5s ease;

    }


    /* ================================================================
   RESULTS ENTRANCE
   ================================================================ */

    #analysisResults {

        opacity: 0;

        transform: translateY(20px);

        transition:
            opacity .6s ease,
            transform .6s ease;

    }


    #analysisResults.analysis-visible {

        opacity: 1;

        transform: translateY(0);

    }


    /* ================================================================
   FORECAST PANEL
   ================================================================ */

    .forecast-panel {

        padding: 20px;

        border-radius: 13px;

        background: #fff;

        border: 1px solid rgba(0, 0, 0, .07);

        box-shadow:
            0 5px 18px rgba(15, 23, 42, .03);

    }


    .forecast-panel-header {

        display: flex;

        justify-content: space-between;

        align-items: center;

    }


    .forecast-panel-header select {

        width: 120px;

    }


    .forecast-main {

        margin-top: 28px;

    }


    .forecast-number-row {

        display: flex;

        align-items: center;

        gap: 13px;

    }


    .forecast-number {

        font-size: 42px;

        line-height: 1;

        font-weight: 750;

        color: var(--ai-blue);

        letter-spacing: -1px;

        transition: color .3s ease;

    }


    .forecast-number.growth-positive {

        color: var(--ai-green);

    }


    .forecast-number.growth-negative {

        color: var(--ai-red);

    }


    .forecast-direction {

        width: 38px;
        height: 38px;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 50%;

        font-size: 15px;

    }


    .forecast-direction.positive {

        color: var(--ai-green);

        background: rgba(22, 163, 74, .1);

    }


    .forecast-direction.negative {

        color: var(--ai-red);

        background: rgba(220, 38, 38, .1);

    }


    .forecast-direction.stable {

        color: var(--ai-blue);

        background: rgba(37, 99, 235, .1);

    }


    .forecast-label {

        margin-top: 8px;

        color: var(--ai-muted);

        font-size: 12px;

    }


    .forecast-meta {

        display: grid;

        grid-template-columns: repeat(3, 1fr);

        gap: 10px;

        margin-top: 25px;

    }


    .forecast-meta div {

        padding: 11px;

        border-radius: 9px;

        background: rgba(15, 23, 42, .025);

        border: 1px solid transparent;

        transition: .25s ease;

    }


    .forecast-meta div.meta-positive {

        background: rgba(22, 163, 74, .06);

        border-color: rgba(22, 163, 74, .12);

    }


    .forecast-meta div.meta-negative {

        background: rgba(220, 38, 38, .06);

        border-color: rgba(220, 38, 38, .12);

    }


    .forecast-meta span {

        display: block;

        color: var(--ai-muted);

        font-size: 10px;

    }


    .forecast-meta span i {

        margin-right: 4px;

    }


    .forecast-meta strong {

        display: block;

        margin-top: 4px;

        font-size: 15px;

    }


    /* ================================================================
   SIGNAL
   ================================================================ */

    .signal-panel {

        position: relative;

        height: 100%;

        padding: 20px;

        border-radius: 13px;

        background:
            linear-gradient(135deg,
                rgba(37, 99, 235, .07),
                rgba(14, 165, 233, .05));

        border: 1px solid rgba(37, 99, 235, .12);

        overflow: hidden;

        transition:
            background .35s ease,
            border-color .35s ease;

    }


    .signal-panel.signal-positive {

        background:
            linear-gradient(135deg,
                rgba(22, 163, 74, .08),
                rgba(34, 197, 94, .04));

        border-color: rgba(22, 163, 74, .15);

    }


    .signal-panel.signal-negative {

        background:
            linear-gradient(135deg,
                rgba(220, 38, 38, .08),
                rgba(239, 68, 68, .04));

        border-color: rgba(220, 38, 38, .15);

    }


    .signal-header {

        display: flex;

        align-items: center;

        justify-content: space-between;

    }


    .signal-icon {

        width: 34px;
        height: 34px;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 9px;

        color: var(--ai-blue);

        background: rgba(37, 99, 235, .1);

    }


    .signal-value {

        margin-top: 20px;

        font-size: 25px;

        font-weight: 750;

        color: var(--ai-blue);

    }


    .signal-positive .signal-value {

        color: var(--ai-green);

    }


    .signal-negative .signal-value {

        color: var(--ai-red);

    }


    .signal-text {

        margin-top: 8px;

        color: var(--ai-muted);

        font-size: 13px;

        line-height: 1.6;

    }


    .signal-indicator {

        display: flex;

        align-items: center;

        gap: 7px;

        margin-top: 20px;

        color: var(--ai-muted);

        font-size: 9px;

        font-weight: 700;

        letter-spacing: .4px;

    }


    #signalIndicatorDot {

        width: 7px;
        height: 7px;

        border-radius: 50%;

        background: var(--ai-blue);

    }


    /* ================================================================
   CHART
   ================================================================ */

    .chart-container {

        padding: 18px;

        border-radius: 12px;

        border: 1px solid rgba(0, 0, 0, .07);

        background: #fff;

    }


    .chart-header {

        display: flex;

        justify-content: space-between;

        align-items: center;

    }


    .chart-ai-badge {

        display: inline-flex;

        align-items: center;

        gap: 5px;

        padding: 5px 8px;

        border-radius: 7px;

        color: var(--ai-blue);

        background: rgba(37, 99, 235, .07);

        font-size: 9px;

        font-weight: 800;

    }


    .chart-wrapper {

        position: relative;

        height: 320px;

        margin-top: 8px;

    }


    /* ================================================================
   AI INSIGHT
   ================================================================ */

    .ai-insight {

        position: relative;

        display: flex;

        gap: 14px;

        padding: 18px;

        border-radius: 12px;

        background:
            linear-gradient(135deg,
                rgba(37, 99, 235, .06),
                rgba(124, 58, 237, .05));

        border: 1px solid rgba(37, 99, 235, .12);

        overflow: hidden;

    }


    .ai-insight-icon {

        width: 42px;
        height: 42px;

        min-width: 42px;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: rgba(37, 99, 235, .1);

        color: var(--ai-blue);

    }


    .ai-insight-content {

        flex: 1;

    }


    .ai-insight-text {

        margin-top: 5px;

        line-height: 1.7;

        font-size: 13px;

    }


    .insight-tag {

        align-self: flex-start;

        display: flex;

        align-items: center;

        gap: 5px;

        padding: 5px 8px;

        border-radius: 7px;

        color: var(--ai-purple);

        background: rgba(124, 58, 237, .07);

        font-size: 8px;

        font-weight: 800;

    }


    /* ================================================================
   INDICATORS
   ================================================================ */

    .indicator {

        position: relative;

        padding: 14px;

        min-height: 105px;

        border-radius: 10px;

        background: rgba(15, 23, 42, .025);

        border: 1px solid transparent;

        transition:
            transform .2s ease,
            border-color .2s ease,
            background .2s ease;

    }


    .indicator:hover {

        transform: translateY(-2px);

        border-color: rgba(37, 99, 235, .1);

        background: rgba(37, 99, 235, .025);

    }


    .indicator-icon {

        width: 29px;
        height: 29px;

        display: flex;

        align-items: center;
        justify-content: center;

        margin-bottom: 9px;

        border-radius: 8px;

        font-size: 12px;

    }


    .indicator-icon.blue {

        color: var(--ai-blue);

        background: rgba(37, 99, 235, .1);

    }


    .indicator-icon.green {

        color: var(--ai-green);

        background: rgba(22, 163, 74, .1);

    }


    .indicator-icon.red {

        color: var(--ai-red);

        background: rgba(220, 38, 38, .1);

    }


    .indicator-icon.purple {

        color: var(--ai-purple);

        background: rgba(124, 58, 237, .1);

    }


    .indicator-icon.orange {

        color: var(--ai-orange);

        background: rgba(234, 88, 12, .1);

    }


    .indicator-icon.pink {

        color: #db2777;

        background: rgba(219, 39, 119, .1);

    }


    .indicator-icon.cyan {

        color: var(--ai-cyan);

        background: rgba(8, 145, 178, .1);

    }


    .indicator span {

        display: block;

        color: var(--ai-muted);

        font-size: 11px;

    }


    .indicator strong {

        display: block;

        margin-top: 4px;

        font-size: 21px;

        color: var(--ai-text);

    }


    .indicator small {

        color: var(--ai-muted);

        font-size: 9px;

    }


    /* ================================================================
   RESOURCE PRESSURE
   ================================================================ */

    .resource-grid {

        display: grid;

        grid-template-columns: repeat(4, 1fr);

        gap: 12px;

    }


    .resource {

        padding: 14px;

        border-radius: 10px;

        border: 1px solid rgba(0, 0, 0, .07);

        background: #fff;

        transition: .25s ease;

    }


    .resource.resource-low {

        border-color: rgba(22, 163, 74, .15);

        background: rgba(22, 163, 74, .025);

    }


    .resource.resource-moderate {

        border-color: rgba(234, 88, 12, .15);

        background: rgba(234, 88, 12, .025);

    }


    .resource.resource-high {

        border-color: rgba(220, 38, 38, .18);

        background: rgba(220, 38, 38, .025);

    }


    .resource-title {

        display: flex;

        justify-content: space-between;

        align-items: center;

        font-size: 12px;

    }


    .resource-title span {

        color: var(--ai-text);

    }


    .resource-title span i {

        margin-right: 5px;

        color: var(--ai-blue);

    }


    .resource strong {

        color: var(--ai-blue);

        transition: color .25s ease;

    }


    .resource-low strong {

        color: var(--ai-green);

    }


    .resource-moderate strong {

        color: var(--ai-orange);

    }


    .resource-high strong {

        color: var(--ai-red);

    }


    .progress {

        height: 7px;

        margin-top: 10px;

        background: #eef2f7;

        border-radius: 20px;

        overflow: hidden;

    }


    .progress-bar {

        border-radius: 20px;

        background:
            linear-gradient(90deg,
                #2563eb,
                #0ea5e9);

        transition:
            width .8s ease,
            background .3s ease;

    }


    .resource-low .progress-bar {

        background:
            linear-gradient(90deg,
                #16a34a,
                #22c55e);

    }


    .resource-moderate .progress-bar {

        background:
            linear-gradient(90deg,
                #ea580c,
                #f59e0b);

    }


    .resource-high .progress-bar {

        background:
            linear-gradient(90deg,
                #dc2626,
                #ef4444);

    }


    /* ================================================================
   TABLE
   ================================================================ */

    #forecastTable td {

        font-size: 13px;

    }


    .forecast-year-cell {

        display: flex;

        align-items: center;

        gap: 7px;

    }


    .forecast-year-icon {

        width: 27px;
        height: 27px;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 7px;

        color: var(--ai-blue);

        background: rgba(37, 99, 235, .08);

        font-size: 10px;

    }


    .table-positive {

        color: var(--ai-green) !important;

        font-weight: 700;

    }


    .table-negative {

        color: var(--ai-red) !important;

        font-weight: 700;

    }


    .table-stable {

        color: var(--ai-blue) !important;

        font-weight: 700;

    }


    .forecast-badge {

        display: inline-flex;

        align-items: center;

        gap: 4px;

        padding: 5px 8px;

        border-radius: 10px;

        background: rgba(37, 99, 235, .08);

        color: var(--ai-blue);

        font-size: 9px;

        font-weight: 700;

    }


    /* ================================================================
   DATA SOURCE
   ================================================================ */

    .data-source {

        padding: 11px 14px;

        border-radius: 8px;

        background: rgba(0, 0, 0, .025);

        color: var(--ai-muted);

        font-size: 11px;

    }


    /* ================================================================
   SECTION LABEL
   ================================================================ */

    .section-label {

        color: #64748b;

        font-size: 10px;

        font-weight: 800;

        letter-spacing: .7px;

    }


    /* ================================================================
   RESPONSIVE
   ================================================================ */

    @media(max-width:768px) {

        .ai-banner-status {
            display: none;
        }

        .ai-badge {
            display: none;
        }

        .ai-control {
            flex-direction: column;
            align-items: stretch;
        }

        .ai-control-content {
            align-items: flex-start;
        }

        .ai-analyze-btn {
            width: 100%;
        }

        .ai-control-title {
            flex-wrap: wrap;
        }

        .forecast-meta {
            grid-template-columns: 1fr;
        }

        .forecast-number {
            font-size: 34px;
        }

        .chart-wrapper {
            height: 260px;
        }

        .resource-grid {
            grid-template-columns: 1fr 1fr;
        }

        .ai-insight {
            flex-wrap: wrap;
        }

    }


    @media(max-width:480px) {

        .resource-grid {
            grid-template-columns: 1fr;
        }

        .ai-card-bottom {
            align-items: flex-start;
            flex-direction: column;
        }

    }
</style>

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /* ==========================================================
               DATABASE DATA
               ========================================================== */

            const dbData = {

                year: new Date().getFullYear(),

                population: <?= $population ?>,

                households: <?= $households ?>,

                male: <?= $male ?>,

                female: <?= $female ?>,

                births: <?= $births ?>,

                deaths: <?= $deaths ?>,

                migrationIn: <?= $migrationIn ?>,

                migrationOut: <?= $migrationOut ?>,

                children: <?= $children ?>,

                workingAge: <?= $workingAge ?>,

                seniors: <?= $seniors ?>,

                employed: <?= $employed ?>,

                averageIncome: <?= $averageIncome ?>,

                pwd: <?= $pwd ?>,

                chronic: <?= $chronic ?>

            };


            /* ==========================================================
               STATE
               ========================================================== */

            let analysisComplete = false;

            let populationChart = null;


            /* ==========================================================
               ELEMENTS
               ========================================================== */

            const analyzeButton =
                document.getElementById('analyzeButton');

            const aiControl =
                document.getElementById('aiControl');

            const analysisStatus =
                document.getElementById('analysisStatus');

            const analysisStatusText =
                document.getElementById('analysisStatusText');

            const analysisProgressBar =
                document.getElementById('analysisProgressBar');

            const analysisResults =
                document.getElementById('analysisResults');

            const forecastYears =
                document.getElementById('forecastYears');


            /* ==========================================================
               HELPERS
               ========================================================== */

            function formatNumber(value) {

                return Math.round(value).toLocaleString();

            }


            function formatDecimal(value, decimals = 2) {

                return Number(value).toFixed(decimals);

            }


            function delay(milliseconds) {

                return new Promise(
                    function (resolve) {

                        setTimeout(
                            resolve,
                            milliseconds
                        );

                    }
                );

            }


            function setText(id, value) {

                const element =
                    document.getElementById(id);

                if (element) {

                    element.textContent = value;

                }

            }


            function updateAnalysisStatus(message) {

                if (analysisStatusText) {

                    analysisStatusText.textContent =
                        message;

                }

            }


            function updateProgress(value) {

                if (analysisProgressBar) {

                    analysisProgressBar.style.width =
                        value + '%';

                }

            }


            /* ==========================================================
               DEMOGRAPHICS
               ========================================================== */

            function calculateDemographics() {

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
                    (
                        totalChange /
                        dbData.population
                    ) * 100;


                const birthRate =
                    (
                        dbData.births /
                        dbData.population
                    ) * 1000;


                const deathRate =
                    (
                        dbData.deaths /
                        dbData.population
                    ) * 1000;


                const migrationRate =
                    (
                        netMigration /
                        dbData.population
                    ) * 1000;


                const dependencyRatio =
                    (
                        (
                            dbData.children +
                            dbData.seniors
                        ) /
                        dbData.workingAge
                    ) * 100;


                const employmentRate =
                    (
                        dbData.employed /
                        dbData.workingAge
                    ) * 100;


                const malePercentage =
                    (
                        dbData.male /
                        dbData.population
                    ) * 100;


                const femalePercentage =
                    (
                        dbData.female /
                        dbData.population
                    ) * 100;


                const householdSize =
                    dbData.population /
                    dbData.households;


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

            function calculateForecast(years) {

                const demographic =
                    calculateDemographics();


                let annualGrowth =
                    demographic.growthRate;


                /*
                 * Demographic adjustment
                 */

                if (
                    demographic.dependencyRatio > 60
                ) {

                    annualGrowth *= .96;

                }

                else if (
                    demographic.dependencyRatio < 40
                ) {

                    annualGrowth *= 1.02;

                }


                /*
                 * Positive migration momentum
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
                        1 + annualGrowth / 100,
                        years
                    );


                return {

                    population:
                        Math.round(population),

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

            function displayBasicData() {

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
                    );


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

                    }

                    else if (
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

            function updateMigrationStatus(value) {

                const status =
                    document.getElementById(
                        'migrationStatus'
                    );


                const icon =
                    document.getElementById(
                        'migrationIcon'
                    );


                if (!status) {
                    return;
                }


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

                }

                else if (value < 0) {

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

                }

                else {

                    status.classList.add(
                        'neutral'
                    );

                    status.innerHTML =
                        '<i class="fa-solid fa-minus"></i> BALANCED';

                }

            }


            /* ==========================================================
               FORECAST UPDATE
               ========================================================== */

            function updateForecast() {

                if (!analysisComplete) {

                    return;

                }


                let years = 1;


                if (forecastYears) {

                    years =
                        Number(
                            forecastYears.value
                        ) || 1;

                }


                const forecast =
                    calculateForecast(years);


                const targetYear =
                    dbData.year +
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


                generateForecastTable();


                updateChart();

            }


            /* ==========================================================
               FORECAST DIRECTION
               ========================================================== */

            function updateForecastDirection(growth) {

                const number =
                    document.getElementById(
                        'forecastPopulation'
                    );


                const direction =
                    document.getElementById(
                        'forecastDirection'
                    );


                if (!number || !direction) {
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


                if (growth > .1) {

                    number.classList.add(
                        'growth-positive'
                    );

                    direction.classList.add(
                        'positive'
                    );

                    direction.innerHTML =
                        '<i class="fa-solid fa-arrow-trend-up"></i>';

                }

                else if (growth < -.1) {

                    number.classList.add(
                        'growth-negative'
                    );

                    direction.classList.add(
                        'negative'
                    );

                    direction.innerHTML =
                        '<i class="fa-solid fa-arrow-trend-down"></i>';

                }

                else {

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
                growth,
                change
            ) {

                const growthMeta =
                    document.getElementById(
                        'growthMeta'
                    );


                const changeMeta =
                    document.getElementById(
                        'changeMeta'
                    );


                if (growthMeta) {

                    growthMeta.classList.remove(
                        'meta-positive',
                        'meta-negative'
                    );


                    if (growth > 0) {

                        growthMeta.classList.add(
                            'meta-positive'
                        );

                    }

                    else if (growth < 0) {

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


                    if (change > 0) {

                        changeMeta.classList.add(
                            'meta-positive'
                        );

                    }

                    else if (change < 0) {

                        changeMeta.classList.add(
                            'meta-negative'
                        );

                    }

                }

            }


            /* ==========================================================
               CONFIDENCE
               ========================================================== */

            function calculateConfidence(years) {

                let confidence =
                    93 -
                    (
                        (years - 1) * 2
                    );


                confidence =
                    Math.max(
                        82,
                        Math.min(
                            confidence,
                            93
                        )
                    );


                return confidence;

            }


            /* ==========================================================
               DEMOGRAPHIC SIGNAL
               ========================================================== */

            function updateSignal(growth) {

                let title;

                let description;

                let state;


                if (growth >= 3) {

                    title =
                        'Strong Growth';

                    description =
                        'The population is projected to grow rapidly, which may increase demand for public services, housing and infrastructure.';

                    state =
                        'positive';

                }

                else if (growth >= 1) {

                    title =
                        'Moderate Growth';

                    description =
                        'The population is showing a steady upward trajectory based on the current demographic conditions.';

                    state =
                        'positive';

                }

                else if (growth >= 0) {

                    title =
                        'Stable';

                    description =
                        'The population is expected to remain relatively stable over the selected forecast period.';

                    state =
                        'stable';

                }

                else {

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
                    );


                const icon =
                    document.getElementById(
                        'signalIcon'
                    );


                const dot =
                    document.getElementById(
                        'signalIndicatorDot'
                    );


                if (!panel) {
                    return;
                }


                panel.classList.remove(
                    'signal-positive',
                    'signal-negative'
                );


                if (state === 'positive') {

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

                }

                else if (state === 'negative') {

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

                }

                else {

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
                projectedPopulation
            ) {

                const populationGrowth =
                    (
                        (
                            projectedPopulation -
                            dbData.population
                        ) /
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

                            (
                                dbData.children /
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

                            (
                                dbData.seniors /
                                dbData.population
                            ) * 300 +

                            (
                                dbData.chronic /
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
                name,
                value
            ) {

                let label;

                let state;


                if (value >= 70) {

                    label = 'High';

                    state = 'high';

                }

                else if (value >= 40) {

                    label = 'Moderate';

                    state = 'moderate';

                }

                else {

                    label = 'Low';

                    state = 'low';

                }


                setText(
                    name + 'Pressure',
                    label
                );


                const bar =
                    document.getElementById(
                        name + 'Bar'
                    );


                const resource =
                    document.getElementById(
                        name + 'Resource'
                    );


                if (bar) {

                    bar.style.width =
                        Math.round(value) + '%';

                }


                if (resource) {

                    resource.classList.remove(
                        'resource-low',
                        'resource-moderate',
                        'resource-high'
                    );


                    resource.classList.add(
                        'resource-' + state
                    );

                }

            }


            /* ==========================================================
               AI INSIGHT
               ========================================================== */

            function generateInsight(
                forecast,
                year
            ) {

                const demographic =
                    calculateDemographics();


                let trend;


                if (forecast.growth >= 3) {

                    trend =
                        'strong population growth';

                }

                else if (forecast.growth >= 1) {

                    trend =
                        'moderate population growth';

                }

                else if (forecast.growth >= 0) {

                    trend =
                        'a relatively stable population';

                }

                else {

                    trend =
                        'a population decline';

                }


                let migrationMessage;


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

                }

                else if (
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

                }

                else {

                    migrationMessage =
                        'Migration is currently balanced.';

                }


                const insightElement =
                    document.getElementById(
                        'aiInsight'
                    );


                if (!insightElement) {
                    return;
                }


                insightElement.innerHTML =

                    `The demographic analysis indicates ` +

                    `<strong>${trend}</strong>. ` +

                    `The current population of ` +

                    `<strong>${formatNumber(
                        dbData.population
                    )}</strong> ` +

                    `is projected to reach approximately ` +

                    `<strong>${formatNumber(
                        forecast.population
                    )}</strong> ` +

                    `by <strong>${year}</strong>. ` +

                    `The estimated annual growth rate is ` +

                    `<strong>${formatDecimal(
                        forecast.growth
                    )}%</strong>. ` +

                    `${migrationMessage}`;

            }


            /* ==========================================================
               FORECAST TABLE
               ========================================================== */

            function generateForecastTable() {

                const table =
                    document.getElementById(
                        'forecastTable'
                    );


                if (!table) {
                    return;
                }


                table.innerHTML = '';


                let previousPopulation =
                    dbData.population;


                for (
                    let yearOffset = 1;
                    yearOffset <= 5;
                    yearOffset++
                ) {

                    const forecast =
                        calculateForecast(
                            yearOffset
                        );


                    const year =
                        dbData.year +
                        yearOffset;


                    const change =
                        forecast.population -
                        previousPopulation;


                    let trendClass =
                        'table-stable';

                    let trendIcon =
                        'fa-minus';


                    if (change > 0) {

                        trendClass =
                            'table-positive';

                        trendIcon =
                            'fa-arrow-trend-up';

                    }

                    else if (change < 0) {

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

                        ${change >= 0 ? '+' : ''}

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
               CHART
               ========================================================== */

            function updateChart() {

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
                    );


                if (!canvas) {
                    return;
                }


                const labels = [

                    dbData.year,

                    dbData.year + 1,

                    dbData.year + 2,

                    dbData.year + 3,

                    dbData.year + 4,

                    dbData.year + 5

                ];


                const values = [

                    dbData.population,

                    calculateForecast(1).population,

                    calculateForecast(2).population,

                    calculateForecast(3).population,

                    calculateForecast(4).population,

                    calculateForecast(5).population

                ];


                if (populationChart) {

                    populationChart.destroy();

                }


                const ctx =
                    canvas.getContext('2d');


                /*
                 * Gradient for the chart.
                 */

                let gradient =
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

                                labels: labels,

                                datasets: [

                                    {

                                        label:
                                            'Population',

                                        data:
                                            values,

                                        borderWidth:
                                            3,

                                        tension:
                                            .35,

                                        pointRadius:
                                            4,

                                        pointHoverRadius:
                                            7,

                                        pointBackgroundColor:
                                            '#2563eb',

                                        pointBorderColor:
                                            '#ffffff',

                                        pointBorderWidth:
                                            2,

                                        fill:
                                            true,

                                        backgroundColor:
                                            gradient,

                                        borderColor:
                                            '#2563eb'

                                    }

                                ]

                            },


                            options: {

                                responsive:
                                    true,

                                maintainAspectRatio:
                                    false,

                                animation: {

                                    duration:
                                        1200,

                                    easing:
                                        'easeOutQuart'

                                },


                                plugins: {

                                    legend: {

                                        display:
                                            false

                                    },

                                    tooltip: {

                                        callbacks: {

                                            label:
                                                function (
                                                    context
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

                                        beginAtZero:
                                            false,

                                        grid: {

                                            color:
                                                'rgba(100,116,139,.08)'

                                        },

                                        ticks: {

                                            callback:
                                                function (
                                                    value
                                                ) {

                                                    return Number(
                                                        value
                                                    ).toLocaleString();

                                                }

                                        }

                                    },


                                    x: {

                                        grid: {

                                            display:
                                                false

                                        }

                                    }

                                }

                            }

                        }
                    );

            }


            /* ==========================================================
               ANALYZE BUTTON
               ========================================================== */

            if (analyzeButton) {

                analyzeButton.addEventListener(
                    'click',
                    async function () {

                        if (
                            analysisComplete ||
                            analyzeButton.disabled
                        ) {

                            return;

                        }


                        analyzeButton.disabled =
                            true;


                        analyzeButton.classList.add(
                            'is-loading'
                        );


                        if (analysisStatus) {

                            analysisStatus.classList.remove(
                                'd-none'
                            );

                        }


                        updateProgress(5);


                        updateAnalysisStatus(
                            'Initializing AI demographic analysis...'
                        );


                        await delay(600);

                        updateProgress(18);

                        updateAnalysisStatus(
                            'Analyzing population structure...'
                        );


                        await delay(650);

                        updateProgress(35);

                        updateAnalysisStatus(
                            'Calculating birth and mortality indicators...'
                        );


                        await delay(650);

                        updateProgress(52);

                        updateAnalysisStatus(
                            'Analyzing migration patterns...'
                        );


                        await delay(650);

                        updateProgress(70);

                        updateAnalysisStatus(
                            'Evaluating demographic trends...'
                        );


                        await delay(650);

                        updateProgress(86);

                        updateAnalysisStatus(
                            'Generating population forecast...'
                        );


                        await delay(650);

                        updateProgress(96);

                        updateAnalysisStatus(
                            'Preparing demographic intelligence...'
                        );


                        await delay(500);

                        updateProgress(100);


                        /*
                         * Analysis is now complete.
                         */

                        analysisComplete =
                            true;


                        displayBasicData();

                        updateForecast();


                        if (analysisStatus) {

                            analysisStatus.classList.add(
                                'd-none'
                            );

                        }


                        if (aiControl) {

                            aiControl.classList.add(
                                'ai-control-hide'
                            );


                            setTimeout(
                                function () {

                                    aiControl.style.display =
                                        'none';

                                },
                                600
                            );

                        }


                        if (analysisResults) {

                            analysisResults.classList.remove(
                                'd-none'
                            );


                            requestAnimationFrame(
                                function () {

                                    requestAnimationFrame(
                                        function () {

                                            analysisResults.classList.add(
                                                'analysis-visible'
                                            );

                                        }
                                    );

                                }
                            );

                        }

                    }
                );

            }


            /* ==========================================================
               FORECAST PERIOD CHANGE
               ========================================================== */

            if (forecastYears) {

                forecastYears.addEventListener(
                    'change',
                    function () {

                        if (
                            !analysisComplete
                        ) {

                            return;

                        }


                        updateForecast();

                    }
                );

            }

        }
    );

</script>