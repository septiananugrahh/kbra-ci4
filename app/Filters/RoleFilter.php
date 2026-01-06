<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userRoles = session('roles'); // array of user roles, misalnya ['admin', 'guru']

        if (!$userRoles) {
            return redirect()->to('/login');
        }

        // Jika tidak ada parameter role diberikan di routes, izinkan akses
        if (!$arguments) {
            return;
        }

        // Cek apakah salah satu dari role user cocok dengan yang diizinkan
        $allowed = array_map('strtolower', $arguments);
        $userHasAccess = array_intersect($allowed, array_map('strtolower', $userRoles));

        if (empty($userHasAccess)) {
            return redirect()->to('/akses-ditolak')->with('message', 'Akses ditolak. Anda tidak memiliki izin.');
        }

        // Izinkan akses
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu untuk after
    }
}
