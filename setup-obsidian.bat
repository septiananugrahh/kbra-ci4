@echo off
setlocal EnableExtensions

title KBRA - Obsidian + MCP + GitHub Copilot Setup

echo.
echo ============================================================
echo       KBRA - OBSIDIAN + MCP + GITHUB COPILOT SETUP
echo ============================================================
echo.

REM ============================================================
REM ROOT PROJECT
REM ============================================================

set "ROOT=%CD%"

echo Project:
echo %ROOT%
echo.

REM ============================================================
REM CREATE DIRECTORIES
REM ============================================================

echo [1/7] Membuat folder...

mkdir ".ai" 2>nul
mkdir ".ai\modules" 2>nul
mkdir ".ai\infrastructure" 2>nul
mkdir ".ai\memory" 2>nul

mkdir ".vscode" 2>nul
mkdir ".github" 2>nul

echo       OK
echo.

REM ============================================================
REM MAIN OBSIDIAN FILES
REM ============================================================

echo [2/7] Membuat file utama Obsidian...

if not exist ".ai\PROJECT.md" (
    (
        echo # KBRA Project
        echo.
        echo ## Project
        echo KBRA - KB / RA Islamic Center
        echo.
        echo ## Purpose
        echo Dokumentasi dan persistent AI memory untuk aplikasi administrasi TK (KB/RA Islamic Center) dan asesmen.
        echo.
        echo ## Stack
        echo - PHP 8
        echo - CodeIgniter 4
        echo - MySQL / MariaDB
        echo - Bootstrap 5 + Sneat Template
        echo - jQuery
        echo - DomPDF
        echo.
        echo ## AI Memory
        echo Knowledge base project disimpan di folder `.ai`.
        echo.
        echo ## Related Notes
        echo - [[ARCHITECTURE]]
        echo - [[DECISIONS]]
        echo - [[TODO]]
        echo - [[BUGS]]
    ) > ".ai\PROJECT.md"
)

if not exist ".ai\ARCHITECTURE.md" (
    (
        echo # Architecture
        echo.
        echo ## Overview
        echo Aplikasi administrasi TK (KB/RA Islamic Center): santri, pegawai, modul ajar, asesmen, laporan.
        echo.
        echo ## Backend
        echo CodeIgniter 4 (MVC, PHP 8)
        echo.
        echo ## Frontend
        echo Bootstrap 5 + Sneat Template + jQuery
        echo.
        echo ## Database
        echo MySQL / MariaDB (file skema: new_kbra.sql)
        echo.
        echo ## PDF
        echo DomPDF (laporan, rapor, asesmen)
        echo.
        echo ## Modules
        echo - [[modules/SANTRI]]
        echo - [[modules/KELAS]]
        echo - [[modules/PEGAWAI]]
        echo - [[modules/MODUL_AJAR]]
        echo - [[modules/ASESMEN]]
        echo - [[modules/TUJUAN_PEMBELAJARAN]]
        echo - [[modules/LAPORAN_BULANAN]]
        echo - [[modules/KURIKULUM_CINTA]]
        echo.
        echo ## Infrastructure
        echo - [[infrastructure/SERVER]]
        echo - [[infrastructure/DATABASE]]
        echo - [[infrastructure/LARAGON]]
    ) > ".ai\ARCHITECTURE.md"
)

if not exist ".ai\DECISIONS.md" (
    (
        echo # Architecture Decisions
        echo.
        echo Dokumentasi keputusan penting dalam pengembangan KBRA.
        echo.
        echo ## Decisions
        echo.
        echo ### Template
        echo.
        echo #### [Tanggal] Judul
        echo.
        echo **Context**
        echo.
        echo **Decision**
        echo.
        echo **Reason**
        echo.
        echo **Impact**
        echo.
    ) > ".ai\DECISIONS.md"
)

if not exist ".ai\TODO.md" (
    (
        echo # TODO
        echo.
        echo ## High Priority
        echo.
        echo - [ ]
        echo.
        echo ## Normal
        echo.
        echo - [ ]
        echo.
        echo ## Completed
        echo.
    ) > ".ai\TODO.md"
)

if not exist ".ai\BUGS.md" (
    (
        echo # Known Bugs
        echo.
        echo Dokumentasi bug dan solusi yang pernah ditemukan.
        echo.
        echo ## Template
        echo.
        echo ### Bug
        echo.
        echo **Problem:**
        echo.
        echo **Cause:**
        echo.
        echo **Solution:**
        echo.
        echo **Files:**
        echo.
        echo **Notes:**
        echo.
    ) > ".ai\BUGS.md"
)

echo       OK
echo.

REM ============================================================
REM MODULE FILES
REM ============================================================

echo [3/7] Membuat module memory...

call :CREATE_MODULE ".ai\modules\SANTRI.md" "Santri"
call :CREATE_MODULE ".ai\modules\KELAS.md" "Kelas"
call :CREATE_MODULE ".ai\modules\PEGAWAI.md" "Pegawai"
call :CREATE_MODULE ".ai\modules\MODUL_AJAR.md" "Modul Ajar"
call :CREATE_MODULE ".ai\modules\ASESMEN.md" "Asesmen"
call :CREATE_MODULE ".ai\modules\TUJUAN_PEMBELAJARAN.md" "Tujuan Pembelajaran"
call :CREATE_MODULE ".ai\modules\LAPORAN_BULANAN.md" "Laporan Bulanan"
call :CREATE_MODULE ".ai\modules\KURIKULUM_CINTA.md" "Kurikulum Cinta"

echo       OK
echo.

REM ============================================================
REM INFRASTRUCTURE FILES
REM ============================================================

