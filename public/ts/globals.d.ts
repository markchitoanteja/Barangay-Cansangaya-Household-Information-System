// public/ts/globals.d.ts

/// <reference types="jquery" />

declare const APP_DEBUG: boolean;
declare const ROLE: string;
declare const BASE_URL: string;
declare const Swal: any;
declare const flashData: { title: string; text: string; icon: string } | undefined;
declare const Chart: any;
declare const dashboardData: any;
declare const genderData: any;
declare const residentStatus: any;
declare const employmentDataRaw: any;
declare const birthsRaw: any;
declare const deathsRaw: any;

interface DemographicData {
    population: number;
    year: number;
    births: number;
    deaths: number;
    migrationIn: number;
    migrationOut: number;
    children: number;
    seniors: number;
    workingAge: number;
    employed: number;
    male: number;
    female: number;
    households: number;
    chronic: number;
}

declare const dbData: DemographicData;
