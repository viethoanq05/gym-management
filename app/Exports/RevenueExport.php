<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class RevenueExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct(string $startDate = null, string $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $start = $this->startDate ?? Carbon::today()->startOfMonth()->toDateString();
        $end = $this->endDate ?? Carbon::today()->toDateString();

        // payments -> memberships -> members -> users ; packages via memberships.package_id
        $rows = DB::table('payments')
            ->leftJoin('memberships', 'payments.membership_id', '=', 'memberships.id')
            ->leftJoin('members', 'memberships.member_id', '=', 'members.id')
            ->leftJoin('users', 'members.user_id', '=', 'users.id')
            ->leftJoin('packages', 'memberships.package_id', '=', 'packages.id')
            ->select(
                'payments.id as transaction_id',
                'users.name as member_name',
                'packages.name as package_name',
                'payments.amount',
                'payments.payment_date'
            )
            ->whereBetween('payment_date', [$start, $end])
            ->orderBy('payments.payment_date', 'desc')
            ->get();

        return collect($rows);
    }

    /**
     * Map the data for each row
     */
    public function map($row): array
    {
        $date = $row->payment_date ? Carbon::parse($row->payment_date)->format('d/m/Y H:i') : '-';
        $amount = is_numeric($row->amount) ? number_format($row->amount, 0, ',', '.') . ' đ' : $row->amount;

        return [
            $row->transaction_id,
            $row->member_name ?? 'Khách vãng lai',
            $row->package_name ?? '-',
            $amount,
            $date,
        ];
    }

    /**
     * Headings for the export
     */
    public function headings(): array
    {
        return [
            'Mã GD',
            'Tên Hội Viên',
            'Gói Tập',
            'Số Tiền',
            'Ngày Thanh Toán',
        ];
    }
}
