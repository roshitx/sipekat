<?php
namespace App\Enums;

enum ComplaintStatus:string
{
    const BELUM_DIPROSES = 'Belum Diproses';
    const SEDANG_DIPROSES = 'Sedang Diproses';
    const SELESAI = 'Selesai';
}
