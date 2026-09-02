---
created: 2026-09-02
---
# Architecture Decisions

## Template
### [2026-09-02] Initial Knowledge Base
**Context**: Membangun persistent project memory untuk KBRA menggunakan Obsidian via MCP.
**Decision**: Dokumentasi fitur berdasarkan source code, database, routes, controllers, models, views, dan migrations saja. Tidak membuat asumsi modul yang tidak ada.
**Reason**: Menghindari hallucination dan menjaga akurasi knowledge base.
**Impact**: Knowledge base hanya mencakup modul yang benar-benar terverifikasi dari source code.
