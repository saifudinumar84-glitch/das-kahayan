<?php

namespace Database\Seeders;

use App\Models\TestParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestParameterSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed laboratory test parameters commonly used by BBPOM Palangka Raya.
     *
     * @return void
     */
    public function run(): void
    {
        $parameters = [
            // === KIMIA — Bahan Tambahan Pangan (BTP) Tidak Diizinkan ===
            ['code' => 'BTP-001', 'name' => 'Boraks (Asam Borat)', 'result_unit' => 'Kualitatif (positif/negatif)'],
            ['code' => 'BTP-002', 'name' => 'Formalin (Formaldehida)', 'result_unit' => 'Kualitatif (positif/negatif)'],
            ['code' => 'BTP-003', 'name' => 'Rhodamin B', 'result_unit' => 'Kualitatif (positif/negatif)'],
            ['code' => 'BTP-004', 'name' => 'Methanyl Yellow', 'result_unit' => 'Kualitatif (positif/negatif)'],
            ['code' => 'BTP-005', 'name' => 'Sudan I/II/III/IV', 'result_unit' => 'Kualitatif (positif/negatif)'],
            ['code' => 'BTP-006', 'name' => 'Dulsin', 'result_unit' => 'Kualitatif (positif/negatif)'],

            // === KIMIA — BTP yang Diizinkan (Batas Maksimum) ===
            ['code' => 'BTP-010', 'name' => 'Natrium Benzoat', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-011', 'name' => 'Kalium Sorbat', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-012', 'name' => 'Nipagin (Metilparaben)', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-013', 'name' => 'Asam Sorbat', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-014', 'name' => 'Tartrazin (FD&C Yellow No.5)', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-015', 'name' => 'Sunset Yellow FCF', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-016', 'name' => 'Ponceau 4R', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-017', 'name' => 'Natrium Nitrit', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-018', 'name' => 'Natrium Nitrat', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-019', 'name' => 'Sakarin', 'result_unit' => 'mg/kg'],
            ['code' => 'BTP-020', 'name' => 'Siklamat', 'result_unit' => 'mg/kg'],

            // === KIMIA — Cemaran Kimia ===
            ['code' => 'CEM-001', 'name' => 'Timbal (Pb)', 'result_unit' => 'mg/kg'],
            ['code' => 'CEM-002', 'name' => 'Kadmium (Cd)', 'result_unit' => 'mg/kg'],
            ['code' => 'CEM-003', 'name' => 'Merkuri (Hg)', 'result_unit' => 'mg/kg'],
            ['code' => 'CEM-004', 'name' => 'Arsen (As)', 'result_unit' => 'mg/kg'],
            ['code' => 'CEM-005', 'name' => 'Tin (Sn)', 'result_unit' => 'mg/kg'],
            ['code' => 'CEM-006', 'name' => 'Aflatoksin Total (B1+B2+G1+G2)', 'result_unit' => 'µg/kg (ppb)'],
            ['code' => 'CEM-007', 'name' => 'Histamin', 'result_unit' => 'mg/kg'],

            // === KIMIA — Gizi dan Identitas ===
            ['code' => 'GIZ-001', 'name' => 'Kadar Air', 'result_unit' => '% (b/b)'],
            ['code' => 'GIZ-002', 'name' => 'Kadar Protein', 'result_unit' => '% (b/b)'],
            ['code' => 'GIZ-003', 'name' => 'Kadar Lemak', 'result_unit' => '% (b/b)'],
            ['code' => 'GIZ-004', 'name' => 'Kadar Karbohidrat', 'result_unit' => '% (b/b)'],
            ['code' => 'GIZ-005', 'name' => 'Kadar Abu', 'result_unit' => '% (b/b)'],
            ['code' => 'GIZ-006', 'name' => 'Energi Total', 'result_unit' => 'kkal/100g'],
            ['code' => 'GIZ-007', 'name' => 'Natrium (Na)', 'result_unit' => 'mg/100g'],
            ['code' => 'GIZ-008', 'name' => 'Iodium (I) — pada garam', 'result_unit' => 'mg/kg'],
            ['code' => 'GIZ-009', 'name' => 'Vitamin C', 'result_unit' => 'mg/100g'],
            ['code' => 'GIZ-010', 'name' => 'Vitamin A', 'result_unit' => 'IU/100g'],

            // === MIKROBIOLOGI ===
            ['code' => 'MIK-001', 'name' => 'Angka Lempeng Total (ALT)', 'result_unit' => 'koloni/g atau koloni/mL'],
            ['code' => 'MIK-002', 'name' => 'Escherichia coli', 'result_unit' => 'APM/g atau APM/mL'],
            ['code' => 'MIK-003', 'name' => 'Salmonella sp.', 'result_unit' => 'per 25g'],
            ['code' => 'MIK-004', 'name' => 'Staphylococcus aureus', 'result_unit' => 'koloni/g'],
            ['code' => 'MIK-005', 'name' => 'Kapang dan Khamir', 'result_unit' => 'koloni/g'],
            ['code' => 'MIK-006', 'name' => 'Coliform', 'result_unit' => 'APM/g atau APM/mL'],
            ['code' => 'MIK-007', 'name' => 'Bacillus cereus', 'result_unit' => 'koloni/g'],
            ['code' => 'MIK-008', 'name' => 'Listeria monocytogenes', 'result_unit' => 'per 25g'],
            ['code' => 'MIK-009', 'name' => 'Clostridium perfringens', 'result_unit' => 'koloni/g'],
            ['code' => 'MIK-010', 'name' => 'Vibrio cholerae', 'result_unit' => 'per 25g'],

            // === FISIKA ===
            ['code' => 'FIS-001', 'name' => 'pH', 'result_unit' => 'nilai pH'],
            ['code' => 'FIS-002', 'name' => 'Aktivitas Air (Aw)', 'result_unit' => 'nilai Aw (0-1)'],
            ['code' => 'FIS-003', 'name' => 'Berat Bersih / Netto', 'result_unit' => 'gram atau mL'],
        ];

        foreach ($parameters as $param) {
            TestParameter::firstOrCreate(
                ['code' => $param['code']],
                array_merge($param, ['is_active' => true])
            );
        }
    }
}
