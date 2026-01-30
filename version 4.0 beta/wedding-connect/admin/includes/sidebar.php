<!-- Sidebar -->
<div class="col-lg-2">
    <div class="admin-sidebar">
        <div class="text-center mb-4">
            <div class="mb-3">
                <i class="bi bi-shield-lock" style="font-size: 3rem; color: #6f42c1;"></i>
            </div>
            <h5 class="mb-1">Panel de Control</h5>
            <p class="text-muted small">Wedding Connect</p>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link <?php echo $tab == 'dashboard' ? 'active' : ''; ?>" href="admin.php">
                <i class="bi bi-house me-2"></i> Dashboard
            </a>
            <a class="nav-link <?php echo $tab == 'clientes' ? 'active' : ''; ?>" href="admin.php?tab=clientes">
                <i class="bi bi-people me-2"></i> Clientes
            </a>
            <a class="nav-link <?php echo $tab == 'eventos' ? 'active' : ''; ?>" href="admin.php?tab=eventos">
                <i class="bi bi-calendar-event me-2"></i> Eventos
            </a>
            <a class="nav-link <?php echo $tab == 'reportes' ? 'active' : ''; ?>" href="admin.php?tab=reportes">
                <i class="bi bi-bar-chart me-2"></i> Reportes
            </a>
        </nav>
        
        <!-- Reloj de sesión -->
        <div class="mt-4 p-3">
            <small class="text-muted">Sesión activa</small>
            <div id="currentDateTime" class="small"></div>
        </div>
        
        <div class="px-3 mt-4">
            <small class="text-muted d-block mb-2">ESTADÍSTICAS</small>
            <div class="d-flex justify-content-between small">
                <span>Clientes:</span>
                <span class="fw-bold"><?php echo $stats['total_clientes'] ?? 0; ?></span>
            </div>
            <div class="d-flex justify-content-between small">
                <span>Hoy:</span>
                <span class="fw-bold"><?php echo date('d/m/Y'); ?></span>
            </div>
        </div>
    </div>
</div>