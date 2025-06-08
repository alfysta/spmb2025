<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        $provincesResponse = Http::get('https://wilayah.id/api/provinces.json')->json();

        if (!isset($provincesResponse['data']) || !is_array($provincesResponse['data'])) {
            $this->command->error("Gagal mengambil data provinsi");
            return;
        }

        $provinces = $provincesResponse['data'];

        foreach ($provinces as $province) {
            if (!isset($province['code'], $province['name'])) {
                $this->command->warn("Data provinsi tidak lengkap, dilewati");
                continue;
            }

            $prov = Province::updateOrCreate(
                ['code' => $province['code']],
                ['name' => $province['name']]
            );

            // Selanjutnya untuk regencies, districts, villages juga sama,
            // Ambil data dari ['data'] pada response JSON

            $regenciesResponse = Http::get("https://wilayah.id/api/regencies/{$province['code']}.json")->json();

            if (!isset($regenciesResponse['data']) || !is_array($regenciesResponse['data'])) {
                $this->command->warn("Gagal ambil kabupaten/kota untuk provinsi {$province['code']}");
                continue;
            }

            $regencies = $regenciesResponse['data'];

            foreach ($regencies as $regency) {
                if (!isset($regency['code'], $regency['name'])) {
                    $this->command->warn("Data kabupaten/kota tidak lengkap, dilewati");
                    continue;
                }

                $reg = Regency::updateOrCreate(
                    ['code' => $regency['code']],
                    ['name' => $regency['name'], 'province_id' => $prov->id]
                );

                $districtsResponse = Http::get("https://wilayah.id/api/districts/{$regency['code']}.json")->json();

                if (!isset($districtsResponse['data']) || !is_array($districtsResponse['data'])) {
                    $this->command->warn("Gagal ambil kecamatan untuk kabupaten/kota {$regency['code']}");
                    continue;
                }

                $districts = $districtsResponse['data'];

                foreach ($districts as $district) {
                    if (!isset($district['code'], $district['name'])) {
                        $this->command->warn("Data kecamatan tidak lengkap, dilewati");
                        continue;
                    }

                    $dist = District::updateOrCreate(
                        ['code' => $district['code']],
                        ['name' => $district['name'], 'regency_id' => $reg->id]
                    );

                    $villagesResponse = Http::get("https://wilayah.id/api/villages/{$district['code']}.json")->json();

                    if (!isset($villagesResponse['data']) || !is_array($villagesResponse['data'])) {
                        $this->command->warn("Gagal ambil desa untuk kecamatan {$district['code']}");
                        continue;
                    }

                    $villages = $villagesResponse['data'];

                    foreach ($villages as $village) {
                        if (!isset($village['code'], $village['name'])) {
                            $this->command->warn("Data desa tidak lengkap, dilewati");
                            continue;
                        }

                        Village::updateOrCreate(
                            ['code' => $village['code']],
                            [
                                'name' => $village['name'],
                                'postal_code' => $village['postal_code'] ?? null,
                                'district_id' => $dist->id,
                            ]
                        );
                    }
                }
            }
        }
    }
}