echo [4/7] Membuat infrastructure memory...

call :CREATE_MODULE ".ai\infrastructure\SERVER.md" "Server"
call :CREATE_MODULE ".ai\infrastructure\DATABASE.md" "Database"
call :CREATE_MODULE ".ai\infrastructure\LARAGON.md" "Laragon"

echo       OK
echo.

REM ============================================================
REM VSCODE MCP
REM ============================================================

echo [5/7] Membuat konfigurasi VS Code MCP...

(
    echo {
    echo   "servers": {
    echo     "obsidian": {
    echo       "type": "http",
    echo       "url": "http://127.0.0.1:27124/mcp",
    echo       "headers": {
    echo         "Authorization": "Bearer ca9d3e9dfdd55c8dceddf4c82edce85f05aefab073207f77798abc428791b1e4"
    echo       }
    echo     }
    echo   }
    echo }
) > ".vscode\mcp.json"

echo       OK
echo.

REM ============================================================
REM COPILOT INSTRUCTIONS
REM ============================================================

echo [6/7] Membuat GitHub Copilot instructions...

(
    echo # KBRA - GitHub Copilot Instructions
    echo.
    echo ## Project Memory
    echo.
    echo Persistent project knowledge is stored in the Obsidian vault:
    echo.
    echo `.ai/`
    echo.
    echo Important memory files:
    echo.
    echo - `.ai/PROJECT.md`
    echo - `.ai/ARCHITECTURE.md`
    echo - `.ai/DECISIONS.md`
    echo - `.ai/TODO.md`
    echo - `.ai/BUGS.md`
    echo - `.ai/modules/`
    echo - `.ai/infrastructure/`
    echo.
    echo ## MCP
    echo.
    echo An Obsidian MCP server is available through:
    echo.
    echo `http://127.0.0.1:27123/mcp`
    echo.
    echo Use Obsidian MCP when project knowledge or historical decisions are needed.
    echo.
    echo ## Rules
    echo.
    echo 1. Inspect relevant project memory before making major architectural changes.
    echo.
    echo 2. Do not invent project architecture when documented information exists.
    echo.
    echo 3. When an important architectural decision is made, update:
    echo `.ai/DECISIONS.md`
    echo.
    echo 4. When a reusable bug solution is discovered, update:
    echo `.ai/BUGS.md`
    echo.
    echo 5. When architecture changes, update:
    echo `.ai/ARCHITECTURE.md`
    echo.
    echo 6. Keep documentation concise and factual.
    echo.
    echo 7. Do not modify project memory unnecessarily.
    echo.
    echo ## Project Stack
    echo.
    echo - PHP 8
    echo - CodeIgniter 4
    echo - MySQL / MariaDB
    echo - Bootstrap 5 + Sneat Template
    echo - jQuery
    echo - DomPDF
    echo.
    echo ## AI Workflow
    echo.
    echo Before implementing a significant feature:
    echo.
    echo 1. Understand the existing source code.
    echo 2. Search relevant Obsidian project memory.
    echo 3. Check architecture decisions.
    echo 4. Implement the change.
    echo 5. Update project memory when necessary.
) > ".github\copilot-instructions.md"

echo       OK
echo.

REM ============================================================
REM GIT CHECK
REM ============================================================

echo [7/7] Memeriksa Git...

if exist ".git" (
    echo.
    echo Git repository ditemukan.
    echo `.ai` AKAN ikut di-version control.
    echo.
) else (
    echo.
    echo Git repository tidak ditemukan.
    echo Ini bukan masalah.
    echo.
)

REM ============================================================
REM FINISH
REM ============================================================

echo ============================================================
echo                    SETUP SELESAI
echo ============================================================
echo.
echo Obsidian Vault:
echo %ROOT%\.ai
echo.
echo VS Code MCP:
echo %ROOT%\.vscode\mcp.json
echo.
echo Copilot Instructions:
echo %ROOT%\.github\copilot-instructions.md
echo.
echo ============================================================
echo LANGKAH SELANJUTNYA
echo ============================================================
echo.
echo 1. Buka Obsidian.
echo.
echo 2. Pilih:
echo    Open folder as vault
echo.
echo 3. Pilih:
echo    %ROOT%\.ai
echo.
echo 4. Aktifkan Obsidian MCP Server.
echo.
echo 5. Pastikan MCP server menggunakan:
echo    http://127.0.0.1:27123/mcp
echo.
echo 6. Buka:
echo    %ROOT%\.vscode\mcp.json
echo.
echo 7. Ganti:
echo    YOUR_OBSIDIAN_MCP_TOKEN
echo.
echo    dengan token MCP Obsidian Anda.
echo.
echo 8. Restart VS Code.
echo.
echo 9. Buka GitHub Copilot Chat.
echo.
echo 10. Gunakan Agent Mode dan test:
echo.
echo    "Gunakan MCP Obsidian dan baca PROJECT.md.
echo     Jelaskan project KBRA yang kamu pahami."
echo.
echo ============================================================
echo.

pause
exit /b


REM ============================================================
REM FUNCTION CREATE MODULE
REM ============================================================

:CREATE_MODULE

if not exist "%~1" (
    (
        echo # %~2
        echo.
        echo ## Overview
        echo.
        echo ## Business Rules
        echo.
        echo ## Database
        echo.
        echo ## Backend
        echo.
        echo ## Frontend
        echo.
        echo ## Related Modules
        echo.
        echo ## Important Decisions
        echo.
        echo ## Known Problems
        echo.
        echo ## Notes
        echo.
    ) > "%~1"
)

exit /b