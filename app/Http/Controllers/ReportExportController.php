<?php

namespace App\Http\Controllers;

use App\Enums\PermissionType;
use App\Enums\SamplingConclusion;
use App\Enums\UserRole;
use App\Exports\FindingsCapaExport;
use App\Exports\PublicSupervisionExport;
use App\Exports\SupervisionReportExport;
use App\Models\Facility;
use App\Models\Inspection;
use App\Models\InspectionFinding;
use App\Models\Sampling;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class ReportExportController extends Controller
{
    /**
     * Export Executive Supervision Report to Excel (.xlsx).
     */
    public function exportExecutiveReportExcel(Request $request): BinaryFileResponse
    {
        $this->authorizeLeadershipOrAdmin();

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $regency = $request->query('regency');
        $conclusion = $request->query('conclusion');

        $fileName = 'Laporan_Pengawasan_BBPOM_Palangka_Raya_'.date('Ymd_His').'.xlsx';

        return Excel::download(
            new SupervisionReportExport($startDate, $endDate, $regency, $conclusion),
            $fileName
        );
    }

    /**
     * Export Executive Supervision Report to PDF.
     */
    public function exportExecutiveReportPdf(Request $request): Response
    {
        $this->authorizeLeadershipOrAdmin();

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $regency = $request->query('regency');
        $conclusion = $request->query('conclusion');

        $inspectionQuery = Inspection::with(['facility', 'inspector', 'findings', 'capaClosure'])
            ->latest('inspection_date');
        $samplingQuery = Sampling::with(['foodType.category', 'inspector', 'testResults'])
            ->latest('sampling_date');

        if ($startDate) {
            $inspectionQuery->whereDate('inspection_date', '>=', $startDate);
            $samplingQuery->whereDate('sampling_date', '>=', $startDate);
        }
        if ($endDate) {
            $inspectionQuery->whereDate('inspection_date', '<=', $endDate);
            $samplingQuery->whereDate('sampling_date', '<=', $endDate);
        }
        if ($regency) {
            $inspectionQuery->whereHas('facility', fn ($q) => $q->where('regency', $regency));
            $samplingQuery->where('sampling_location', 'like', "%{$regency}%");
        }
        if ($conclusion) {
            $inspectionQuery->where('conclusion', 'like', "%{$conclusion}%");
            $samplingQuery->where('conclusion', $conclusion);
        }

        $inspections = $inspectionQuery->get();
        $samplings = $samplingQuery->get();

        $totalInspections = $inspections->count();
        $inspectionsMs = $inspections->filter(fn ($i) => ! str_contains(strtolower($i->conclusion ?? ''), 'tidak'))->count();
        $inspectionsTms = $totalInspections - $inspectionsMs;

        $totalSamplings = $samplings->count();
        $samplingsMs = $samplings->where('conclusion', SamplingConclusion::Compliant)->count();
        $samplingsTms = $samplings->where('conclusion', SamplingConclusion::NonCompliant)->count();

        $stats = [
            'total_inspections' => $totalInspections,
            'inspections_ms' => $inspectionsMs,
            'inspections_tms' => $inspectionsTms,
            'total_samplings' => $totalSamplings,
            'samplings_ms' => $samplingsMs,
            'samplings_tms' => $samplingsTms,
        ];

        $headUser = User::where('role', UserRole::Head)->first();

        $pdf = Pdf::loadView('pdf.executive-report', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'regency' => $regency,
            'conclusion' => $conclusion,
            'stats' => $stats,
            'inspections' => $inspections,
            'samplings' => $samplings,
            'headUser' => $headUser,
        ])->setPaper('a4', 'landscape');

        $fileName = 'Laporan_Pengawasan_BBPOM_Palangka_Raya_'.date('Ymd_His').'.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Export Official BAP PDF for a specific Inspection.
     */
    public function exportBapPdf(string $id): Response
    {
        $inspection = Inspection::with(['facility', 'inspector', 'findings.requirement', 'bapDocument'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.bap-document', [
            'inspection' => $inspection,
        ])->setPaper('a4', 'portrait');

        $safeNumber = str_replace(['/', '\\'], '_', $inspection->inspection_number);

        return $pdf->stream('BAP_'.$safeNumber.'.pdf');
    }

    /**
     * Export Sampling Laboratory Test Report PDF.
     */
    public function exportSamplingPdf(string $id): Response
    {
        $sampling = Sampling::with(['foodType.category', 'inspector', 'testResults.testParameter'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.sampling-report', [
            'sampling' => $sampling,
        ])->setPaper('a4', 'portrait');

        $safeNumber = str_replace(['/', '\\'], '_', $sampling->sampling_number);

        return $pdf->stream('Laporan_Uji_'.$safeNumber.'.pdf');
    }

    /**
     * Export Facility CAPA findings to Excel (.xlsx) for Business Portal.
     */
    public function exportPortalCapaExcel(Request $request): BinaryFileResponse
    {
        $user = Auth::user();
        if (! $user) {
            abort(403);
        }

        $facilityIds = $user->facilities->pluck('id')->toArray();
        if ($user->role === UserRole::Admin) {
            $facilityIds = null;
        }

        return Excel::download(
            new FindingsCapaExport($facilityIds),
            'Laporan_CAPA_'.date('Ymd_His').'.xlsx'
        );
    }

    /**
     * Export Facility CAPA findings to PDF for Business Portal.
     */
    public function exportPortalCapaPdf(Request $request): Response
    {
        $user = Auth::user();
        if (! $user) {
            abort(403);
        }

        $facilityQuery = $user->facilities();
        $facility = $facilityQuery->first();
        $facilityIds = $user->facilities->pluck('id')->toArray();

        $findingsQuery = InspectionFinding::with(['inspection.facility', 'requirement', 'capaSubmissions'])
            ->latest('created_at');

        if ($user->role !== UserRole::Admin && count($facilityIds) > 0) {
            $findingsQuery->whereHas('inspection', fn ($q) => $q->whereIn('facility_id', $facilityIds));
        }

        $findings = $findingsQuery->get();

        $pdf = Pdf::loadView('pdf.capa-report', [
            'findings' => $findings,
            'facilityName' => $facility?->name ?? 'Pelaku Usaha',
            'picName' => $facility?->pic_name ?? $user->name,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_CAPA_'.date('Ymd_His').'.pdf');
    }

    /**
     * Export Public Supervision Results to Excel (.xlsx).
     */
    public function exportPublicExcel(Request $request): BinaryFileResponse
    {
        $type = $request->query('type', 'all');
        $search = $request->query('search');
        $regency = $request->query('regency');
        $conclusion = $request->query('conclusion');

        return Excel::download(
            new PublicSupervisionExport($type, $search, $regency, $conclusion),
            'Hasil_Pengawasan_Pangan_BBPOM_'.date('Ymd_His').'.xlsx'
        );
    }

    /**
     * Export Public Supervision Results to PDF.
     */
    public function exportPublicPdf(Request $request): Response
    {
        $type = $request->query('type', 'all');
        $search = $request->query('search');
        $regency = $request->query('regency');
        $conclusion = $request->query('conclusion');

        $exporter = new PublicSupervisionExport($type, $search, $regency, $conclusion);
        $items = $exporter->collection();

        $pdf = Pdf::loadView('pdf.public-supervision', [
            'items' => $items,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Hasil_Pengawasan_Pangan_BBPOM_'.date('Ymd_His').'.pdf');
    }

    /**
     * Helper to verify leadership or admin role.
     */
    protected function authorizeLeadershipOrAdmin(): void
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        if (! $user->hasPermissionTo(PermissionType::ExportReports->value)) {
            abort(403, 'Akses terbatas untuk Petugas BBPOM dan Pimpinan.');
        }
    }
}
