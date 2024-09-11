<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
      <span class="brand-text font-weight-light">Gatepass</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <!-- Add User Info Here -->
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
              data-accordion="false">

              <!-- Admin and Security Access: Flat Details -->
              @if (Auth::user()->role == 1)
                  <li class="nav-item">
                      <a href="#" class="nav-link active">
                          <i class="bi bi-buildings-fill nav-icon"></i>
                          <p>
                              Flat details
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('flat.index') }}" class="nav-link active">
                                  <i class="bi bi-building-fill-add nav-icon"></i>
                                  <p>Flat List</p>
                              </a>
                          </li>
                          </ul>
                  </li>
              @endif

              <!-- Flat Owners and Details: Accessible to Admin and Flat Owner -->
              @if (Auth::user()->role == 1)
                  <li class="nav-item">
                      <a href="{{ route('owner_crud.index') }}" class="nav-link">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              Flat Owners and Details
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('owner_crud.index') }}" class="nav-link">
                                  <i class="bi bi-building-fill-add nav-icon"></i>
                                  <p>All Details</p>
                              </a>
                          </li>
                          </ul>
                  </li>
              @endif

              <!-- Guest Details: Admin, Security, and Flat Owner Access -->
              @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="bi bi-person-fill nav-icon"></i>
                          <p>
                              Guest Details
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('flatguest.index') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Guest List</p>
                              </a>
                          </li>
                          </ul>
                  </li>
              @endif

              <!-- Security Check: Only Security Role -->
              @if (Auth::user()->role == 1 || Auth::user()->role == 3)
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-lock-fill"></i>
                          <p>
                              Security Check
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('securitycheck.otpview') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>OTP Verification</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              @endif
              @if (Auth::user()->role == 1 )
              <li class="nav-item">
                <a href="{{ route('security.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Security List</p>
                </a>
            </li>
            @endif
              <!-- Logout: Accessible to All -->
              <li class="nav-item">
                  <a href="{{ route('logout') }}" class="nav-link">
                      <i class="nav-icon fas fa-sign-out-alt"></i>
                      <p>Logout</p>
                  </a>
              </li>
          </ul>
      </nav>
  </div>
</aside>
