<?= $this->extend('layout') ?>
<?= $this->section('content') ?>


<section class="section profile">
  <div class="row">
    <div class="col-xl-8">
      <div class="mb-5">
        <h1 class="display-5 fw-bold text-dark mb-1" style="letter-spacing: -1.5px;">
          <?= esc(session()->get('username')) ?>
        </h1>
        <p class="fs-5 text-muted fw-light">
          <?= esc(session()->get('email')) ?>
        </p>
      </div>

      <div class="row g-0">
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="text-uppercase tracking-wider small fw-bold text-muted mb-2"
            style="font-size: 0.7rem; letter-spacing: 1px;">
            Role Account
          </div>
          <div class="d-inline-block border border-2 px-3 py-1 rounded-1 fw-bold text-dark" style="font-size: 0.9rem;">
            <?= strtoupper((string) esc(session()->get('role'))) ?>
          </div>
        </div>

        <div class="col-md-5 mb-4 mb-md-0 border-start-md ps-md-4">
          <div class="text-uppercase small fw-bold text-muted mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">
            Last Authentication
          </div>
          <div class="fw-medium text-dark">
            <?= esc(session()->get('login_time')) ?>
          </div>
        </div>

        <div class="col-md-3 border-start-md ps-md-4">
          <div class="text-uppercase small fw-bold text-muted mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">
            Connectivity
          </div>
          <?php if (session()->get('isLoggedIn')): ?>
            <div class="fw-bold text-success d-flex align-items-center gap-2">
              <div style="width: 8px; height: 8px; background-color: currentColor; border-radius: 50%;"></div>
              ACTIVE SESSION
            </div>
          <?php else: ?>
            <div class="fw-bold text-secondary d-flex align-items-center gap-2">
              <div style="width: 8px; height: 8px; background-color: currentColor; border-radius: 50%;"></div>
              OFFLINE
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>