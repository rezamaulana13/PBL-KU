<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center justify-content-between p-3 bg-light">
            <h6 class="m-0 fw-semibold text-dark">Pengaturan Tampilan</h6>
            <a href="javascript:void(0);" class="text-muted fs-5 right-bar-toggle">
                <i class="mdi mdi-close"></i>
            </a>
        </div>

        <div class="p-4">
            <!-- Layout -->
            <div class="mb-4">
                <h6 class="text-muted fw-medium mb-3">Tata Letak</h6>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout" id="layout-vertical" value="vertical" checked>
                        <label class="form-check-label" for="layout-vertical">Vertikal</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout" id="layout-horizontal" value="horizontal">
                        <label class="form-check-label" for="layout-horizontal">Horizontal</label>
                    </div>
                </div>
            </div>

            <!-- Mode Warna -->
            <div class="mb-4">
                <h6 class="text-muted fw-medium mb-3">Mode Warna</h6>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout-mode" id="layout-mode-light" value="light" checked onchange="document.body.setAttribute('data-layout-mode', 'light')">
                        <label class="form-check-label" for="layout-mode-light">Terang</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout-mode" id="layout-mode-dark" value="dark" onchange="document.body.setAttribute('data-layout-mode', 'dark')">
                        <label class="form-check-label" for="layout-mode-dark">Gelap</label>
                    </div>
                </div>
            </div>

            <!-- Lebar Layout -->
            <div class="mb-4">
                <h6 class="text-muted fw-medium mb-3">Lebar Halaman</h6>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout-width" id="layout-width-fuild" value="fluid" checked onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                        <label class="form-check-label" for="layout-width-fuild">Penuh</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout-width" id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                        <label class="form-check-label" for="layout-width-boxed">Dibatasi</label>
                    </div>
                </div>
            </div>

            <!-- Posisi Scroll -->
            <div class="mb-4">
                <h6 class="text-muted fw-medium mb-3">Posisi Navigasi</h6>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout-position" id="layout-position-fixed" value="fixed" checked onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                        <label class="form-check-label" for="layout-position-fixed">Tetap</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout-position" id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                        <label class="form-check-label" for="layout-position-scrollable">Menggulir</label>
                    </div>
                </div>
            </div>

            <!-- Warna Topbar -->
            <div class="mb-4">
                <h6 class="text-muted fw-medium mb-3">Warna Header</h6>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="topbar-color" id="topbar-color-light" value="light" checked onchange="document.body.setAttribute('data-topbar', 'light')">
                        <label class="form-check-label" for="topbar-color-light">Terang</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="topbar-color" id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                        <label class="form-check-label" for="topbar-color-dark">Gelap</label>
                    </div>
                </div>
            </div>

            <!-- Ukuran Sidebar -->
            <div class="mb-4">
                <h6 class="text-muted fw-medium mb-3">Ukuran Sidebar</h6>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-default" value="default" checked onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                    <label class="form-check-label" for="sidebar-size-default">Default</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                    <label class="form-check-label" for="sidebar-size-compact">Kompak</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                    <label class="form-check-label" for="sidebar-size-small">Ikon Saja</label>
                </div>
            </div>

            <!-- Warna Sidebar -->
            <div class="mb-4">
                <h6 class="text-muted fw-medium mb-3">Tema Sidebar</h6>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                    <label class="form-check-label" for="sidebar-color-light">Terang</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-dark" value="dark" checked onchange="document.body.setAttribute('data-sidebar', 'dark')">
                    <label class="form-check-label" for="sidebar-color-dark">Gelap</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                    <label class="form-check-label" for="sidebar-color-brand">Bermerek</label>
                </div>
            </div>

            <!-- Arah Teks -->
            <div>
                <h6 class="text-muted fw-medium mb-3">Arah Teks</h6>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout-direction" id="layout-direction-ltr" value="ltr" checked>
                        <label class="form-check-label" for="layout-direction-ltr">Kiri ke Kanan</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="layout-direction" id="layout-direction-rtl" value="rtl">
                        <label class="form-check-label" for="layout-direction-rtl">Kanan ke Kiri</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
